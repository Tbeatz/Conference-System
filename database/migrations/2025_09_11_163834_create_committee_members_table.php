<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteeMembersTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('committee_members')) {
            Schema::create('committee_members', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('title')->nullable();
                // $table->string('position'); // General Chair, Program Chair, Member
                $table->string('role'); // General Chair, Program Chair, Member
                $table->string('affiliation');
                $table->string('country')->default('Myanmar');
                $table->boolean('is_acting')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('committee_members');
    }
}
