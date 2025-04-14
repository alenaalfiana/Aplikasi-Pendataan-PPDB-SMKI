<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilePowerpointToTblLaporanPenerimaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_laporan_penerimaan', function (Blueprint $table) {
            $table->string('file_powerpoint')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tbl_laporan_penerimaan', function (Blueprint $table) {
            $table->dropColumn('file_powerpoint');
        });
    }
    
}
