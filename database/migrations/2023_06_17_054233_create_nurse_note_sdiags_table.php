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
        Schema::create('nurse_note_sdiags', function (Blueprint $table) {
            $table->id();
            $table->string('sdiag_name',255);
            $table->integer('icd10_id')->nullable();
            $table->integer('domain_class_id')->nullable();
            $table->boolean('active');
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
        Schema::dropIfExists('nurse_note_sdiags');
    }
};
