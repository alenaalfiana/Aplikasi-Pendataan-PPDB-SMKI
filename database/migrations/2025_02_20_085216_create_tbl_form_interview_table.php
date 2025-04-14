<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblFormInterviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_form_interview', function (Blueprint $table) {
            $table->id('id_form_interview');
            $table->unsignedBigInteger('id_pendataan_surveyor_siswa');

            // Data pribadi siswa
            $table->string('nama_panggilan', 25)->nullable();
            $table->string('jumlah_saudara_kandung', 2)->nullable();
            $table->string('jumlah_saudara_tiri', 2)->nullable();
            $table->string('jumlah_saudara_angkat', 2)->nullable();
            $table->string('cita_cita', 100)->nullable();
            $table->text('alasan')->nullable();
            $table->text('usaha_yang_dilakukan')->nullable();
            $table->string('motto', 150)->nullable();
            $table->text('kekurangan')->nullable();
            $table->text('kelebihan')->nullable();
            $table->string('organisasi_sekolah', 50)->nullable();
            $table->string('organisasi_masyarakat', 50)->nullable();
            $table->text('hobi')->nullable();
            $table->enum('nilai_komunikasi', ['baik', 'cukup', 'kurang'])->nullable();
            $table->enum('nilai_kepercayaan_diri', ['baik', 'cukup', 'kurang'])->nullable();
            $table->string('uang_saku', 100)->nullable();
            $table->enum('kemampuan_bermotor', ['bisa', 'tidak_bisa'])->nullable();

            // Data sekolah
            $table->text('prestasi_yang_dicapai')->nullable();
            $table->set('mata_pelajaran', [
                'Matematika', 'Bahasa_Indonesia', 'Bahasa_Inggris', 'IPA', 'IPS', 'PKN', 'Seni_Budaya', 'Olahraga', 'Agama', 'Tidak_ada'
            ])->nullable();
            $table->text('rencana_pilihan_sekolah')->nullable();
            $table->text('alasan_pilihan_sekolah')->nullable();
            $table->string('kenalan_yang_diterima_di_smki', 100)->nullable();
            $table->string('historis_sakit', 2)->nullable();
            $table->string('historis_ijin', 2)->nullable();
            $table->string('historis_alfa', 2)->nullable();
            $table->string('catatan_kasus_pelanggaran', 50)->nullable();
            $table->enum('bhq', ['lancar', 'terbata_bata', 'tidak_bisa'])->nullable();
            $table->string('hafalan_juz', 2)->nullable();

            // Data kesehatan jiwa raga
            $table->string('merokok_narkoba', 50)->nullable();
            $table->string('jenis_merek_harga', 100)->nullable();
            $table->string('anggota_keluarga_yg_merokok', 30)->nullable();
            $table->string('riwayat_kesehatan', 100)->nullable();
            $table->enum('terpapar_pornografi', ['melihat_gambar', 'menonton_video', 'menyebarluaskan', 'tidak_terpapar'])->nullable();
            $table->text('media_sosial')->nullable();
            $table->enum('ketertarikan_dengan_lawan_jenis', ['tidak_pacaran', 'pacaran', 'pernah_pacaran'])->nullable();

            // Data tanggungan keluarga
            $table->text('nama_lengkap_keluarga')->nullable();
            $table->text('jenis_kelamin')->nullable();
            $table->text('usia')->nullable();
            $table->text('pendidikan')->nullable();
            $table->text('kelas')->nullable();
            $table->text('pekerjaan')->nullable();
            $table->text('hubungan')->nullable();

            // Situasi keluarga
            $table->string('siswa_tinggal_bersama', 35)->nullable();
            $table->string('status_pernikahan_ortu', 35)->nullable();
            $table->string('status_rumah', 35)->nullable();
            $table->string('harga_kontrak', 100)->nullable();
            $table->string('daya_listrik', 5)->nullable();
            $table->string('biaya_listrik', 100)->nullable();
            $table->string('transportasi_yg_dimiliki', 10)->nullable();
            $table->text('harta_milik_keluarga')->nullable();
            $table->string('berat_kalung_gr', 5)->nullable();
            $table->string('berat_cincin_gr', 5)->nullable();
            $table->string('berat_gelang_gr', 5)->nullable();
            $table->string('berat_anting_gr', 5)->nullable();
            $table->string('tanggungan_kredit', 30)->nullable();
            $table->text('pendapat')->nullable();

            // Kontak darurat
            $table->string('nama', 75)->nullable();
            $table->string('hubungan_dgn_siswa', 75)->nullable();
            $table->text('alamat_kontak_darurat')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('no_hp', 15)->nullable();

            // Kesimpulan dan saran
            $table->text('kesimpulan')->nullable();

            // Detail tambahan
            $table->string('denah_lokasi', 255)->nullable();
            $table->string('nama_lengkap', 75)->nullable();
            $table->string('nama_panggilan_di_lingkungan', 20)->nullable();
            $table->text('ciri_ciri_rumah')->nullable();
            $table->date('tanggal_pengisian')->nullable();
            $table->enum('status_interview', ['sudah', 'belum']);
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
        Schema::dropIfExists('tbl_form_interview');
    }
}
