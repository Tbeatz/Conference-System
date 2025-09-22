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
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->text('description')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->string('location')->nullable(); // null for journal
                $table->string('publication_partner')->nullable();
                $table->date('submission_deadline')->nullable();
                $table->date('acceptance_date')->nullable();
                $table->date('camera_ready_deadline')->nullable();
                $table->string('event_website')->nullable();
                $table->string('organizer')->nullable();
                $table->string('contact_email')->nullable();
                $table->enum('status', ['upcoming', 'open', 'closed', 'published'])->default('upcoming');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
