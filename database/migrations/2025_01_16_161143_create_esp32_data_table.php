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
    Schema::create('esp32_data', function (Blueprint $table) {
        $table->id();
        $table->float('temperature');
        $table->float('humidity');
        $table->float('LightIntensity');
        $table->float('weight');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esp32_data');
    }

};
