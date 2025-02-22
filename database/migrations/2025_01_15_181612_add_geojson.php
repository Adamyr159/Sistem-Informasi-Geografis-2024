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
        Schema::table('provinces', function (Blueprint $table) {
            $table->string('geojson_path')->after('longitude')->nullable();
        });

        Schema::table('regencies', function (Blueprint $table) {
            $table->string('geojson_path')->after('longitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provinces', function (Blueprint $table) {
            $table->dropColumn('geojson_path');
        });

        Schema::table('regencies', function (Blueprint $table) {
            $table->dropColumn('geojson_path');
        });
    }
};
