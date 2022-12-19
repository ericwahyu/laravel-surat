<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeperluanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keperluan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('format_id');
            $table->string('nama');
            $table->string('kode');
            $table->string('penomoran');
            $table->timestamps();

            $table->foreign('format_id')->references('id')->on('format')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keperluan');
    }
}
