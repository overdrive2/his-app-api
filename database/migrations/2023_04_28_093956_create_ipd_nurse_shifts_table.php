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
        Schema::create('ipd_nurse_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('nurse_shift_name',100);
            $table->date('stime');
            $table->time('etime');
            $table->integer('display_order');
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
        Schema::dropIfExists('ipd_nurse_shifts');
    }
};
