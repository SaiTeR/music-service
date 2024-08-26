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
        Schema::table('albums', function (Blueprint $table) {
            $table->string('image_path')->nullable()->default('image/default-artist.png');;

        });

        Schema::table('artists', function (Blueprint $table) {
            $table->string('image_path')->nullable()->default('image/default-artist.png');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image_path')->default('image/default-avatar.png');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('album_artist_and_user', function (Blueprint $table) {
            //
        });
    }
};
