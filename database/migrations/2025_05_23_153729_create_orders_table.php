<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable(); // atau ->default('...')
            $table->string('metode_pembayaran')->nullable()->default('transfer_bank'); // tambahkan kolom metode_pembayaran();
            $table->string('bank_tujuan')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('virtual_account')->nullable();
            $table->string('payment_status')->default('Belum dibayar', 'Sudah dibayar');
            $table->string('bank_name')->nullable();
            $table->timestamps();
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
    
};