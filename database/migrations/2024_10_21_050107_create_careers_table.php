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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText(column: 'requirements');
            $table->foreignId('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreignId('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreignId('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('posts')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
