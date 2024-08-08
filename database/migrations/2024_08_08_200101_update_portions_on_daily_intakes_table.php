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
            $table->unsignedInteger('breakfast_portion')->nullable()->change();
            $table->unsignedInteger('lunch_portion')->nullable()->change();
            $table->unsignedInteger('dinner_portion')->nullable()->change();        
        });
    }

    public function down()
    {
        Schema::table('daily_intakes', function (Blueprint $table) {
            $table->unsignedInteger('breakfast_portion')->nullable(false)->change();
            $table->unsignedInteger('lunch_portion')->nullable(false)->change();
            $table->unsignedInteger('dinner_portion')->nullable(false)->change();
        });
    }
};
