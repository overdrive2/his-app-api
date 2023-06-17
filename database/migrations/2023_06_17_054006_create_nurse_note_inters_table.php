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
        Schema::create('nurse_note_inters', function (Blueprint $table) {
            $table->id();
            $table->string('inter_name',255);
            $table->string('unit',50);
            $table->integer('icd10_id')->nullable();
            $table->boolean('active');
            $table->integer('link_type_id')->nullable();
            $table->string('link_type_code',255);
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
        Schema::dropIfExists('nurse_note_inters');
    }
};
