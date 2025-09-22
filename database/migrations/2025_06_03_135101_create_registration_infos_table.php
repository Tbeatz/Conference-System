<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationInfosTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('registration_infos')) {
            Schema::create('registration_infos', function (Blueprint $table) {
                $table->id();
                $table->string('label');
                $table->string('value');
                $table->enum('type', ['fee', 'email', 'qr_image']); // added qr_image // 'fee', 'email', etc.
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('registration_infos');
    }
}
