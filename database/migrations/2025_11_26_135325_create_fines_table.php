<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->text('reason');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->enum('status', ['unpaid', 'paid', 'waived'])->default('unpaid');
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('fines');
    }
};