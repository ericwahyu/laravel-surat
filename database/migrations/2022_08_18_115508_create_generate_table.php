<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->unsignedBigInteger('keperluan_id');
            $table->unsignedBigInteger('surat_id');
            $table->text('content');
            $table->text('footer_content')->nullable();
            $table->string('tempat');
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('template')->onDelete('cascade');
            $table->foreign('keperluan_id')->references('id')->on('keperluan')->onDelete('cascade');
            $table->foreign('surat_id')->references('id')->on('surat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generate');
    }
}
