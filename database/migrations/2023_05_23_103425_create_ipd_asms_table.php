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
        Schema::create('ipd_asms', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->date('asm_date');
            $table->time('asm_time');
            $table->integer('ipd_asm_form_id');
            $table->integer('ipd_nurse_shift_id');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('saved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_asms');
    }
};
