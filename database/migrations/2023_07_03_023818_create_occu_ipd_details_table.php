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
        Schema::create('occu_ipd_details', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_id');
            $table->integer('ipd_id');
            $table->integer('occu_ipd_type_id');
            $table->boolean('is_getout');
            $table->integer('dch_type_id')->nullable();
            $table->integer('ipd_severe_type_id');
            $table->integer('ipd_admit_type_id');
            $table->integer('ipd_bedmove_id');
            $table->integer('updated_by')->nullable(); 
            $table->integer('created_by')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occu_ipd_details');
    }
};
