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
        Schema::create('ipd_doctor_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->integer('officer_id');  
            $table->integer('ipd_doctor_type_id');  
            $table->boolean('active');  
            $table->text('remark')->nullable();   
            $table->date('incharge_date')->nullable();   
            $table->time('incharge_time')->nullable();   
            $table->date('finish_date')->nullable();   
            $table->time('finish_time')->nullable();   
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
        Schema::dropIfExists('ipd_doctor_lists');
    }
};
