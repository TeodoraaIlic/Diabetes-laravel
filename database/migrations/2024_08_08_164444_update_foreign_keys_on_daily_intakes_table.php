<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('daily_intakes', function (Blueprint $table) {
            // Safely drop the foreign keys if they exist
            DB::statement('ALTER TABLE daily_intakes DROP FOREIGN KEY IF EXISTS daily_intakes_breakfast_foreign');
            DB::statement('ALTER TABLE daily_intakes DROP FOREIGN KEY IF EXISTS daily_intakes_lunch_foreign');
            DB::statement('ALTER TABLE daily_intakes DROP FOREIGN KEY IF EXISTS daily_intakes_dinner_foreign');

            // Modify the columns to be nullable and unsignedBigInteger
            $table->unsignedBigInteger('breakfast')->nullable()->change();
            $table->unsignedBigInteger('lunch')->nullable()->change();
            $table->unsignedBigInteger('dinner')->nullable()->change();

            // Re-add the foreign key constraints with ON DELETE CASCADE
            $table->foreign('breakfast')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('lunch')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('dinner')->references('id')->on('recipes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('daily_intakes', function (Blueprint $table) {
            // Safely drop the updated foreign keys if they exist
            DB::statement('ALTER TABLE daily_intakes DROP FOREIGN KEY IF EXISTS daily_intakes_breakfast_foreign');
            DB::statement('ALTER TABLE daily_intakes DROP FOREIGN KEY IF EXISTS daily_intakes_lunch_foreign');
            DB::statement('ALTER TABLE daily_intakes DROP FOREIGN KEY IF EXISTS daily_intakes_dinner_foreign');

            // Revert the columns to be non-nullable and unsignedBigInteger
            $table->unsignedBigInteger('breakfast')->nullable(false)->change();
            $table->unsignedBigInteger('lunch')->nullable(false)->change();
            $table->unsignedBigInteger('dinner')->nullable(false)->change();

            // Re-add the original foreign key constraints
            $table->foreign('breakfast')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('lunch')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('dinner')->references('id')->on('recipes')->onDelete('cascade');
        });
    }
};
