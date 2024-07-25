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
        Schema::create('daily_intakes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('breakfast');
            $table->unsignedBigInteger('lunch');
            $table->unsignedBigInteger('dinner');
            $table->unsignedInteger('breakfast_portion');
            $table->unsignedInteger('lunch_portion');
            $table->unsignedInteger('dinner_portion');
            $table->unsignedBigInteger('user_id');

            $table->foreign('breakfast')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('lunch')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('dinner')->references('id')->on('recipes')->onDelete('cascade');
          


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_intakes');
    }
};
