<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblLaporanPenerimaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_laporan_penerimaan', function (Blueprint $table) {
            $table->id('id_penerimaan');
            $table->unsignedBigInteger('id_form_pendaftaran');
            $table->enum('hasil_akhir', ['diterima', 'tidak_diterima']);
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
        Schema::dropIfExists('tbl_laporan_penerimaan');
    }
}
