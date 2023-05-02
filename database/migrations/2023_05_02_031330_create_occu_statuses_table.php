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
        Schema::create('occu_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('occu_status_name',100);
            $table->integer('updated_by');
            $table->integer('created_by');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occu_statuses');
    }
};