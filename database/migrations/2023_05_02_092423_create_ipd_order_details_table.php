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
        Schema::create('ipd_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_order_master_id');
            $table->integer('order_type_id');
            $table->integer('order_subtype_id');
            $table->jsonb('multi_subtype_id');
            $table->date('off_date')->nullable();
            $table->time('off_time')->nullable();
            $table->char('order_type', 1);
            $table->string('other', 500)->nullable();
            $table->integer('off_by')->nullable();
            $table->integer('off_confirm_by')->nullable();
            $table->boolean('closed')->nullable();
            $table->integer('ipd_order_template_detail_id')->nullable();
            $table->boolean('pre_order')->nullable();
            $table->date('pre_order_date')->nullable();
            $table->time('pre_order_time')->nullable();
            $table->jsonb('ref_ids')->nullable();
            $table->jsonb('ref_on_ids')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_order_details');
    }
};
