<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_name',100);
            $table->unsignedBigInteger('responsible_person_id');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects')
            ->onDelete('cascade');
            $table->string('status_code', 15)->default('not-started');
            $table->text('content');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('created_user_id');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('updated_user_id');
            $table->boolean('del_flg')->default(0);;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
