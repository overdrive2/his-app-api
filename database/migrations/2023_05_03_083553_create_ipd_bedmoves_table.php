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
        Schema::create('ipd_bedmoves', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->date('movedate');
            $table->time('movetime');
            $table->integer('bed_id');
            $table->integer('bedmove_type_id');
            $table->integer('ref_id');
            $table->integer('ward_id');
            $table->integer('updated_by');
            $table->integer('created_by');
            $table->boolean('delflag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_bedmoves');
    }
};
