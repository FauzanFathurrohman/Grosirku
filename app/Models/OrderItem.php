<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan ini di-import
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory; // Tambahkan ini jika Anda menggunakan model factories

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2', // Pastikan harga adalah tipe numerik
        'quantity' => 'integer', // Pastikan kuantitas adalah integer
    ];

    // Relasi ke Order (setiap item pesanan milik satu pesanan)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke Product (setiap item pesanan terkait dengan satu produk)
    public function product()
    {
        return $this->belongsTo(Product::class); // Pastikan Product model ada di App\Models
    }
}
