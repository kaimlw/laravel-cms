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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('web_id')->constrained('webs');
            $table->integer('author');
            $table->string('title')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->longText('content')->nullable();
            $table->string('excerpt')->nullable();
            $table->enum('type', ['post','page']);
            $table->enum('status', ['draft', 'publish']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
