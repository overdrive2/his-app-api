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
        Schema::create('occu_ins_details', function (Blueprint $table) {
            $table->id();
            $table->date('occu_ins_id');
            $table->text('occu_ins_event')->nullable(); 
            $table->text('occu_ins_solve')->nullable(); 
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
        Schema::dropIfExists('occu_ins_details');
    }
};
