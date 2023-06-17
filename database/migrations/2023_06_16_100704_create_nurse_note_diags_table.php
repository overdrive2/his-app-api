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
        Schema::create('nurse_note_diags', function (Blueprint $table) {
            $table->id();
            $table->string('diag_name',255);
            $table->string('diag_obj',255)->nullable();
            $table->string('diag_keyword',100)->nullable();
            $table->smallInteger('display_order')->nullable();
            $table->integer('icd10_id')->nullable();
            $table->integer('domain_class_id')->nullable();
            $table->boolean('active');
            $table->string('auto_eva',255)->nullable();
            $table->boolean('icd_on_subdx');
            $table->boolean('icd_on_asses');
            $table->boolean('icd_on_inter');
            $table->smallInteger('icd_on_subdx_count');
            $table->smallInteger('icd_on_asses_count');
            $table->smallInteger('icd_on_inter_count');
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
        Schema::dropIfExists('nurse_note_diags');
    }
};
