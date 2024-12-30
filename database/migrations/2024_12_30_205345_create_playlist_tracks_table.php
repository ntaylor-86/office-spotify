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
        Schema::create('playlist_tracks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('uri');
            $table->string('title');
            $table->string('artist');
            $table->string('album');
            $table->boolean('explicit');
            $table->dateTime('added_at');
            $table->integer('duration');
            $table->integer('up_votes')->default(0);
            $table->integer('down_votes')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_tracks');
    }
};
