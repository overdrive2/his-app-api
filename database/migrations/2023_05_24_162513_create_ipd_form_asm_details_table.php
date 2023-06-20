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
            $table->boolean('have_other');
            $table->string('lookup_sql',100)->nullable();
            $table->integer('group_display')->nullable();
            $table->integer('sub_group_display')->nullable();
            $table->integer('display_order')->nullable();
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
        Schema::dropIfExists('ipd_form_asm_details');
    }
};
