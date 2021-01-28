<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatatanTransaksiProyek extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('catatan_transaksi_proyeks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_transaksi');
            $table->unsignedBigInteger('id_akun_tr_proyek')->references('id')->on('akun_transaksi_proyeks');
            $table->unsignedBigInteger('id_pemasok')->references('id')->on('pemasoks')->nullable();
            $table->string('nama_material')->nullable();
            $table->integer('jumlah_material')->nullable();
            $table->string('satuan_material')->nullable();
            $table->unsignedBigInteger('id_proyek')->references('id')->on('proyeks');
            $table->unsignedBigInteger('id_akun_neraca')->references('id')->on('akun_neraca_saldos')->nullable();
            $table->double('jumlah', 21, 3);
            $table->double('terbayar', 21, 3);

            $table->unsignedBigInteger('id_perusahaan')->references('id')->on('perusahaan')->nullable();
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
        Schema::dropIfExists('catatan_transaksi_proyeks');
        //
    }
}