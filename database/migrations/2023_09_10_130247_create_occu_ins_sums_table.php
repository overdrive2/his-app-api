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
        Schema::create('occu_ins_sums', function (Blueprint $table) {
            $table->id();
            $table->integer('occu_ins_id');  
            $table->integer('max_ward_id')->nullable();  
            $table->integer('max_qty1')->nullable();  
            $table->integer('max_qty2')->nullable();  
            $table->integer('max_s5_ward_id')->nullable();  
            $table->integer('max_s5_qty1')->nullable();  
            $table->integer('max_s5_qty2')->nullable();  
            $table->integer('max_occu_ward_id')->nullable();  
            $table->decimal('max_occu_qty',10,2)->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occu_ins_sums');
    }
};
