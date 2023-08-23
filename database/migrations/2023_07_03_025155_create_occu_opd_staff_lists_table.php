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
        Schema::create('occu_opd_staff_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_id');
            $table->integer('staff_id');
            $table->integer('qty'); 
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
        Schema::dropIfExists('occu_opd_staff_lists');
    }
};
