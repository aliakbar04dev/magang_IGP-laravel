<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMptMstrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('app.env', 'local') === 'lokal') {
            // schema::create('b_suppliers', function (blueprint $table) {
            //     $table->string('kd_supp', 10);
            //     $table->string('nama', 100);
            //     $table->string('email', 300)->nullable();
            //     $table->string('init_supp', 10)->nullable();
            //     $table->string('npwp', 21)->nullable();
            //     $table->primary('kd_supp');
            // });
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
            // Schema::dropIfExists('b_suppliers');
        }
    }
}
