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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('comment', 255);
            // Relació 1
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            // Relació 2
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')
                  ->references('id')->on('posts')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            // Evitar doble comentari en un post
            $table->unique(['author_id', 'post_id']);
            // Dates de creació i actualització
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
