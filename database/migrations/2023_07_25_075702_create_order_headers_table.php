<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_headers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('invoice_no', 25);
            $table->string('namapenerima', 50);
            $table->string('nohp', 14);
            $table->double('totalharga');
            $table->text('alamat');
            $table->string('buktipembayaran', 50);
            $table->dateTime('tanggalpembelian');
            $table->enum('status_pembayaran', ['Menunggu Pembayaran', 'Pembayaran Diterima', 'Pembayaran Ditolak'])->default('Menunggu Pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_headers');
    }
};