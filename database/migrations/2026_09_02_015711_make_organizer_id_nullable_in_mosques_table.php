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
        Schema::table('mosques', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->unsignedBigInteger('organizer_id')->nullable()->change();
            $table->foreign('organizer_id')->references('id')->on('organizers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mosques', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->unsignedBigInteger('organizer_id')->nullable(false)->change();
            $table->foreign('organizer_id')->references('id')->on('organizers')->cascadeOnDelete();
        });
    }
};
