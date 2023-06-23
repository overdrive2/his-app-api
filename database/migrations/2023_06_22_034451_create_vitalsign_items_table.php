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
        Schema::create('vitalsign_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_ename',100);  
            $table->string('item_tname',100);  
            $table->string('item_display',100);  
            $table->string('type_result',100);  
            $table->boolean('show_graph');  
            $table->boolean('active');        
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
        Schema::dropIfExists('vitalsign_items');
    }
};
