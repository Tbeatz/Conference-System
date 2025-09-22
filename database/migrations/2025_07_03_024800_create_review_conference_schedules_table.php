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
        if (!Schema::hasTable('review_conference_schedules')) {
            Schema::create('review_conference_schedules', function (Blueprint $table) {
                $table->id();

                // FK to journal_submissions
                $table->unsignedBigInteger('conference_submission_id');
                $table->foreign('conference_submission_id')->references('id')->on('conference_submissions')->onDelete('cascade');

                // 3 reviewers
                $table->unsignedBigInteger('reviewer1_id')->nullable();
                $table->unsignedBigInteger('reviewer2_id')->nullable();
                $table->unsignedBigInteger('reviewer3_id')->nullable();

                $table->foreign('reviewer1_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('reviewer2_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('reviewer3_id')->references('id')->on('users')->onDelete('set null');

                $table->date('start_date')->nullable(); // Review start date
                $table->date('end_date')->nullable();   // Review end date
                $table->string('status')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_schedules');
    }
};
