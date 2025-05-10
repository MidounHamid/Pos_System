<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('designation');
            $table->float('prix_ht');
            $table->float('tva');
            $table->float('stock');
            $table->string('photo')->nullable(); // photo may be optional
            $table->string('code_barre')->unique(); // make it string to support big codes
            $table->unsignedBigInteger('famille_id');
            $table->foreign('famille_id')->references('id')->on('familles');
            $table->unsignedBigInteger('marque_id');
            $table->foreign('marque_id')->references('id')->on('marques');
            $table->unsignedBigInteger('unite_id');
            $table->foreign('unite_id')->references('id')->on('unites');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
