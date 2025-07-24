<?php

namespace App\Http\Controllers;

use App\Models\Order; 
use App\Models\User;  
use App\Models\Product; 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; 
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Redirect; 
use Illuminate\Support\Str; 
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin (halaman index).
     * Metode ini sebelumnya bernama 'status' di kode Anda, diubah menjadi 'index'
     * agar sesuai dengan penamaan rute 'admin.orders.index'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // Query dasar dengan eager loading relasi yang diperlukan
        $orders = Order::with(['user', 'items.product'])->latest();

        // Filter berdasarkan ID pesanan atau nama/email pengguna
        if ($request->filled('search')) { // Menggunakan filled() untuk cek keberadaan dan non-empty
            $search = $request->search;
            $orders->where(function($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                      });
            });
        }

        // Filter berdasarkan status pesanan
        if ($request->filled('status')) {
            $orders->where('status', $request->status);
        }

        // Filter berdasarkan status pembayaran
        if ($request->filled('payment_status')) {
            $orders->where('payment_status', $request->payment_status);
        }

        // Ambil data pesanan dengan paginasi
        $orders = $orders->paginate(10); // 10 pesanan per halaman

        // Definisikan semua status pesanan yang mungkin secara statis
        // Ini lebih baik daripada mengambil dari DB karena memastikan semua opsi tersedia
        // bahkan jika belum ada pesanan dengan status tertentu di DB.
        $allOrderStatuses = [
            'pending',
            'proses',
            'dikirim',
            'selesai',
            'dibatalkan',
            'dikembalikan',
        ];
        // Urutkan secara alfabetis (opsional, tergantung preferensi tampilan)
        sort($allOrderStatuses);

        // Definisikan semua status pembayaran yang mungkin secara statis
        $allPaymentStatuses = [
            'belum dibayar',
            'menunggu verifikasi',
            'sudah dibayar',
        ];
        // Urutkan secara alfabetis (opsional)
        sort($allPaymentStatuses);

        return view('admin.orders', compact('orders', 'request', 'allOrderStatuses', 'allPaymentStatuses'));
    }

    /**
     * Menampilkan detail pesanan tertentu untuk admin.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order): View
    {
        // Pastikan relasi user dan items.product dimuat
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan (oleh admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|string|in:pending,proses,dikirim,selesai,dibatalkan,dikembalikan',
        ]);

        try {
            $order->status = $request->status;
            $order->save();
            return back()->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui status pesanan: ' . $e->getMessage(), ['order_id' => $order->id, 'new_status' => $request->status]);
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status pesanan.');
        }
    }

    /**
     * Memperbarui status pembayaran pesanan (oleh admin).
     * Ini adalah fungsi inti untuk verifikasi pembayaran manual.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePaymentStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'payment_status' => 'required|string|in:belum dibayar,sudah dibayar,menunggu verifikasi',
        ]);

        try {
            // Jika status diubah menjadi 'sudah dibayar', catat waktu konfirmasi
            if ($request->payment_status === 'sudah dibayar' && $order->payment_status !== 'sudah dibayar') {
                $order->payment_confirmed_at = now();
            } elseif ($request->payment_status !== 'sudah dibayar' && $order->payment_status === 'sudah dibayar') {
                // Jika diubah dari 'sudah dibayar' ke status lain, hapus waktu konfirmasi
                $order->payment_confirmed_at = null;
            }

            $order->payment_status = $request->payment_status;
            $order->save();

            return back()->with('success', 'Status pembayaran berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui status pembayaran: ' . $e->getMessage(), ['order_id' => $order->id, 'new_payment_status' => $request->payment_status]);
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status pembayaran.');
        }
    }

    /**
     * Menampilkan halaman untuk mencetak detail pesanan.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function print(Order $order): View
    {
        // Memuat relasi yang diperlukan untuk laporan detail
        $order->load(['user', 'items.product']);
        return view('admin.orders.print', compact('order'));
    }

    /**
     * Handle the admin dashboard view.
     * Metode placeholder, sesuaikan dengan logika dashboard admin Anda.
     * @return \Illuminate\View\View
     */
    public function adminDashboard(): View
    {
        // Contoh: Ambil beberapa statistik atau data ringkasan untuk dashboard
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('payment_status', 'sudah dibayar')->sum('total_price');

        return view('admin.dashboard', compact('totalOrders', 'pendingOrders', 'totalRevenue'));
    }
}
