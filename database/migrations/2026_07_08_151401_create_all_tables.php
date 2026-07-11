<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pengguna
        Schema::create('Pengguna', function (Blueprint $table) {
            $table->id('ID_Pengguna');
            $table->string('Username', 255);
            $table->string('Email', 255)->nullable()->unique();
            $table->string('Password', 255);
            $table->enum('Role', ['Superadmin', 'Admin', 'User'])->default('User');
            $table->date('is_active')->nullable();
            $table->dateTime('Last_login')->nullable();
            $table->string('remember_token', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Pengguna');
    }
};
