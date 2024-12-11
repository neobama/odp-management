<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Nama klien
            $table->foreignId('odp_id') // Foreign key ke tabel ODP
                  ->constrained('odps')
                  ->onDelete('cascade'); // Hapus klien jika ODP dihapus
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}

