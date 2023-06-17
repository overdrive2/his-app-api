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
        Schema::create('nurse_note_asses_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('diag_id');
            $table->integer('asses_id');
            $table->boolean('icd_on_asses');
            $table->smallInteger('display_order')->nullable();
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
        Schema::dropIfExists('nurse_note_asses_lists');
    }
};
