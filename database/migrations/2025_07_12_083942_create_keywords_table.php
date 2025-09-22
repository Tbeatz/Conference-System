<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('keywords')) {
            Schema::create('keywords', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique(); // Example: 'Machine Learning'
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
