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
        if (!Schema::hasTable('journal_submissions')) {
            Schema::create('journal_submissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('event_id')->nullable();
                $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('topic_id')->constrained()->onDelete('cascade');
                $table->foreignId('category_id')->constrained()->onDelete('cascade');

                $table->text('abstract');
                $table->text('keywords'); // stored as comma-separated string
                $table->string('paper_path')->nullable();
                $table->string('department_rule_path')->nullable();
                $table->string('professor_rule_path')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->unsignedTinyInteger('edit_count')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_submissions');
    }
};
