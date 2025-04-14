<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFormSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_form_survey', function (Blueprint $table) {
            $table->bigIncrements('id_form_survey');
            $table->unsignedBigInteger('id_pendataan_surveyor_siswa');
            $table->unsignedBigInteger('id_form_pendaftaran');

            $table->string('income_form_ayah', 10);
            $table->string('income_interview_ayah', 10);
            $table->string('income_survey_ayah', 10);

            $table->string('income_form_ibu', 10);
            $table->string('income_interview_ibu', 10);
            $table->string('income_survey_ibu', 10);

            $table->text('nama_lengkap_keluarga')->nullable();
            $table->text('jenis_kelamin')->nullable();
            $table->text('usia')->nullable();
            $table->text('pendidikan')->nullable();
            $table->text('kelas')->nullable();
            $table->text('pekerjaan')->nullable();
            $table->text('hubungan')->nullable();

            $table->enum('status_rumah', ['Sendiri', 'Kontrak', 'Menumpang'])->nullable();
            $table->string('biaya_perbulan', 12)->nullable();
            $table->string('luas_bangunan', 10)->nullable();
            $table->string('luas_tanah', 10)->nullable();
            $table->string('fasilitas_ruang_tamu', 2)->nullable();
            $table->string('fasilitas_ruang_keluarga', 2)->nullable();
            $table->string('fasilitas_kamar_tidur', 2)->nullable();
            $table->string('besar_listrik', 12)->nullable();
            $table->string('biaya_listrik', 12)->nullable();
            $table->string('biaya_hidup_perbulan',  12)->nullable();
            $table->text('harta_milik_keluarga')->nullable();
            $table->text('tanggungan_hutang');

            $table->text('alasan_pendukung')->nullable();
            $table->text('alasan_memberatkan')->nullable();
            $table->enum('saran_rekomendasi', ['Diterima', 'Ditolak', 'Abu-abu'])->nullable();
            $table->date('tanggal_survey')->nullable();
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
        Schema::dropIfExists('tbl_form_survey');
    }
}
