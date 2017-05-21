<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoundaryLayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('boundaries');
        Schema::create('boundaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('boundary_type');
            $table->string('boundary_name');
            $table->string('added_by');
            $table->timestamp('created_at');
            $table->LONGTEXT('coordinates');
            $table->unsignedInteger('job_code');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boundaries');
    }
}
