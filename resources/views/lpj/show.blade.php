@extends('layouts.app')

@section('title', 'About - BEM System')

@section('content')
    <div class="max-w-6xl mx-auto">

        <!-- Banner -->
        <div class="bg-gradient-to-r from-purple-900 to-purple-600 rounded-2xl p-10 text-white mb-6 shadow-md">
            <h1 class="text-3xl font-bold mb-4">RAB Himpunan Management System</h1>
            <p class="text-purple-100 max-w-4xl text-sm leading-relaxed">
                Website ini dirancang untuk membantu Himpunan Program Studi dalam menyusun dan mengelola Rencana Anggaran
                Biaya (RAB) secara digital, cepat, dan terstruktur.
            </p>
        </div>

        <!-- Grid Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <!-- Tujuan Website -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                    🎯 Tujuan Website
                </h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Mempermudah proses penyusunan Rencana Anggaran Biaya (RAB) organisasi mahasiswa secara digital. Platform
                    ini menggantikan proses manual dengan sistem yang efisien, terstruktur, dan mudah digunakan oleh seluruh
                    pengurus himpunan.
                </p>
            </div>

            <!-- Fitur Utama -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    Fitur Utama
                </h2>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-purple-100 text-purple-800 text-xs font-semibold py-2 px-3 rounded-lg text-center">Format
                        Proposal</div>
                    <div class="bg-purple-100 text-purple-800 text-xs font-semibold py-2 px-3 rounded-lg text-center">Format
                        LPJ</div>
                    <div class="bg-purple-100 text-purple-800 text-xs font-semibold py-2 px-3 rounded-lg text-center">
                        Manajemen Kegiatan</div>
                    <div class="bg-purple-100 text-purple-800 text-xs font-semibold py-2 px-3 rounded-lg text-center">
                        Perhitungan Total RAB</div>
                    <div class="bg-purple-100 text-purple-800 text-xs font-semibold py-2 px-3 rounded-lg text-center">
                        Dashboard Modern</div>
                    <div class="bg-purple-100 text-purple-800 text-xs font-semibold py-2 px-3 rounded-lg text-center">Multi
                        Himpunan</div>
                </div>
            </div>

            <!-- Teknologi -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                    &lt;/&gt; Teknologi
                </h2>
                <div class="flex flex-wrap gap-2">
                    <span class="border border-purple-200 text-purple-700 text-xs font-medium px-3 py-1.5 rounded-full">PHP
                        Native</span>
                    <span
                        class="border border-purple-200 text-purple-700 text-xs font-medium px-3 py-1.5 rounded-full">MySQL</span>
                    <span
                        class="border border-purple-200 text-purple-700 text-xs font-medium px-3 py-1.5 rounded-full">HTML</span>
                    <span
                        class="border border-purple-200 text-purple-700 text-xs font-medium px-3 py-1.5 rounded-full">CSS</span>
                    <span class="border border-purple-200 text-purple-700 text-xs font-medium px-3 py-1.5 rounded-full">Font
                        Awesome</span>
                </div>
            </div>

            <!-- Pengembang -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-purple-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Pengembang
                </h2>
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                        R
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Rizky Mahendra</h3>
                        <p class="text-xs text-gray-500">Sistem Informasi<br>Universitas Nusantara</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <a href="/dashboard"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-500 hover:bg-purple-600 rounded-lg text-sm font-medium text-white transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Dashboard
        </a>

    </div>
@endsection
