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
        Schema::create('occu_opd_type_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_dep_id');
            $table->integer('occu_type_id');
            $table->integer('display_order');
            $table->boolean('is_print');
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
        Schema::dropIfExists('occu_opd_type_lists');
    }
};
