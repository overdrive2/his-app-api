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
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->string('bed_name',100);
            $table->string('bed_code',6)->nullable();
            $table->integer('room_id')->nullable();
            $table->integer('bed_status_id');
            $table->integer('display_order')->nullable();
            $table->integer('updated_by');
            $table->integer('created_by');
            $table->integer('last_bedmove_id');
            $table->boolean('empty_flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
