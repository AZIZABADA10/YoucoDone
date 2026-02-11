<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained()->onDelete('cascade');
            $table->string('jour');
            $table->time('heure_ouverture');
            $table->time('heure_fermeture');
            $table->enum('statut', ['ouvert', 'ferme'])->default('ouvert');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horaires');
    }
};