<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'shipping_address',
        'note',
        'payment_method',
        'bank_tujuan',
        'virtual_account', // Hapus jika tidak ingin menyimpan VA di sini, lebih baik di generate on-the-fly atau di gateway
        'payment_status',    // e.g., belum dibayar, sudah dibayar
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'decimal:2', // Pastikan total_price adalah tipe numerik
        // Anda bisa menambahkan casting untuk created_at, updated_at jika perlu format khusus
    ];


    // Relasi ke User (pemilik pesanan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke OrderItem (item-item dalam pesanan ini)
    // Gunakan satu nama relasi yang konsisten, saya sarankan 'items'
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    
}
