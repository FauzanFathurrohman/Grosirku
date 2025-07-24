<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use App\Models\Order; 
use App\Models\OrderItem; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\Rule; 
use Illuminate\Support\Collection; 

class CartController extends Controller
{
    /**
     * Konstruktor untuk CartController.
     * Mengatur middleware 'auth' kecuali untuk metode 'cart' dan 'add' (karena keranjang session juga bisa diakses tamu).
     */
    public function __construct()
    {
        // Middleware 'auth' hanya berlaku untuk metode 'checkout' dan 'success'
        // Karena metode lain (cart, add, update, remove, clear) bisa diakses tamu untuk mengelola keranjang sesi.
        $this->middleware('auth')->only(['checkout', 'success']);
    }

    /**
     * Menampilkan isi keranjang belanja.
     * Mengambil data produk dari session dan mengubahnya menjadi koleksi CartItem (objek sementara).
     *
     * @return \Illuminate\View\View
     */
    public function cart()
    {
        $rawCartItems = []; // Gunakan nama berbeda untuk array mentah
        $cart = session()->get('cart', []);

        $productIds = array_keys($cart);

        // Ambil semua produk dari database berdasarkan ID yang ada di keranjang
        // Gunakan whereIn untuk efisiensi, dan keyBy untuk akses cepat berdasarkan ID produk
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Buat koleksi item keranjang yang rapi dengan objek produk lengkap
        foreach ($cart as $productId => $item) {
            $product = $products[$productId] ?? null; // Dapatkan objek produk atau null jika tidak ditemukan

            // Hanya proses item jika produk ditemukan di database
            if ($product) {
                // Pastikan 'quantity' ada di item sesi, default ke 1 jika tidak
                $quantity = $item['quantity'] ?? 1;

                $rawCartItems[] = (object) [
                    'id' => $productId, // ID item di keranjang (sama dengan ID produk)
                    'product' => $product,
                    'quantity' => $quantity,
                    // PENTING: Tambahkan harga dari produk ke objek cartItem
                    'price' => $product->price,
                ];
            } else {
                // Log atau hapus item dari session jika produk tidak valid
                Log::warning("Produk dengan ID {$productId} tidak ditemukan di database, dihapus dari keranjang sesi.");
                session()->forget("cart.{$productId}"); // Hapus item yang tidak valid dari session
            }
        }

        // Konversi array mentah menjadi Laravel Collection
        $cartItems = Collection::make($rawCartItems);

        // Jika ada perubahan pada sesi keranjang (misal: produk dihapus karena tidak valid), simpan kembali sesi
        session()->put('cart', array_filter(session()->get('cart', []))); // Membersihkan entri null jika ada

        // PERBAIKAN: Mengubah 'cart.cart' menjadi 'cart' karena nama file Blade Anda adalah cart.blade.php
        return view('cart.cart', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang belanja.
     * Memeriksa ketersediaan stok sebelum menambahkan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product (Route Model Binding)
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'nullable|integer|min:1', // Quantity bisa opsional, default 1
        ]);

        $quantityToAdd = $request->input('quantity', 1); // Default 1 jika tidak disediakan

        $cart = session()->get('cart', []);
        $currentQuantityInCart = $cart[$product->id]['quantity'] ?? 0;
        $newQuantity = $currentQuantityInCart + $quantityToAdd;

        // Cek stok produk
        if ($product->stock <= 0) {
            return back()->with('error', 'Maaf, stok produk ini sedang habis.');
        }

        if ($newQuantity > $product->stock) {
            return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia (' . $product->stock . ').');
        }

        // PENTING: Simpan harga produk di sesi keranjang
        $cart[$product->id] = [
            'quantity' => $newQuantity,
            'price' => $product->price, // Pastikan harga produk disimpan di sini!
            'name' => $product->name, // Simpan nama juga untuk kemudahan debug/tampilan
            'image' => $product->image, // Opsional: Simpan path gambar
        ];

        session()->put('cart', $cart);
        // Mengarahkan kembali ke halaman keranjang setelah menambah
        return redirect()->route('cart.cart')->with('status', $quantityToAdd . 'x ' . $product->name . ' ditambahkan ke keranjang.');
    }

    /**
     * Memperbarui jumlah produk dalam keranjang.
     * Memeriksa ketersediaan stok saat memperbarui.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return redirect()->route('cart.cart')->with('error', 'Produk tidak ditemukan dalam keranjang.');
        }

        $product = Product::find($productId);
        if (!$product) {
            // Jika produk tidak ada lagi di database, hapus dari keranjang
            unset($cart[$productId]);
            session()->put('cart', $cart);
            Log::warning("Produk dengan ID {$productId} tidak ditemukan di database saat update, dihapus dari keranjang.");
            return redirect()->route('cart.cart')->with('error', 'Produk tidak valid dan telah dihapus dari keranjang.');
        }

        $action = $request->input('action');
        $inputQuantity = (int) $request->input('quantity');
        $currentQuantity = $cart[$productId]['quantity'];
        $newQuantity = $currentQuantity; // Default ke kuantitas saat ini

        if ($action === 'increase') {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action === 'decrease') {
            $newQuantity = $currentQuantity - 1;
        } else {
            // Jika tidak ada action, gunakan kuantitas dari input langsung
            $newQuantity = $inputQuantity;
        }

        // Pastikan kuantitas tidak kurang dari 1
        // Jika kuantitas menjadi 0 atau kurang, hapus item
        if ($newQuantity <= 0) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->route('cart.cart')->with('status', 'Produk berhasil dihapus dari keranjang.');
        }

        // Cek stok saat update
        if ($newQuantity > $product->stock) {
            return redirect()->route('cart.cart')->with('error', 'Jumlah yang diminta melebihi stok yang tersedia (' . $product->stock . ').');
        }

        // PENTING: Pastikan harga tetap dipertahankan atau diperbarui jika ada perubahan harga produk
        $cart[$productId]['quantity'] = $newQuantity;
        $cart[$productId]['price'] = $product->price; // Update harga jika ada perubahan di DB
        $cart[$productId]['name'] = $product->name; // Update nama
        $cart[$productId]['image'] = $product->image; // Update gambar

        session()->put('cart', $cart);

        return redirect()->route('cart.cart')->with('status', 'Jumlah produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk dari keranjang.
     *
     * @param  int  $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->route('cart.cart')->with('status', 'Produk berhasil dihapus dari keranjang.');
        }

        return redirect()->route('cart.cart')->with('error', 'Produk tidak ditemukan dalam keranjang.');
    }

    /**
     * Mengosongkan seluruh isi keranjang belanja.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.cart')->with('status', 'Keranjang belanja berhasil dikosongkan!');
    }

    /**
     * Metode untuk halaman sukses checkout.
     * Menerima order_id untuk menampilkan detail pesanan yang baru dibuat.
     */
    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = null;

        if ($orderId) {
            // Pastikan user adalah pemilik order atau admin
            $order = Order::with('items.product', 'user')->find($orderId);
            if ($order && (!Auth::check() || (Auth::id() !== $order->user_id && (!Auth::user()->is_admin ?? false)))) {
                $order = null; // Jangan tampilkan jika bukan pemiliknya atau bukan admin
            }
        }

        // Jika order tidak ditemukan atau tidak valid, redirect ke dashboard atau katalog
        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'Detail pesanan tidak ditemukan atau tidak valid.');
        }

        return view('checkout.success', compact('order')); // Asumsi Anda punya view ini
    }
}
