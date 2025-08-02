<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_table_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('type_history');
            $table->integer('relation_id')->nullable();
            $table->string('times')->nullable();
            $table->integer('group_id_time')->nullable();
            $table->string('class_type_time')->nullable();
            $table->string('day_time')->nullable();
            $table->string('date_time')->nullable();
            $table->integer('room_id_time')->nullable();
            $table->string('notes_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_table_histories');
    }
};
