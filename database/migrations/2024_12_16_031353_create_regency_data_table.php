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
        Schema::create('regency_data', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->foreignId('name_data_id')->constrained('name_data')->onDelete('cascade');
            $table->foreignId('regency_id')->constrained('regencies')->onDelete('cascade');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regency_data');
    }
};
