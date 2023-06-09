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
        Schema::create('occu_opd_dep_groups', function (Blueprint $table) {
            $table->id();
            $table->string('occu_dep_group_name',100);
            $table->text('sql_command')->nullable();  
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
        Schema::dropIfExists('occu_opd_dep_groups');
    }
};
