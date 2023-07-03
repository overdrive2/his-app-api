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
        Schema::create('occu_ipd_staff_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_id');
            $table->integer('staff_id');
            $table->decimal('value',2)->nullable(); 
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
        Schema::dropIfExists('occu_ipd_staff_lists');
    }
};
