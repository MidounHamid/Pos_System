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
        Schema::create('details_bl', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('articles_id');
            $table->foreign('articles_id')->references('id')->on('articles');
            $table->unsignedBigInteger('command_id');
            $table->foreign('command_id')->references('id')->on('commandes');
            $table->float('qte');
            $table->float('prix_vente_ht');
            $table->float('tva');
            $table->float('remise');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_bl');
    }
};
