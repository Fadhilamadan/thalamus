<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaskesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faskes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_tempat', 255);
            $table->string('alamat', 255);
            $table->text('deskripsi');
            $table->string('telepon', 12);
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->string('hari_buka', 100);
            $table->string('hari_tutup', 100);
            $table->string('latitude', 255);
            $table->string('longitude', 255);
            $table->tinyInteger('hapus');
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
        Schema::dropIfExists('faskes');
    }
}