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
        Schema::create('ipd_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_name', 100);
            $table->boolean('is_occu');
            $table->boolean('is_adding');
            $table->boolean('is_report');
            $table->smallInteger('display_order')->nullable();  
            $table->smallInteger('report_order')->nullable();  
            $table->integer('created_by')->nullable();  
            $table->integer('updated_by')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipd_records');
    }
};
