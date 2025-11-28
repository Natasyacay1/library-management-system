<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#3B82F6'); // hex color
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel pivot untuk relasi many-to-many books-categories
        Schema::create('book_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['book_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('categories');
    }
};