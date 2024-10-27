<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null'); // Relasi ke tabel categories
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null'); // Relasi ke tabel payment_methods
            $table->enum('type', ['income', 'expense']); // Jenis transaksi: pemasukan atau pengeluaran
            $table->decimal('amount', 15, 2); // Jumlah transaksi
            $table->text('description')->nullable(); // Deskripsi transaksi
            $table->date('transaction_date'); // Tanggal transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
