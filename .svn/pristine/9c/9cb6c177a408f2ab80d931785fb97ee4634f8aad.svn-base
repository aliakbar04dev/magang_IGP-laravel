<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJenisOrder extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if(config('app.env', 'local') === 'lokal') {
      Schema::create('work_orders', function (Blueprint $table) {
        $table->increments('id');
        $table->string('no_wo', 15)->unique();
        $table->date('tgl_wo');
        $table->string('kd_pt', 3)->default(config('app.kd_pt', 'XXX'));
        $table->string('kd_dep', 2);
        $table->string('ext',5);
        $table->string('id_hw', 50)->nullable();
        $table->string('jenis_orders',100)->nullable();
        $table->string('detail_orders',100)->nullable();
        $table->string('uraian', 2000)->nullable();
        $table->date('tgl_terima')->nullable();
        $table->string('pic_terima', 5)->nullable();
        $table->string('jenis_solusi', 50)->nullable();
        $table->string('solusi',1000)->nullable();
        $table->timestamp('tgl_selesai')->nullable();
        $table->string('pic_solusi',5)->nullable();
        $table->string('statusapp',25)->nullable()->default("SUBMIT");
        $table->timestamp('dtcrea')->nullable();
        $table->string('creaby', 50)->nullable();
        $table->timestamp('dtmodi')->nullable();
        $table->string('modiby', 50)->nullable();
        $table->foreign('creaby')->references('username')->on('users')
        ->onUpdate('cascade')->onDelete('restrict');
        $table->foreign('modiby')->references('username')->on('users')
        ->onUpdate('cascade')->onDelete('restrict');
      });
    };
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    if(config('app.env', 'local') === 'lokal') {
      // Pindah ke migration tabel users
    }
  }
}
