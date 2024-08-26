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
            $table->string('image_path')->default('image/default-album.png')->change(); // Убираем nullable и устанавливаем значение по умолчанию
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->string('image_path')->default('image/default-artist.png')->change(); // Убираем nullable и устанавливаем значение по умолчанию
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('image_path')->default('image/default-avatar.png')->change(); // Убираем nullable и устанавливаем значение по умолчанию
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
