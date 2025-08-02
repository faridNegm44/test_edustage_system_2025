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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('login_name')->unique();
            $table->string('login_barcode')->nullable()->unique();
            $table->integer('phone')->nullable();
            $table->tinyInteger('role');
            $table->tinyInteger('theme')->default(1);
            $table->string('address')->nullable();
            $table->integer('nat_id')->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->string('image')->default("df_image.png");
            $table->tinyInteger('gender')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->datetime('last_login_time')->nullable();
            $table->string('note')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
