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
            $table->date('off_date');
            $table->time('off_time');
            $table->char('order_type', 1);
            $table->string('other', 500);
            $table->integer('off_by');
            $table->integer('off_confirn_by');
            $table->boolean('closed');
            $table->integer('ipd_order_template_detail_id');
            $table->boolean('pre_order');
            $table->date('pre_order_date');
            $table->time('pre_order_time');
            $table->jsonb('ref_ids');
            $table->jsonb('ref_on_ids');
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
