<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('app.env', 'local') === 'lokal') {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('username', 50)->unique();
                $table->string('email')->unique();
                $table->string('init_supp', 10);
                $table->string('password');
                $table->rememberToken();
                $table->timestamp('last_login')->nullable();
                $table->timestamps();
                $table->string('verification_token')->nullable();
                $table->boolean('is_verified')->default(0);
                $table->char('status_active', 1)->default('T');
                $table->string('picture')->nullable();
                $table->string('last_login_ip', 50)->nullable();
                $table->string('telegram_id', 50)->nullable()->unique();
                $table->string('no_hp', 15)->nullable();
                $table->string('st_collapse', 1)->default('F');
            });

            Schema::create('logs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('keterangan');
                $table->string('ip', 50)->nullable();
                $table->timestamps();
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
            //WO
            Schema::dropIfExists('work_orders');
            //IDP
            Schema::dropIfExists('hrdt_idpdep5_rejects');
            Schema::dropIfExists('hrdt_idpdep4_rejects');
            Schema::dropIfExists('hrdt_idpdep3_rejects');
            Schema::dropIfExists('hrdt_idpdep2_rejects');
            Schema::dropIfExists('hrdt_idpdep1_rejects');
            Schema::dropIfExists('hrdt_idpdep5s');
            Schema::dropIfExists('hrdt_idpdep4s');
            Schema::dropIfExists('hrdt_idpdep3s');
            Schema::dropIfExists('hrdt_idpdep2s');
            Schema::dropIfExists('hrdt_idpdep1s');
            Schema::dropIfExists('hrdt_idp5_rejects');
            Schema::dropIfExists('hrdt_idp4_rejects');
            Schema::dropIfExists('hrdt_idp3_rejects');
            Schema::dropIfExists('hrdt_idp2_rejects');
            Schema::dropIfExists('hrdt_idp1_rejects');
            Schema::dropIfExists('hrdt_idp5s');
            Schema::dropIfExists('hrdt_idp4s');
            Schema::dropIfExists('hrdt_idp3s');
            Schema::dropIfExists('hrdt_idp2s');
            Schema::dropIfExists('hrdt_idp1s');
            // Schema::dropIfExists('hrdm_alc3s');
            // Schema::dropIfExists('hrdm_alc2s');
            // Schema::dropIfExists('hrdm_alc1s');
            // Schema::dropIfExists('hrdm_lms');
            //KPI
            Schema::dropIfExists('hrdt_kpi_dep_rejects');
            Schema::dropIfExists('hrdt_kpi_act_rejects');
            Schema::dropIfExists('hrdt_kpi_rejects');
            Schema::dropIfExists('hrdt_kpi_deps');
            Schema::dropIfExists('hrdt_kpi_acts');
            Schema::dropIfExists('hrdt_kpis');
            // Schema::dropIfExists('hrdm_kpi_refs');
            //PICA
            Schema::dropIfExists('pica_rejects');
            Schema::dropIfExists('picas');
            Schema::dropIfExists('qpr_emails');
            // Schema::dropIfExists('qprs');
            // PP REG
            Schema::dropIfExists('pp_reg_details');
            Schema::dropIfExists('pp_regs');
            //USER
            Schema::dropIfExists('logs');
            Schema::drop('users');
        }
    }
}
