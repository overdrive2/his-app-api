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
        Schema::create('opd_occus', function (Blueprint $table) {
            $table->id();
            $table->date('nurse_shift_date');
            $table->integer('occu_dep_id');
            $table->integer('occu_status_id');
            $table->integer('ipd_nurse_shift_id');
            $table->text('note');
            $table->integer('updated_by');
            $table->integer('created_by');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_occus');
    }
};
