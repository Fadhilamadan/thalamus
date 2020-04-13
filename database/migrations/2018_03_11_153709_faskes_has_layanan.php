<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FaskesHasLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faskes_has_layanan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('faskes_id')->unsigned();
            $table->foreign('faskes_id')->references('id')->on('faskes')->onDelete('cascade');
            $table->integer('layanan_id')->unsigned();
            $table->foreign('layanan_id')->references('id')->on('layanan')->onDelete('cascade');
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
        Schema::dropIfExists('faskes_has_layanan');
    }
}
