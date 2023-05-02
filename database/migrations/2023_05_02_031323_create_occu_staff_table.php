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
        Schema::create('occu_staff', function (Blueprint $table) {
            $table->id();
            $table->string('occu_staff_name',100);
            $table->string('type_shift',3);
            $table->integer('display_order');
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
        Schema::dropIfExists('occu_staff');
    }
};
