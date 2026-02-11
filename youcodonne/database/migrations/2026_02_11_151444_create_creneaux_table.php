<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creneaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horaire_id')->constrained()->onDelete('cascade');
            $table->dateTime('hd'); 
            $table->dateTime('hf'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creneaux');
    }
};