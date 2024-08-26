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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('album_id');

            $table->string('song_name');
            $table->unsignedBigInteger('genre_id');
            $table->time('duration');
            $table->year('release_year');
            $table->boolean('is_explicit');
            $table->string('song_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
