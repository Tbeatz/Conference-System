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
        Schema::table('conference_submissions', function (Blueprint $table) {
        $table->string('paper_original_name')->nullable()->after('paper_path');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conference_submissions', function (Blueprint $table) {
            //
            $table->dropColumn('paper_original_name');
        });
    }
};
