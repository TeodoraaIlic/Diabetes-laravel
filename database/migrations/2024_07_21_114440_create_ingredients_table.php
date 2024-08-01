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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name',32);
            $table->string('category');
            $table->integer('kcal');
            $table->decimal('carbohydrate',10,2);
            $table->decimal('fat',10,2);
            $table->decimal('protein',10,2);
            $table->enum('measurement_unit',['100_grams','100_ml','1_piece']);
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
