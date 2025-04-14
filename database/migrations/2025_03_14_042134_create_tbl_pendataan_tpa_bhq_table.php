<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblPendataanTpaBhqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pendataan_tpa_bhq', function (Blueprint $table) {
            $table->id('id_pendataan_tpa_bhq');
            $table->unsignedBigInteger('id_form_pendaftaran');
            $table->string('rata2_tpa', 5)->nullable();
            $table->string('max_tpa', 5)->nullable();
            $table->string('min_tpa', 5)->nullable();
            $table->string('rata2_tes_alquran', 5)->nullable();
            $table->string('max_alquran', 5)->nullable();
            $table->string('min_alquran', 5)->nullable();
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
        Schema::dropIfExists('tbl_pendataan_tpa_bhq');
    }
}
