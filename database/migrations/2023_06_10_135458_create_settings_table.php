<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('email')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('logo')->default('logo.png');
            $table->string('fav_icon')->default('fav_icon.png');
            $table->string('footer_text_theme')->nullable();
            $table->string('footer_text_reports_admin')->nullable();
            $table->string('footer_text_reports_dev')->nullable();
            $table->string('mail_driver')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('host')->nullable();
            $table->string('port')->nullable();
            $table->string('encryption')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
