<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblRegistrasiPengambilanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_registrasi_pengambilan', function (Blueprint $table) {
            $table->id('id_registrasi_pengambilan');
            $table->string('no_pendaftar', 10);
            $table->string('nama_pengambil', 75);
            $table->unsignedBigInteger('id_periode');
            $table->string('nama', 75);
            $table->enum('jenis_kelamin', ['perempuan', 'laki-laki']);
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('regency_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('village_id');
            $table->text('alamat_lengkap');
            $table->string('no_telepon', 15);
            $table->string('asal_sekolah', 55);
            $table->string('nama_ayah', 75);
            $table->string('nama_ibu', 75);
            $table->string('nama_wali', 75)->nullable();
            $table->text('keterangan');
            $table->string('foto_bukti_pengisian', 255);
            $table->date('tanggal_pengambilan');
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
        Schema::dropIfExists('tbl_registrasi_pengambilan');
    }
}
