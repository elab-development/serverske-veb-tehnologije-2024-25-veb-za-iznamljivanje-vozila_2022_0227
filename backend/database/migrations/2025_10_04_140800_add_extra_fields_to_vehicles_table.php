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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->enum('vehicle_type', ['hatchback','suv','sport','sedan'])->nullable();
            $table->enum('fuel_type', ['petrol','diesel','hybrid','electric'])->nullable();
            $table->enum('transmission', ['manual','automatic'])->nullable();
            $table->integer('seats')->nullable();
            $table->decimal('tank_capacity', 5, 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['vehicle_type','fuel_type','transmission','seats','tank_capacity']);
        });
    }
};
