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
        Schema::create('ipd_record_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('ipd_id');
            $table->integer('ipd_record_id');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();  
            $table->integer('ipd_bedmove_id');
            $table->smallInteger('duration')->nullable();  
            $table->string('remark', 100)->nullable();  
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
        Schema::dropIfExists('ipd_record_lists');
    }
};
