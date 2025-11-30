<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            // Tambahkan kolom ISBN
            if (!Schema::hasColumn('books', 'isbn')) {
                $table->string('isbn', 20)->nullable()->after('author');
            }
            
            // Tambahkan kolom description
            if (!Schema::hasColumn('books', 'description')) {
                $table->text('description')->nullable()->after('isbn');
            }
            
            // Jika perlu published_year (tapi Anda sudah punya 'year')
            if (!Schema::hasColumn('books', 'published_year')) {
                $table->integer('published_year')->nullable()->after('description');
            }
            
            // Tambahkan cover jika belum ada
            if (!Schema::hasColumn('books', 'cover')) {
                $table->string('cover')->nullable()->after('published_year');
            }
            
            // Tambahkan pages jika perlu
            if (!Schema::hasColumn('books', 'pages')) {
                $table->integer('pages')->nullable()->after('cover');
            }
            
            // Tambahkan language jika perlu
            if (!Schema::hasColumn('books', 'language')) {
                $table->string('language', 10)->default('id')->after('pages');
            }
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'isbn', 
                'description', 
                'published_year', 
                'cover', 
                'pages', 
                'language'
            ]);
        });
    }
};