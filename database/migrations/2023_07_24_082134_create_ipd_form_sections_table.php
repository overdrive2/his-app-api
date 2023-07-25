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
        Schema::create('ipd_form_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('ipd_form_asm_id');
            $table->string('col');
            $table->integer('parent_id');
            $table->smallInteger('display_order');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_form_sections');
    }
};
