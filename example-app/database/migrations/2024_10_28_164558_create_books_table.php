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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('title');
            $table->unsignedBigInteger('author_id');
            $table->string('year_of_publication');
            $table->unsignedBigInteger('gener_id');
            $table->string('language');
            $table->string('content_file');
//            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('gener_id')->references('id')->on('geners');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
