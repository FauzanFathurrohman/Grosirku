<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Untuk transaksi database
use Illuminate\Validation\Rule; // Untuk validasi rule in
use Illuminate\Support\Facades\Log; // Import Log Facade
use Illuminate\Validation\ValidationException; // Import ValidationException
use App\Models\Product; // Pastikan Product model diimpor, diperlukan di checkout

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan pelanggan.
     */
    public function index()
    {
        // Pastikan pengguna sudah login sebelum mengakses orders()
        $orders = Auth::check() ? Auth::user()->orders()->with('items.product')->latest()->get() : collect();
        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan daftar pesanan untuk admin.
     */
    public function admin()
    {
        
        // Menggunakan 'items.product' agar konsisten
        $orders = Order::with('user', 'items.product')->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan untuk pengguna atau admin.
     * Menggunakan Route Model Binding untuk Order $order.
     */
    public function show(Order $order)
    {
        // Otorisasi: Hanya admin atau pemilik pesanan yang bisa melihat detail
        // Menambahkan null coalescing untuk is_admin jika Auth::user() bisa null atau is_admin tidak ada
        if (!Auth::check() || (Auth::id() !== $order->user_id && (!Auth::user()->is_admin ?? false))) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load('user', 'items.product'); // Load relasi yang diperlukan (menggunakan 'items')
        return view('orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan oleh admin.
     * Menggunakan Route Model Binding untuk Order $order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validasi input status
        $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in(['pending', 'proses', 'dikirim', 'selesai', 'dibatalkan', 'dikembalikan']),
            ],
        ]);

        try {
            $order->status = $request->status;
            $order->save();

            // Redirect ke admin.orders.index (nama rute yang benar)
            return redirect()->route('admin.orders.index')->with('status', 'Status pesanan berhasil diperbarui menjadi "' . ucfirst($request->status) . '".');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error updating order status: ' . $e->getMessage(), ['order_id' => $order->id, 'new_status' => $request->status]);
            return back()->with('error', 'Gagal memperbarui status pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Memperbarui status pembayaran oleh admin.
     * Menggunakan Route Model Binding untuk Order $order.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        // Validasi input status pembayaran
        $request->validate([
            'payment_status' => [
                'required',
                'string',
                Rule::in(['belum dibayar', 'sudah dibayar']), // Menggunakan lowercase untuk konsistensi DB
            ],
        ]);

        try {
            $order->payment_status = $request->payment_status;
            $order->save();

            return back()->with('status', 'Status pembayaran berhasil diperbarui menjadi "' . ucfirst($request->payment_status) . '".');
        } catch (\Exception $e) {
            Log::error('Error updating payment status: ' . $e->getMessage(), ['order_id' => $order->id, 'new_payment_status' => $request->payment_status]);
            return back()->with('error', 'Gagal memperbarui status pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Mencetak struk pesanan.
     * Menggunakan Route Model Binding untuk Order $order.
     */
    public function print(Order $order)
    {
        // Otorisasi: Hanya admin atau pemilik pesanan yang bisa mencetak
        if (!Auth::check() || (Auth::id() !== $order->user_id && (!Auth::user()->is_admin ?? false))) {
            abort(403, 'Anda tidak memiliki akses untuk mencetak struk pesanan ini.');
        }

        $order->load('user', 'items.product'); // Menggunakan 'items'
        // Asumsi ada view 'admin.orders.print'
        return view('admin.orders.print', compact('order'));
    }

    /**
     * Melakukan proses checkout.
     */
    public function checkout(Request $request)
    {
        // Debugging: Log data request yang masuk
        Log::info('Checkout request received:', $request->all());

        try {
            $request->validate([
                'alamat' => 'required|string|max:255',
                // Perbarui Rule::in sesuai dengan opsi di cart.blade.php (virtual_account, qris, cod)
                'metode_pembayaran' => ['required', 'string', Rule::in(['virtual_account', 'qris', 'cod'])],
                'catatan' => 'nullable|string|max:500',
                // bank_tujuan hanya required jika metode_pembayaran adalah virtual_account
                'bank_tujuan' => 'required_if:metode_pembayaran,virtual_account|nullable|string|max:100',
            ]);
            Log::info('Checkout request validation passed.');

        } catch (ValidationException $e) { // Tangkap ValidationException secara eksplisit
            // Debugging: Log error validasi
            Log::error('Checkout validation failed:', $e->errors());
            // Redirect kembali dengan input dan error validasi
            return back()->withInput()->withErrors($e->errors())->with('error', 'Ada kesalahan pada input Anda. Mohon periksa kembali formulir.');
        }

        // Pastikan ada item di keranjang sebelum checkout
        $cart = session('cart', []);
        if (empty($cart)) {
            Log::warning('Checkout attempt with empty cart.');
            return redirect()->route('cart.cart')->with('error', 'Keranjang belanja Anda kosong.');
        }
        Log::info('Cart is not empty, proceeding with checkout.');

        // Hitung total harga dari session cart dan validasi stok terakhir
        $totalPrice = 0;
        $orderItemsData = [];
        $productsToUpdateStock = [];

        DB::beginTransaction(); // Mulai transaksi database
        try {
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId); // Menggunakan Product model

                // Periksa jika produk masih ada
                if (!$product) {
                    Log::error('Product not found in DB during checkout for ID: ' . $productId);
                    throw new \Exception("Produk dengan ID {$productId} tidak ditemukan. Silakan sesuaikan keranjang Anda.");
                }

                // Pastikan 'price' dan 'quantity' ada di item sesi dan numerik
                // Ini akan teratasi setelah perbaikan di metode add/update CartController
                if (!isset($item['price']) || !isset($item['quantity']) || !is_numeric($item['price']) || !is_numeric($item['quantity'])) {
                    Log::error('Invalid cart item structure detected during final checkout calculation.', ['item' => $item, 'productId' => $productId]);
                    throw new \Exception('Terjadi kesalahan pada data produk di keranjang. Mohon coba lagi dari awal.');
                }

                // Periksa stok mencukupi
                if ($product->stock < $item['quantity']) {
                    Log::warning('Insufficient stock during checkout.', ['product_id' => $productId, 'requested_qty' => $item['quantity'], 'available_stock' => $product->stock]);
                    throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi. Tersedia: {$product->stock}, Diminta: {$item['quantity']}. Silakan sesuaikan jumlah di keranjang Anda.");
                }

                $subtotal = $item['price'] * $item['quantity']; // Gunakan harga dari sesi
                $totalPrice += $subtotal;

                $orderItemsData[] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'] // Harga produk saat checkout (dari sesi)
                ];

                // Siapkan untuk update stok
                $productsToUpdateStock[] = [
                    'product' => $product,
                    'quantity_deduct' => $item['quantity']
                ];
            }
            Log::info('Cart items validated and total price calculated: ' . $totalPrice);

            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'status' => 'pending', // Status awal selalu pending
                'shipping_address' => $request->alamat,
                'note' => $request->catatan,
                'payment_method' => $request->metode_pembayaran,
                'payment_status' => 'belum dibayar', // Status pembayaran awal selalu belum dibayar
                'bank_tujuan' => ($request->metode_pembayaran === 'virtual_account') ? $request->bank_tujuan : null, // Menggunakan bank_tujuan dari request jika metode VA
                'created_at' => now(), // Tambahkan created_at
                'updated_at' => now(), // Tambahkan updated_at
            ]);
            Log::info('Order created successfully.', ['order_id' => $order->id]);

            foreach ($orderItemsData as $itemData) {
                // Pastikan order_id disertakan saat membuat OrderItem
                OrderItem::create(array_merge($itemData, ['order_id' => $order->id]));
            }
            Log::info('Order items created successfully.');

            // Kurangi stok produk setelah order berhasil dibuat
            foreach ($productsToUpdateStock as $stockItem) {
                $stockItem['product']->decrement('stock', $stockItem['quantity_deduct']);
            }
            Log::info('Product stock decremented successfully.');

            session()->forget('cart'); // Bersihkan keranjang setelah checkout
            Log::info('Cart session cleared.');

            DB::commit(); // Commit transaksi
            Log::info('Database transaction committed successfully.');

            // Redirect ke halaman sukses checkout atau detail pesanan
            return redirect()->route('checkout.success', ['order_id' => $order->id]) // Mengirim ID pesanan
                             ->with('success', 'Pesanan Anda berhasil dibuat! Segera lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika ada error
            Log::error('Error during checkout transaction: ' . $e->getMessage(), ['user_id' => Auth::id(), 'request' => $request->all()]);
            // Mengembalikan pesan error yang lebih informatif ke pengguna
            return back()->withInput()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi. Detail: ' . $e->getMessage());
        }
    }

    public function uploadProof(Request $request, Order $order)
    {
        // Otorisasi: Hanya pemilik pesanan yang bisa mengunggah bukti
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengunggah bukti pembayaran untuk pesanan ini.');
        }
    
        // Pastikan status pembayaran masih 'belum dibayar' dan belum ada bukti diunggah
        if ($order->payment_status === 'sudah dibayar' || $order->proof_of_payment_image) {
            return back()->with('error', 'Pesanan ini sudah dibayar atau bukti sudah diunggah.');
        }
    
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);
    
        try {
            // Simpan gambar di direktori 'public/uploads/proofs'
            // Pastikan Anda telah menjalankan `php artisan storage:link` jika menggunakan symbolic link
            $imageName = time().'.'.$request->proof_image->extension();
            $request->proof_image->move(public_path('uploads/proofs'), $imageName);
    
            // Update order dengan nama file bukti pembayaran
            $order->proof_of_payment_image = $imageName;
            // Status pembayaran bisa diubah menjadi 'menunggu verifikasi' jika Anda punya status itu
            // $order->payment_status = 'menunggu verifikasi'; // Opsional, jika Anda ingin status baru
            $order->save();
    
            return back()->with('success', 'Bukti pembayaran berhasil diunggah. Kami akan segera memverifikasinya.');
    
        } catch (\Exception $e) {
            Log::error('Error uploading payment proof: ' . $e->getMessage(), ['order_id' => $order->id]);
            return back()->with('error', 'Gagal mengunggah bukti pembayaran. Silakan coba lagi.');
        }
    }
}
