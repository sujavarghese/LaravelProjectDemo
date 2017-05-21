<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users_log');
        Schema::create('users_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('upload_status');
            $table->string('validation_status');
            $table->string('load_status');
            $table->string('user');
            $table->integer('count');
            $table->string('boundary_code');
            $table->string('boundary_type');
            $table->timestamp('created_at');
            $table->LONGTEXT('validation_result');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_log');
    }
}
