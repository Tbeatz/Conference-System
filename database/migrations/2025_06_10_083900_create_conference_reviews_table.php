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
        if (!Schema::hasTable('conference_reviews')) {
            Schema::create('conference_reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('conference_submission_id')->constrained()->onDelete('cascade');
                $table->foreignId('reviewer1_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->foreignId('reviewer2_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->foreignId('reviewer3_id')->nullable()->constrained('users')->onDelete('cascade'); // reviewer user
                $table->enum('evaluation', ['acceptable', 'minor_revisions', 'major_revisions', 'reject']);
                $table->text('reviewer_comments');
                $table->enum('status', ['draft', 'sent'])->default('draft');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conference_reviews');
    }
};
