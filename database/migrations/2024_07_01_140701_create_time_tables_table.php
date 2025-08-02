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
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('group_id');
            $table->string('notes')->nullable();
            $table->string('day');
            $table->string('date')->nullable();
            $table->string('class_type');
            $table->string('class_time');
            $table->string('time_from');
            $table->string('time_to');
            $table->integer('room_id');
            $table->integer('user_add');
            $table->integer('user_edit');
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
        Schema::dropIfExists('time_tables');
    }
};
