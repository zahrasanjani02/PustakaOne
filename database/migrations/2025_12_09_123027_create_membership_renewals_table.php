<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('membership_renewals', function (Blueprint $table) {
        $table->dropColumn('payment_proof'); // Hapus kolom upload gambar
        $table->string('order_id')->unique()->after('id'); // ID unik transaksi
        $table->string('snap_token')->nullable()->after('amount'); // Token pembayaran
        $table->string('payment_status')->default('pending')->after('amount'); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_renewals');
    }
};