<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrdtsTable extends Migration
{
     /**
      * Run the migrations.
      *
      * @return void
      */
      public function up()
      {
            /*

            php artisan make:seeder OthersSeeder
            php artisan make:seeder PermissionHrdsSeeder
            
            php artisan make:migration create_hrdts_table --create=hrdts
            php artisan make:model HrdtKpi
            php artisan make:controller HrdtKpisController --resource
            php artisan make:request StoreHrdtKpiRequest
            php artisan make:request UpdateHrdtKpiRequest

            php artisan make:model HrdtIdp1s
            php artisan make:controller HrdtIdp1sController --resource
            php artisan make:request StoreHrdtIdp1Request
            php artisan make:request UpdateHrdtIdp1Request

            php artisan make:model HrdtIdp2s
            php artisan make:controller HrdtIdp2sController --resource
            php artisan make:request StoreHrdtIdp2Request
            php artisan make:request UpdateHrdtIdp2Request

            php artisan make:model HrdtIdp3
            php artisan make:controller HrdtIdp3sController --resource

            php artisan make:model HrdtIdp4
            php artisan make:model HrdtIdp5
            php artisan make:controller HrdtIdp4sController --resource
            php artisan make:controller HrdtIdp5sController --resource

            php artisan make:model HrdtIdp1Reject
            php artisan make:model HrdtIdp2Reject
            php artisan make:model HrdtIdp3Reject
            php artisan make:model HrdtIdp4Reject
            php artisan make:model HrdtIdp5Reject
            */

            if(config('app.env', 'local') === 'lokal') {

                  // Schema::create('hrdm_kpi_refs', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('tahun', 4);
                  //       $table->string('kd_pt', 3)->default(config('app.kd_pt', 'XXX'));
                  //       $table->string('strategy_priority', 5000)->nullable();
                  //       $table->string('strategy', 5000)->nullable();
                  //       $table->string('coy_kpi', 5000)->nullable();
                  //       $table->string('target', 5000)->nullable();
                  //       $table->string('initiatives', 5000)->nullable();
                  //       $table->string('div', 5000)->nullable();
                  //       $table->string('due_date', 5000)->nullable();
                  //       $table->timestamp('dtcrea')->nullable();
                  //       $table->string('creaby', 50)->nullable();
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  // });

                  // Schema::create('hrdt_kpis', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('tahun', 4);
                  //       $table->string('npk', 5);
                  //       $table->decimal('revisi', 2, 0)->default(0);
                  //       $table->string('kd_pt', 3);
                  //       $table->string('kd_div', 1);
                  //       $table->string('npk_atasan', 5);
                  //       $table->string('submit_pic', 50)->nullable();
                  //       $table->timestamp('submit_tgl')->nullable();
                  //       $table->string('reject_pic', 50)->nullable();
                  //       $table->timestamp('reject_tgl')->nullable();
                  //       $table->string('reject_ket', 2000)->nullable();
                  //       $table->string('approve_atasan', 50)->nullable();
                  //       $table->timestamp('approve_atasan_tgl')->nullable();
                  //       $table->string('approve_hr', 50)->nullable();
                  //       $table->timestamp('approve_hr_tgl')->nullable();
                  //       $table->string('submit_review_pic', 50)->nullable();
                  //       $table->timestamp('submit_review_tgl')->nullable();
                  //       $table->string('reject_review_pic', 50)->nullable();
                  //       $table->timestamp('reject_review_tgl')->nullable();
                  //       $table->string('reject_review_ket', 2000)->nullable();
                  //       $table->string('approve_review_atasan', 50)->nullable();
                  //       $table->timestamp('approve_review_atasan_tgl')->nullable();
                  //       $table->string('approve_review_hr', 50)->nullable();
                  //       $table->timestamp('approve_review_hr_tgl')->nullable();
                  //       $table->string('status', 50)->default('DRAFT');
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('submit_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_review_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_review_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_atasan')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_review_atasan')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_review_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->unique(['tahun', 'kd_div']);
                  // });

                  // Schema::create('hrdt_kpi_acts', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_kpi_id')->unsigned();
                  //       $table->string('kd_item', 5);
                  //       $table->string('activity', 2000);
                  //       $table->integer('kpi_ref')->unsigned();
                  //       $table->string('target_q1', 2000)->nullable();
                  //       $table->date('tgl_start_q1')->nullable();
                  //       $table->date('tgl_finish_q1')->nullable();
                  //       $table->string('target_q2', 2000)->nullable();
                  //       $table->date('tgl_start_q2')->nullable();
                  //       $table->date('tgl_finish_q2')->nullable();
                  //       $table->string('target_q3', 2000)->nullable();
                  //       $table->date('tgl_start_q3')->nullable();
                  //       $table->date('tgl_finish_q3')->nullable();
                  //       $table->string('target_q4', 2000)->nullable();
                  //       $table->date('tgl_start_q4')->nullable();
                  //       $table->date('tgl_finish_q4')->nullable();
                  //       $table->decimal('weight', 3, 0)->nullable();
                  //       $table->string('keterangan', 2000)->nullable();
                  //       $table->string('target_q1_act', 2000)->nullable();
                  //       $table->date('tgl_start_q1_act')->nullable();
                  //       $table->date('tgl_finish_q1_act')->nullable();
                  //       $table->decimal('persen_q1', 3, 0)->nullable();
                  //       $table->string('target_q2_act', 2000)->nullable();
                  //       $table->date('tgl_start_q2_act')->nullable();
                  //       $table->date('tgl_finish_q2_act')->nullable();
                  //       $table->decimal('persen_q2', 3, 0)->nullable();
                  //       $table->string('target_q3_act', 2000)->nullable();
                  //       $table->date('tgl_start_q3_act')->nullable();
                  //       $table->date('tgl_finish_q3_act')->nullable();
                  //       $table->decimal('persen_q3', 3, 0)->nullable();
                  //       $table->string('target_q4_act', 2000)->nullable();
                  //       $table->date('tgl_start_q4_act')->nullable();
                  //       $table->date('tgl_finish_q4_act')->nullable();
                  //       $table->decimal('persen_q4', 3, 0)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('kpi_ref')->references('id')->on('hrdm_kpi_refs')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_kpi_id')->references('id')->on('hrdt_kpis')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_kpi_deps', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_kpi_act_id')->unsigned();
                  //       $table->string('kd_dep', 2);
                  //       $table->char('status', 1);
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_kpi_act_id')->references('id')->on('hrdt_kpi_acts')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  //       $table->unique(['hrdt_kpi_act_id', 'kd_dep']);
                  // });

                  // Schema::create('hrdt_kpi_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('tahun', 4);
                  //       $table->string('npk', 5);
                  //       $table->decimal('revisi', 2, 0)->default(0);
                  //       $table->string('kd_pt', 3);
                  //       $table->string('kd_div', 1);
                  //       $table->string('npk_atasan', 5);
                  //       $table->string('submit_pic', 50)->nullable();
                  //       $table->timestamp('submit_tgl')->nullable();
                  //       $table->string('reject_pic', 50)->nullable();
                  //       $table->timestamp('reject_tgl')->nullable();
                  //       $table->string('reject_ket', 2000)->nullable();
                  //       $table->string('approve_atasan', 50)->nullable();
                  //       $table->timestamp('approve_atasan_tgl')->nullable();
                  //       $table->string('approve_hr', 50)->nullable();
                  //       $table->timestamp('approve_hr_tgl')->nullable();
                  //       $table->string('submit_review_pic', 50)->nullable();
                  //       $table->timestamp('submit_review_tgl')->nullable();
                  //       $table->string('reject_review_pic', 50)->nullable();
                  //       $table->timestamp('reject_review_tgl')->nullable();
                  //       $table->string('reject_review_ket', 2000)->nullable();
                  //       $table->string('approve_review_atasan', 50)->nullable();
                  //       $table->timestamp('approve_review_atasan_tgl')->nullable();
                  //       $table->string('approve_review_hr', 50)->nullable();
                  //       $table->timestamp('approve_review_hr_tgl')->nullable();
                  //       $table->string('status', 50)->default('DRAFT');
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('submit_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_review_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_review_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_atasan')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_review_atasan')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_review_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->unique(['tahun', 'kd_div', 'revisi']);
                  // });

                  // Schema::create('hrdt_kpi_act_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_kpi_reject_id')->unsigned();
                  //       $table->string('kd_item', 5);
                  //       $table->string('activity', 2000);
                  //       $table->integer('kpi_ref')->unsigned();
                  //       $table->string('target_q1', 2000)->nullable();
                  //       $table->date('tgl_start_q1')->nullable();
                  //       $table->date('tgl_finish_q1')->nullable();
                  //       $table->string('target_q2', 2000)->nullable();
                  //       $table->date('tgl_start_q2')->nullable();
                  //       $table->date('tgl_finish_q2')->nullable();
                  //       $table->string('target_q3', 2000)->nullable();
                  //       $table->date('tgl_start_q3')->nullable();
                  //       $table->date('tgl_finish_q3')->nullable();
                  //       $table->string('target_q4', 2000)->nullable();
                  //       $table->date('tgl_start_q4')->nullable();
                  //       $table->date('tgl_finish_q4')->nullable();
                  //       $table->decimal('weight', 3, 0)->nullable();
                  //       $table->string('keterangan', 2000)->nullable();
                  //       $table->string('target_q1_act', 2000)->nullable();
                  //       $table->date('tgl_start_q1_act')->nullable();
                  //       $table->date('tgl_finish_q1_act')->nullable();
                  //       $table->decimal('persen_q1', 3, 0)->nullable();
                  //       $table->string('target_q2_act', 2000)->nullable();
                  //       $table->date('tgl_start_q2_act')->nullable();
                  //       $table->date('tgl_finish_q2_act')->nullable();
                  //       $table->decimal('persen_q2', 3, 0)->nullable();
                  //       $table->string('target_q3_act', 2000)->nullable();
                  //       $table->date('tgl_start_q3_act')->nullable();
                  //       $table->date('tgl_finish_q3_act')->nullable();
                  //       $table->decimal('persen_q3', 3, 0)->nullable();
                  //       $table->string('target_q4_act', 2000)->nullable();
                  //       $table->date('tgl_start_q4_act')->nullable();
                  //       $table->date('tgl_finish_q4_act')->nullable();
                  //       $table->decimal('persen_q4', 3, 0)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('kpi_ref')->references('id')->on('hrdm_kpi_refs')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_kpi_reject_id')->references('id')->on('hrdt_kpi_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_kpi_dep_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_kpi_act_reject_id')->unsigned();
                  //       $table->string('kd_dep', 2);
                  //       $table->char('status', 1);
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_kpi_act_reject_id')->references('id')->on('hrdt_kpi_act_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  //       $table->unique(['hrdt_kpi_act_reject_id', 'kd_dep']);
                  // });
                  
                  // Schema::create('hrdm_alc1s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('nm_alc', 30);
                  //       $table->string('ket_alc', 500)->nullable();
                  //       $table->timestamp('dtcrea')->nullable();
                  //       $table->string('creaby', 50)->nullable();
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->unique(['nm_alc']);
                  // });

                  // Schema::create('hrdm_alc2s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('alc1_id')->unsigned();
                  //       $table->string('kelompok_alc', 200)->nullable();
                  //       $table->timestamp('dtcrea')->nullable();
                  //       $table->string('creaby', 50)->nullable();
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('alc1_id')->references('id')->on('hrdm_alc1s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  //       $table->unique(['alc1_id','kelompok_alc']);
                  // });

                  // Schema::create('hrdm_alc3s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('alc2_id')->unsigned();
                  //       $table->string('kompetensi_alc', 200)->nullable();
                  //       $table->timestamp('dtcrea')->nullable();
                  //       $table->string('creaby', 50)->nullable();
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('alc2_id')->references('id')->on('hrdm_alc2s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  //       $table->unique(['alc2_id','kompetensi_alc']);
                  // });

                  // Schema::create('hrdm_lms', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('nm_lm', 50);
                  //       $table->string('ket_lm', 500)->nullable();
                  //       $table->string('cat_lm', 300)->nullable();
                  //       $table->timestamp('dtcrea')->nullable();
                  //       $table->string('creaby', 50)->nullable();
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  // });

                  // Schema::create('hrdt_idp1s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('tahun', 4);
                  //       $table->string('npk', 5);
                  //       $table->decimal('revisi', 2, 0)->default(0);
                  //       $table->string('kd_pt', 3);
                  //       $table->string('kd_div', 1);
                  //       $table->string('kd_dep', 2);
                  //       $table->string('kd_gol', 2);
                  //       $table->string('cur_pos', 50);
                  //       $table->string('proj_pos', 50);
                  //       $table->string('npk_dep_head', 5);
                  //       $table->string('npk_div_head', 5);
                  //       $table->string('submit_pic', 50)->nullable();
                  //       $table->timestamp('submit_tgl')->nullable();
                  //       $table->string('reject_pic', 50)->nullable();
                  //       $table->timestamp('reject_tgl')->nullable();
                  //       $table->string('reject_ket', 2000)->nullable();
                  //       $table->string('approve_div', 50)->nullable();
                  //       $table->timestamp('approve_div_tgl')->nullable();
                  //       $table->string('approve_hr', 50)->nullable();
                  //       $table->timestamp('approve_hr_tgl')->nullable();
                  //       $table->string('submit_mid_pic', 50)->nullable();
                  //       $table->timestamp('submit_mid_tgl')->nullable();
                  //       $table->string('reject_mid_pic', 50)->nullable();
                  //       $table->timestamp('reject_mid_tgl')->nullable();
                  //       $table->string('reject_mid_ket', 2000)->nullable();
                  //       $table->string('approve_mid_div', 50)->nullable();
                  //       $table->timestamp('approve_mid_div_tgl')->nullable();
                  //       $table->string('approve_mid_hr', 50)->nullable();
                  //       $table->timestamp('approve_mid_hr_tgl')->nullable();
                  //       $table->string('submit_one_pic', 50)->nullable();
                  //       $table->timestamp('submit_one_tgl')->nullable();
                  //       $table->string('reject_one_pic', 50)->nullable();
                  //       $table->timestamp('reject_one_tgl')->nullable();
                  //       $table->string('reject_one_ket', 2000)->nullable();
                  //       $table->string('approve_one_div', 50)->nullable();
                  //       $table->timestamp('approve_one_div_tgl')->nullable();
                  //       $table->string('approve_one_hr', 50)->nullable();
                  //       $table->timestamp('approve_one_hr_tgl')->nullable();
                  //       $table->string('status', 50)->default('DRAFT');
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('submit_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_div')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_mid_div')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_mid_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_one_div')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_one_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->unique(['tahun', 'npk']);
                  // });

                  // Schema::create('hrdt_idp2s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp1_id')->unsigned();
                  //       $table->string('alc', 100);
                  //       $table->string('deskripsi', 2000);
                  //       $table->string('status', 1);
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp1_id')->references('id')->on('hrdt_idp1s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  //       $table->unique(['hrdt_idp1_id', 'alc', 'status']);
                  // });

                  // Schema::create('hrdt_idp3s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp2_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->string('target', 2000)->nullable();
                  //       $table->date('tgl_start')->nullable();
                  //       $table->date('tgl_finish')->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp2_id')->references('id')->on('hrdt_idp2s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idp4s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp1_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('achievement', 2000)->nullable();
                  //       $table->string('next_action', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp1_id')->references('id')->on('hrdt_idp1s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idp5s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp1_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('evaluation', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp1_id')->references('id')->on('hrdt_idp1s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idp1_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('tahun', 4);
                  //       $table->string('npk', 5);
                  //       $table->decimal('revisi', 2, 0)->default(0);
                  //       $table->string('kd_pt', 3);
                  //       $table->string('kd_div', 1);
                  //       $table->string('kd_dep', 2);
                  //       $table->string('kd_gol', 2);
                  //       $table->string('cur_pos', 50);
                  //       $table->string('proj_pos', 50);
                  //       $table->string('npk_dep_head', 5);
                  //       $table->string('npk_div_head', 5);
                  //       $table->string('submit_pic', 50)->nullable();
                  //       $table->timestamp('submit_tgl')->nullable();
                  //       $table->string('reject_pic', 50)->nullable();
                  //       $table->timestamp('reject_tgl')->nullable();
                  //       $table->string('reject_ket', 2000)->nullable();
                  //       $table->string('approve_div', 50)->nullable();
                  //       $table->timestamp('approve_div_tgl')->nullable();
                  //       $table->string('approve_hr', 50)->nullable();
                  //       $table->timestamp('approve_hr_tgl')->nullable();
                  //       $table->string('submit_mid_pic', 50)->nullable();
                  //       $table->timestamp('submit_mid_tgl')->nullable();
                  //       $table->string('reject_mid_pic', 50)->nullable();
                  //       $table->timestamp('reject_mid_tgl')->nullable();
                  //       $table->string('reject_mid_ket', 2000)->nullable();
                  //       $table->string('approve_mid_div', 50)->nullable();
                  //       $table->timestamp('approve_mid_div_tgl')->nullable();
                  //       $table->string('approve_mid_hr', 50)->nullable();
                  //       $table->timestamp('approve_mid_hr_tgl')->nullable();
                  //       $table->string('submit_one_pic', 50)->nullable();
                  //       $table->timestamp('submit_one_tgl')->nullable();
                  //       $table->string('reject_one_pic', 50)->nullable();
                  //       $table->timestamp('reject_one_tgl')->nullable();
                  //       $table->string('reject_one_ket', 2000)->nullable();
                  //       $table->string('approve_one_div', 50)->nullable();
                  //       $table->timestamp('approve_one_div_tgl')->nullable();
                  //       $table->string('approve_one_hr', 50)->nullable();
                  //       $table->timestamp('approve_one_hr_tgl')->nullable();
                  //       $table->string('status', 50)->default('DRAFT');
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('submit_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_div')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_mid_div')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_mid_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_one_div')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_one_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->unique(['tahun', 'npk', 'revisi']);
                  // });

                  // Schema::create('hrdt_idp2_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp1_reject_id')->unsigned();
                  //       $table->string('alc', 100);
                  //       $table->string('deskripsi', 2000);
                  //       $table->string('status', 1);
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp1_reject_id')->references('id')->on('hrdt_idp1_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idp3_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp2_reject_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->string('target', 2000)->nullable();
                  //       $table->date('tgl_start')->nullable();
                  //       $table->date('tgl_finish')->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp2_reject_id')->references('id')->on('hrdt_idp2_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idp4_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp1_reject_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('achievement', 2000)->nullable();
                  //       $table->string('next_action', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp1_reject_id')->references('id')->on('hrdt_idp1_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idp5_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idp1_reject_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('evaluation', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idp1_reject_id')->references('id')->on('hrdt_idp1_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idpdep1s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('tahun', 4);
                  //       $table->string('npk', 5);
                  //       $table->decimal('revisi', 2, 0)->default(0);
                  //       $table->string('kd_pt', 3);
                  //       $table->string('kd_div', 1);
                  //       $table->string('kd_dep', 2);
                  //       $table->string('kd_gol', 2);
                  //       $table->string('cur_pos', 50);
                  //       $table->string('proj_pos', 50);
                  //       $table->string('npk_div_head', 5);
                  //       $table->string('submit_pic', 50)->nullable();
                  //       $table->timestamp('submit_tgl')->nullable();
                  //       $table->string('reject_pic', 50)->nullable();
                  //       $table->timestamp('reject_tgl')->nullable();
                  //       $table->string('reject_ket', 2000)->nullable();
                  //       $table->string('approve_hr', 50)->nullable();
                  //       $table->timestamp('approve_hr_tgl')->nullable();
                  //       $table->string('submit_mid_pic', 50)->nullable();
                  //       $table->timestamp('submit_mid_tgl')->nullable();
                  //       $table->string('reject_mid_pic', 50)->nullable();
                  //       $table->timestamp('reject_mid_tgl')->nullable();
                  //       $table->string('reject_mid_ket', 2000)->nullable();
                  //       $table->string('approve_mid_hr', 50)->nullable();
                  //       $table->timestamp('approve_mid_hr_tgl')->nullable();
                  //       $table->string('submit_one_pic', 50)->nullable();
                  //       $table->timestamp('submit_one_tgl')->nullable();
                  //       $table->string('reject_one_pic', 50)->nullable();
                  //       $table->timestamp('reject_one_tgl')->nullable();
                  //       $table->string('reject_one_ket', 2000)->nullable();
                  //       $table->string('approve_one_hr', 50)->nullable();
                  //       $table->timestamp('approve_one_hr_tgl')->nullable();
                  //       $table->string('status', 50)->default('DRAFT');
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('submit_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_mid_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_one_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->unique(['tahun', 'npk', 'kd_dep']);
                  // });

                  // Schema::create('hrdt_idpdep2s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep1_id')->unsigned();
                  //       $table->string('alc', 100);
                  //       $table->string('deskripsi', 2000);
                  //       $table->string('status', 1);
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep1_id')->references('id')->on('hrdt_idpdep1s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  //       $table->unique(['hrdt_idpdep1_id', 'alc', 'status']);
                  // });

                  // Schema::create('hrdt_idpdep3s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep2_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->string('target', 2000)->nullable();
                  //       $table->date('tgl_start')->nullable();
                  //       $table->date('tgl_finish')->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep2_id')->references('id')->on('hrdt_idpdep2s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idpdep4s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep1_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('achievement', 2000)->nullable();
                  //       $table->string('next_action', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep1_id')->references('id')->on('hrdt_idpdep1s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idpdep5s', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep1_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('evaluation', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep1_id')->references('id')->on('hrdt_idpdep1s')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idpdep1_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->string('tahun', 4);
                  //       $table->string('npk', 5);
                  //       $table->decimal('revisi', 2, 0)->default(0);
                  //       $table->string('kd_pt', 3);
                  //       $table->string('kd_div', 1);
                  //       $table->string('kd_dep', 2);
                  //       $table->string('kd_gol', 2);
                  //       $table->string('cur_pos', 50);
                  //       $table->string('proj_pos', 50);
                  //       $table->string('npk_div_head', 5);
                  //       $table->string('submit_pic', 50)->nullable();
                  //       $table->timestamp('submit_tgl')->nullable();
                  //       $table->string('reject_pic', 50)->nullable();
                  //       $table->timestamp('reject_tgl')->nullable();
                  //       $table->string('reject_ket', 2000)->nullable();
                  //       $table->string('approve_hr', 50)->nullable();
                  //       $table->timestamp('approve_hr_tgl')->nullable();
                  //       $table->string('submit_mid_pic', 50)->nullable();
                  //       $table->timestamp('submit_mid_tgl')->nullable();
                  //       $table->string('reject_mid_pic', 50)->nullable();
                  //       $table->timestamp('reject_mid_tgl')->nullable();
                  //       $table->string('reject_mid_ket', 2000)->nullable();
                  //       $table->string('approve_mid_hr', 50)->nullable();
                  //       $table->timestamp('approve_mid_hr_tgl')->nullable();
                  //       $table->string('submit_one_pic', 50)->nullable();
                  //       $table->timestamp('submit_one_tgl')->nullable();
                  //       $table->string('reject_one_pic', 50)->nullable();
                  //       $table->timestamp('reject_one_tgl')->nullable();
                  //       $table->string('reject_one_ket', 2000)->nullable();
                  //       $table->string('approve_one_hr', 50)->nullable();
                  //       $table->timestamp('approve_one_hr_tgl')->nullable();
                  //       $table->string('status', 50)->default('DRAFT');
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('submit_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_mid_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_mid_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('submit_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('reject_one_pic')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('approve_one_hr')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->unique(['tahun', 'npk', 'kd_dep', 'revisi']);
                  // });

                  // Schema::create('hrdt_idpdep2_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep1_reject_id')->unsigned();
                  //       $table->string('alc', 100);
                  //       $table->string('deskripsi', 2000);
                  //       $table->string('status', 1);
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep1_reject_id')->references('id')->on('hrdt_idpdep1_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idpdep3_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep2_reject_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->string('target', 2000)->nullable();
                  //       $table->date('tgl_start')->nullable();
                  //       $table->date('tgl_finish')->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep2_reject_id')->references('id')->on('hrdt_idpdep2_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idpdep4_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep1_reject_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('achievement', 2000)->nullable();
                  //       $table->string('next_action', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep1_reject_id')->references('id')->on('hrdt_idpdep1_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });

                  // Schema::create('hrdt_idpdep5_rejects', function (Blueprint $table) {
                  //       $table->increments('id');
                  //       $table->integer('hrdt_idpdep1_reject_id')->unsigned();
                  //       $table->string('program', 2000)->nullable();
                  //       $table->date('tgl_program')->nullable();
                  //       $table->string('evaluation', 2000)->nullable();
                  //       $table->timestamp('dtcrea');
                  //       $table->string('creaby', 50);
                  //       $table->timestamp('dtmodi')->nullable();
                  //       $table->string('modiby', 50)->nullable();
                  //       $table->foreign('creaby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('modiby')->references('username')->on('users')
                  //             ->onUpdate('cascade')->onDelete('restrict');
                  //       $table->foreign('hrdt_idpdep1_reject_id')->references('id')->on('hrdt_idpdep1_rejects')
                  //             ->onUpdate('cascade')->onDelete('cascade');
                  // });
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
