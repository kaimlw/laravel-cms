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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('web_id')->constrained('webs');
            $table->string('name');
            $table->string('target');
            $table->foreignId('parent_id')->nullable()->constrained('menus');
            $table->enum('type', ['custom', 'page', 'post', 'category']);
            $table->integer('menu_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
