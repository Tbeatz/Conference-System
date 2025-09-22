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
        if (!Schema::hasTable('journals')) {
            Schema::create('journals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');

                $table->foreignId('topic_id')->constrained()->onDelete('cascade');
                $table->text('description')->nullable();
                $table->string('paper_path')->nullable();
                $table->date('start_date')->nullable();      // optional: journal active start
                $table->date('end_date')->nullable();        // optional: journal active end
                $table->date('publication_date')->nullable();

                $table->string('journal_website')->nullable();
                $table->unsignedBigInteger('reviewer_id')->nullable();
                $table->unsignedBigInteger('author_id')->nullable();

                // Foreign key constraints
                $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
                $table->string('contact_email')->nullable();

                $table->enum('status', ['open', 'reviewing', 'accepted', 'published', 'closed'])->default('open');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
