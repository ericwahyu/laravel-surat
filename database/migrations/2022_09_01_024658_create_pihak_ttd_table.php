<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePihakTtdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pihak_ttd', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generate_id');
            $table->string('jabatan');
            $table->string('nip');
            $table->timestamps();

            $table->foreign('generate_id')->references('id')->on('generate')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pihak_ttd');
    }
}
