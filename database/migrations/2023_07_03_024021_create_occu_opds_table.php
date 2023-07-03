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
        Schema::create('occu_opds', function (Blueprint $table) {
            $table->id();
            $table->date('nurse_shift_date');
            $table->time('nurse_shift_time');
            $table->integer('occu_dep_id');
            $table->integer('occu_status_id');
            $table->integer('ipd_nurse_shift_id');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('occu_opds');
    }
};
