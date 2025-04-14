<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFormPendaftaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_form_pendaftaran', function (Blueprint $table) {
            $table->id('id_form_pendaftaran');
            $table->unsignedBigInteger('id_registrasi_pengambilan');
            $table->string('nisn');
            $table->enum('ukuran_baju', ['M', 'L', 'XL', 'XXL']);
            $table->enum('jenis_kelamin', ['perempuan', 'laki-laki']);
            $table->string('tempat_lahir', 25);
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->string('anak_ke', 2);
            $table->string('dari', 2);
            $table->enum('status_siswa', ['yatim-piatu', 'yatim', 'piatu', 'orang-tua-lengkap']);
            $table->string('bahasa_keseharian', 20);
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('regency_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('village_id');
            $table->text('alamat_lengkap');
            $table->string('pas_foto', 255);

            $table->string('nama_ayah', 75);
            $table->string('usia_ayah', 2);
            $table->enum('pendidikan_ayah', ['tidak-sekolah', 'SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3']);
            $table->string('pekerjaan_ayah', 30);
            $table->string('penghasilan_ayah', 100);
            $table->text('alamat_lengkap_ayah');
            $table->string('no_telepon_ayah', 15);
            $table->string('nama_ibu', 75);
            $table->string('usia_ibu', 2);
            $table->enum('pendidikan_ibu', ['tidak-sekolah', 'SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3']);
            $table->string('pekerjaan_ibu', 30);
            $table->string('penghasilan_ibu', 100);
            $table->text('alamat_lengkap_ibu');
            $table->string('no_telepon_Ibu', 15);
            $table->string('nama_wali', 75);
            $table->string('usia_wali', 2);
            $table->enum('pendidikan_wali', ['tidak-sekolah', 'SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK', 'S1', 'S2', 'S3']);
            $table->string('pekerjaan_wali', 30);
            $table->string('penghasilan_wali', 100);
            $table->text('alamat_lengkap_wali');
            $table->string('no_telepon_wali', 15);

            $table->string('asal_sekolah', 55);
            $table->text('alamat_lengkap_sekolah');
            $table->string('tahun_lulus', 4);

            $table->date('tanggal_mendaftar');
            $table->string('tanda_tangan_siswa', 255);

            $table->enum('akta_lahir', ['ada', 'tidak_ada', 'menyusul']);
            $table->enum('kartu_keluarga', ['ada', 'tidak_ada', 'menyusul']);
            $table->enum('pas_foto_3x4', ['ada', 'tidak_ada', 'menyusul']);
            $table->enum('sktm_kelurahan', ['ada', 'tidak_ada', 'menyusul']);
            $table->enum('kartu_kip', ['ada', 'tidak_ada', 'menyusul']);
            $table->enum('raport_smp', ['ada', 'tidak_ada', 'menyusul']);
            $table->enum('ijazah_legalisir', ['ada', 'tidak_ada', 'menyusul']);
            $table->enum('ktp_ortu_wali', ['ada', 'tidak_ada', 'menyusul']);
            $table->date('tanggal_pengembalian')->nullable();
            $table->enum('status', ['lengkap', 'tidak_lengkap'])->default('tidak_lengkap');
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
        Schema::dropIfExists('tbl_form_pendaftaran');
    }
}
