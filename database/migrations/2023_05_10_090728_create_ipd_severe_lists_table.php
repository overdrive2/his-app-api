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
        Schema::create('ipd_severe_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->integer('ipd_severe_id');  
            $table->text('remark')->nullable();   
            $table->timestamp('severe_start')->nullable();   
            $table->timestamp('severe_end')->nullable();   
            $table->integer('duration')->nullable();     
            $table->integer('ward_id')->nullable();     
            $table->integer('bed_id')->nullable();     
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
        Schema::dropIfExists('ipd_severe_lists');
    }
};
