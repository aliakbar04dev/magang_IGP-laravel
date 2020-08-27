<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEhstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('app.env', 'local') === 'lokal') {
            Schema::create('ehsm_wp_pics', function (Blueprint $table) {
                $table->increments('id');
                $table->string('npk', 5);
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->unique('npk');
            });

            Schema::create('ehst_wp1s', function (Blueprint $table) {
                $table->increments('id');
                $table->string('no_wp', 15);
                $table->integer('no_rev')->unsigned();
                $table->date('tgl_wp');
                $table->timestamp('tgl_rev');
                $table->string('kd_supp', 10);
                $table->string('kd_site', 4);
                $table->string('no_pp', 13)->nullable();
                $table->string('no_po', 20)->nullable();
                $table->string('nm_proyek', 100)->nullable();
                $table->string('lok_proyek', 100)->nullable();
                $table->string('pic_pp', 50)->nullable();
                $table->timestamp('tgl_laksana1')->nullable();
                $table->timestamp('tgl_laksana2')->nullable();
                $table->decimal('no_perpanjang', 3, 0)->nullable();
                $table->char('kat_kerja_sfp', 1)->nullable();
                $table->char('kat_kerja_hwp', 1)->nullable();
                $table->char('kat_kerja_csp', 1)->nullable();
                $table->char('kat_kerja_hpp', 1)->nullable();
                $table->char('kat_kerja_ele', 1)->nullable();
                $table->char('kat_kerja_oth', 1)->nullable();
                $table->string('kat_kerja_ket', 50)->nullable();
                $table->string('alat_pakai', 200)->nullable();
                $table->string('submit_pic', 50)->nullable();
                $table->timestamp('submit_tgl')->nullable();
                $table->string('approve_prc_pic', 50)->nullable();
                $table->timestamp('approve_prc_tgl')->nullable();
                $table->string('reject_prc_pic', 50)->nullable();
                $table->timestamp('reject_prc_tgl')->nullable();
                $table->string('reject_prc_ket', 500)->nullable();
                $table->char('reject_prc_st', 1)->nullable();
                $table->string('approve_user_pic', 50)->nullable();
                $table->timestamp('approve_user_tgl')->nullable();
                $table->string('reject_user_pic', 50)->nullable();
                $table->timestamp('reject_user_tgl')->nullable();
                $table->string('reject_user_ket', 500)->nullable();
                $table->char('reject_user_st', 1)->nullable();
                $table->string('approve_ehs_pic', 50)->nullable();
                $table->timestamp('approve_ehs_tgl')->nullable();
                $table->string('reject_ehs_pic', 50)->nullable();
                $table->timestamp('reject_ehs_tgl')->nullable();
                $table->string('reject_ehs_ket', 500)->nullable();
                $table->char('reject_ehs_st', 1)->nullable();
                $table->date('tgl_expired')->nullable();
                $table->date('tgl_close')->nullable();
                $table->string('pic_close', 50)->nullable();
                $table->string('apd_1', 100)->nullable();
                $table->string('apd_2', 100)->nullable();
                $table->string('apd_3', 100)->nullable();
                $table->string('apd_4', 100)->nullable();
                $table->string('apd_5', 100)->nullable();
                $table->string('apd_6', 100)->nullable();
                $table->string('apd_7', 100)->nullable();
                $table->string('apd_8', 100)->nullable();
                $table->string('apd_9', 100)->nullable();
                $table->string('apd_10', 300)->nullable();
                $table->string('apd_11', 300)->nullable();
                $table->char('jns_pekerjaan', 1)->nullable();
                $table->string('scan_sec_in_npk', 50)->nullable();
                $table->timestamp('scan_sec_in_tgl')->nullable();
                $table->string('scan_sec_in_ket', 500)->nullable();
                $table->string('scan_sec_out_npk', 50)->nullable();
                $table->timestamp('scan_sec_out_tgl')->nullable();
                $table->string('scan_sec_out_ket', 500)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->string('status', 50)->default('DRAFT');
                $table->foreign('submit_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('approve_prc_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('reject_prc_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('approve_user_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('reject_user_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('approve_ehs_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('reject_ehs_pic')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('pic_close')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->unique(['no_wp', 'no_rev']);
            });

            Schema::create('ehst_wp2_mps', function (Blueprint $table) {
                $table->increments('id');
                $table->string('no_wp', 15);
                $table->integer('no_rev')->unsigned();
                $table->integer('no_seq')->unsigned();
                $table->string('nm_mp', 50)->nullable();
                $table->string('no_id', 20)->nullable();
                $table->char('st_ap', 1)->nullable();
                $table->string('ket_remarks', 50)->nullable();
                $table->string('pict_id', 500)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign(['no_wp', 'no_rev'])->references(['no_wp', 'no_rev'])->on('ehst_wp1s')->onUpdate('cascade')->onDelete('cascade');
            });

            Schema::create('ehst_wp2_k3s', function (Blueprint $table) {
                $table->increments('id');
                $table->string('no_wp', 15);
                $table->integer('no_rev')->unsigned();
                $table->integer('no_seq')->unsigned();
                $table->string('ket_aktifitas', 100)->nullable();
                $table->string('ib_potensi', 200)->nullable();
                $table->string('ib_resiko', 200)->nullable();
                $table->string('pencegahan', 200)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign(['no_wp', 'no_rev'])->references(['no_wp', 'no_rev'])->on('ehst_wp1s')->onUpdate('cascade')->onDelete('cascade');
            });

            Schema::create('ehst_wp2_envs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('no_wp', 15);
                $table->integer('no_rev')->unsigned();
                $table->integer('no_seq')->unsigned();
                $table->string('ket_aktifitas', 100)->nullable();
                $table->string('ket_aspek', 200)->nullable();
                $table->string('ket_dampak', 200)->nullable();
                $table->string('pencegahan', 200)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 50);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 50)->nullable();
                $table->foreign('creaby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign('modiby')->references('username')->on('users')
                    ->onUpdate('cascade')->onDelete('restrict');
                $table->foreign(['no_wp', 'no_rev'])->references(['no_wp', 'no_rev'])->on('ehst_wp1s')->onUpdate('cascade')->onDelete('cascade');
            });

            Schema::create('tcehs021m', function (Blueprint $table) {
                $table->string('kd_dampak', 10);
                $table->string('nm_dampak', 50);
                $table->char('st_aktif', 1)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 5);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 5)->nullable();
                $table->primary('kd_dampak');
            });

            Schema::create('tcehs022m', function (Blueprint $table) {
                $table->string('kd_kendali', 10);
                $table->string('nm_kendali', 50);
                $table->char('st_aktif', 1)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 5);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 5)->nullable();
                $table->primary('kd_kendali');
            });

            Schema::create('tcehs023m', function (Blueprint $table) {
                $table->string('kd_aspek', 10);
                $table->string('nm_aspek', 50);
                $table->char('st_aktif', 1)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 5);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 5)->nullable();
                $table->primary('kd_aspek');
            });

            Schema::create('tcehs024m', function (Blueprint $table) {
                $table->string('kd_bahaya', 10);
                $table->string('nm_bahaya', 50);
                $table->char('st_aktif', 1)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 5);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 5)->nullable();
                $table->primary('kd_bahaya');
            });

            Schema::create('tcehs025m', function (Blueprint $table) {
                $table->string('kd_resiko', 10);
                $table->string('nm_resiko', 50);
                $table->char('st_tingkat', 1);
                $table->char('st_aktif', 1)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 5);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 5)->nullable();
                $table->primary('kd_resiko');
            });

            Schema::create('tcehs026m', function (Blueprint $table) {
                $table->string('kd_kendali', 10);
                $table->string('nm_kendali', 50);
                $table->string('nm_kel', 10);
                $table->char('st_aktif', 1)->nullable();
                $table->timestamp('dtcrea');
                $table->string('creaby', 5);
                $table->timestamp('dtmodi')->nullable();
                $table->string('modiby', 5)->nullable();
                $table->primary('kd_kendali');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(config('app.env', 'local') === 'lokal') {
            Schema::dropIfExists('ehst_wp2_envs');
            Schema::dropIfExists('ehst_wp2_k3s');
            Schema::dropIfExists('ehst_wp2_mps');
            Schema::dropIfExists('ehst_wp1s');
            Schema::dropIfExists('ehsm_wp_pics');
            Schema::dropIfExists('tcehs026m');
            Schema::dropIfExists('tcehs025m');
            Schema::dropIfExists('tcehs024m');
            Schema::dropIfExists('tcehs023m');
            Schema::dropIfExists('tcehs022m');
            Schema::dropIfExists('tcehs021m');
        }
    }
}
