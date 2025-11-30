<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            // Tambahkan kolom yang belum ada
            if (!Schema::hasColumn('books', 'isbn')) {
                $table->string('isbn', 20)->nullable()->after('author');
            }
            if (!Schema::hasColumn('books', 'description')) {
                $table->text('description')->nullable()->after('isbn');
            }
            if (!Schema::hasColumn('books', 'pages')) {
                $table->integer('pages')->nullable()->after('description');
            }
            if (!Schema::hasColumn('books', 'language')) {
                $table->string('language', 10)->default('id')->after('pages');
            }
            if (!Schema::hasColumn('books', 'cover')) {
                $table->string('cover')->nullable()->after('language');
            }
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'description', 'pages', 'language', 'cover']);
        });
    }
};