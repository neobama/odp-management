<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdpsTable extends Migration
{
    public function up()
    {
        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama ODP
            $table->decimal('latitude', 10, 8); // Koordinat latitude
            $table->decimal('longitude', 11, 8); // Koordinat longitude
            $table->integer('capacity'); // Kapasitas maksimum klien
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
