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
        Schema::create('ipd_dches', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->boolean('confirm_discharge');
            $table->date('dchdate');
            $table->time('dchtime');
            $table->integer('dch_status_id');
            $table->integer('dch_type_id');
            $table->integer('dch_officer_id');
            $table->integer('dch_ipd_severe_id');
            $table->integer('dch_spclty_id');
            $table->integer('los')->nullable();
            $table->text('sdx1')->nullable();
            $table->text('sdx2')->nullable();
            $table->boolean('confirm_summary_dc')->nullable();
            $table->integer('summary_dc_officer_id')->nullable();
            $table->text('plan')->nullable();
            $table->text('operation')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_dches');
    }
};
