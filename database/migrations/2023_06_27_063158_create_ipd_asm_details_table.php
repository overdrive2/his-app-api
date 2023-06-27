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
        Schema::create('ipd_asm_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_asm_id');
            $table->integer('ipd_form_asm_detail_id');
            $table->string('asm_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_asm_details');
    }
};
