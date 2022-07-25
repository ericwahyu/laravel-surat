<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisiUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisi_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disposisi_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('status')->nullable();
            $table->timestamps();

            $table->foreign('disposisi_id')->references('id')->on('disposisi')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisi_user');
    }
}
