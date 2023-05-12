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
        Schema::create('ipd_occu_details', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_id');
            $table->integer('ipd_id');
            $table->integer('ipd_occu_type_id');
            $table->boolean('is_getout');
            $table->integer('dch_type_id')->nullable();
            $table->integer('ipd_severe_type_id');
            $table->integer('ipd_admit_type_id');
            $table->string('bedno',6);
            $table->date('move_date');
            $table->time('move_time');
            $table->integer('updated_by');
            $table->integer('created_by');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_occu_details');
    }
};
