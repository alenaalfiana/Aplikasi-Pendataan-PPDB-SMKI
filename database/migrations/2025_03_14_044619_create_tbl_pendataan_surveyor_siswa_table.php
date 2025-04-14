<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPendataanSurveyorSiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tbl_pendataan_surveyor_siswa', function (Blueprint $table) {
            $table->id('id_pendataan_surveyor_siswa');
            $table->unsignedBigInteger('id_periode');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_form_pendaftaran');
            $table->enum('status', ['Selesai', 'Belum_Selesai']);
            $table->timestamps();

            // Foreign key
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_pendataan_surveyor_siswa');
    }
}
