<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name',100);
            $table->unsignedBigInteger('responsible_person_id');
            $table->foreign('responsible_person_id')->references('id')->on('users');
            $table->string('status_code', 15)->default('active');
                // $table->foreign('status_code')->references('status_code')->on('statuses');
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('created_user_id');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('updated_user_id');
            $table->boolean('del_flg')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
