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
        Schema::table('songs', function (Blueprint $table) {
            $table->renameColumn('played_times', 'playbacks');
        });

        Schema::table('albums', function (Blueprint $table) {
            $table->renameColumn('played_times', 'playbacks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
