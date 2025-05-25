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
        Schema::create('menu_defaults', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('target');
            $table->foreignId('parent_id')->nullable()->constrained('menu_defaults');
            $table->enum('type', ['custom', 'page', 'post', 'category']);
            $table->enum('menu_placement', ['main', 'top']);
            $table->integer('menu_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_defaults');
    }
};
