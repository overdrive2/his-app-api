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
        Schema::create('ipd_form_asm_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_form_asm_id');
            $table->string('web_label',100);
            $table->string('report_label',100);
            $table->string('input_type',100);
            $table->jsonb('lookup_json')->nullable();
            $table->string('default_value');
            $table->boolean('have_other');
            $table->string('lookup_sql',100)->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('no',5);
            $table->integer('display_order')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->smallInteger('colspan');
            $table->integer('ipd_form_section_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_form_asm_details');
    }
};
