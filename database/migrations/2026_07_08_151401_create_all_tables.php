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
            $table->increments('ID_Pengguna');
            $table->string('Username', 255);
            $table->string('Email', 255)->nullable()->unique();
            $table->string('Password', 255);
            $table->enum('Role', ['Superadmin', 'Admin', 'User'])->default('User');
            $table->date('is_active')->nullable();
            $table->dateTime('Last_login')->nullable();
            $table->string('remember_token', 100)->nullable();
        });

        // 2. Jenis_Pengeluaran
        Schema::create('Jenis_Pengeluaran', function (Blueprint $table) {
            $table->increments('ID_Jenis_Pengeluaran');
            $table->string('Deskripsi_Pengeluaran', 255);
            $table->string('Keterangan', 255)->nullable();
        });

        // 3. Kegiatan
        Schema::create('Kegiatan', function (Blueprint $table) {
            $table->increments('ID_Kegiatan');
            $table->string('Nama_Kegiatan', 255);
            $table->unsignedInteger('ID_Pengguna')->nullable();
            $table->date('Tanggal_Pelaksanaan')->nullable();
            $table->enum('Jenis_RAB', ['Tipe_A', 'Tipe_B'])->nullable();
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('Pengguna')->onDelete('set null');
        });

        // 4. Proposal_RAB
        Schema::create('Proposal_RAB', function (Blueprint $table) {
            $table->increments('ID_Proposal_RAB');
            $table->unsignedInteger('ID_Kegiatan')->nullable();
            $table->unsignedInteger('ID_Pengguna')->nullable();
            $table->date('Tanggal_Dibuat')->nullable();
            $table->enum('Status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->foreign('ID_Kegiatan')->references('ID_Kegiatan')->on('Kegiatan')->onDelete('cascade');
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('Pengguna')->onDelete('set null');
        });

        // 5. Item_RAB
        Schema::create('Item_RAB', function (Blueprint $table) {
            $table->increments('ID_Item_RAB');
            $table->string('Deskripsi_Item', 255);
            $table->integer('Qty');
            $table->string('Satuan', 50);
            $table->decimal('Harga_Unit', 15, 2);
            $table->decimal('Total_Item', 15, 2)->storedAs('Qty * Harga_Unit');
            $table->unsignedInteger('ID_Jenis_Pengeluaran')->nullable();
            $table->foreign('ID_Jenis_Pengeluaran')->references('ID_Jenis_Pengeluaran')->on('Jenis_Pengeluaran')->onDelete('set null');
        });

        // 6. Daftar_Item_Proposal
        Schema::create('Daftar_Item_Proposal', function (Blueprint $table) {
            $table->unsignedInteger('ID_Proposal_RAB');
            $table->unsignedInteger('ID_Item_RAB');
            $table->primary(['ID_Proposal_RAB', 'ID_Item_RAB']);
            $table->foreign('ID_Proposal_RAB')->references('ID_Proposal_RAB')->on('Proposal_RAB')->onDelete('cascade');
            $table->foreign('ID_Item_RAB')->references('ID_Item_RAB')->on('Item_RAB')->onDelete('cascade');
        });

        // 7. LPJ_RAB
        Schema::create('LPJ_RAB', function (Blueprint $table) {
            $table->increments('ID_LPJ_RAB');
            $table->unsignedInteger('ID_Kegiatan')->nullable();
            $table->unsignedInteger('ID_Pengguna')->nullable();
            $table->decimal('Total_Pengeluaran_LPJ', 15, 2)->default(0.00);
            $table->decimal('Total_Kwitansi_LPJ', 15, 2)->default(0.00);
            $table->foreign('ID_Kegiatan')->references('ID_Kegiatan')->on('Kegiatan')->onDelete('cascade');
            $table->foreign('ID_Pengguna')->references('ID_Pengguna')->on('Pengguna')->onDelete('set null');
        });

        // 8. Daftar_Item_LPJ
        Schema::create('Daftar_Item_LPJ', function (Blueprint $table) {
            $table->unsignedInteger('ID_LPJ_RAB');
            $table->unsignedInteger('ID_Item_RAB');
            $table->date('Tanggal_Pengeluaran')->nullable();
            $table->decimal('Harga_Unit_Realisasi', 15, 2);
            $table->integer('Qty_Realisasi');
            $table->decimal('Total_Realisasi', 15, 2)->storedAs('Qty_Realisasi * Harga_Unit_Realisasi');
            $table->decimal('Total_Kwitansi', 15, 2);
            $table->primary(['ID_LPJ_RAB', 'ID_Item_RAB']);
            $table->foreign('ID_LPJ_RAB')->references('ID_LPJ_RAB')->on('LPJ_RAB')->onDelete('cascade');
            $table->foreign('ID_Item_RAB')->references('ID_Item_RAB')->on('Item_RAB')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Daftar_Item_LPJ');
        Schema::dropIfExists('LPJ_RAB');
        Schema::dropIfExists('Daftar_Item_Proposal');
        Schema::dropIfExists('Item_RAB');
        Schema::dropIfExists('Proposal_RAB');
        Schema::dropIfExists('Kegiatan');
        Schema::dropIfExists('Jenis_Pengeluaran');
        Schema::dropIfExists('Pengguna');
    }
};
