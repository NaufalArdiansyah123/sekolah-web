<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2024_01_01_000013_create_settings_table.php
return new class extends Migration
{
    public function up()
    {
        // Only create the table if it doesn't exist to avoid conflicts
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string');
                $table->string('group')->default('general');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
