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
        Schema::create('diets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('diet_name');
            $table->smallInteger('cal')->nullable();;
            $table->decimal('cho',8, 2)->nullable();;
            $table->decimal('protein',8, 2)->nullable();;
            $table->decimal('fat', 8, 2)->nullable();;
            $table->string('other')->nullable();
            $table->smallInteger('diet_type_id')->nullable();
            $table->smallInteger('diet_option_id')->nullable();
            $table->smallInteger('display_order')->nullable();
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};
