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
        Schema::create('ipd_vitalsign_masters', function (Blueprint $table) {
            $table->id();
            $table->date('vitalsign_date');
            $table->time('vitalsign_time');
            $table->integer('ipd_nurse_shift_id');
            $table->integer('ward_id');
            $table->integer('qty');
            $table->boolean('saved');
            $table->boolean('active');
            $table->integer('vitalsign_type_id');
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
        Schema::dropIfExists('ipd_vitalsign_masters');
    }
};
