@extends('layouts.app')

@section('title', 'Detail RAB Proposal - BEM System')

@section('content')
    <div class="max-w-6xl mx-auto relative">
        
        <!-- Top Actions & Title -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-purple-900 mb-1">RAB: {{ $kegiatan->Nama_Kegiatan }}</h1>
                <p class="text-gray-500 text-sm">Rencana Anggaran Biaya — Format Proposal</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button
                    class="bg-purple-800 hover:bg-purple-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    Cetak PDF
                </button>
                <!-- Tombol ini akan membuka Modal -->
                <button onclick="toggleModal()"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Item
                </button>
                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export Excel
                </button>
            </div>
        </div>

        <!-- Table Content -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-purple-800 text-white text-sm">
                            <th class="px-6 py-4 font-semibold w-16">No</th>
                            <th class="px-6 py-4 font-semibold">Jenis Pengeluaran</th>
                            <th class="px-6 py-4 font-semibold">Keterangan</th>
                            <th class="px-6 py-4 font-semibold">Volume</th>
                            <th class="px-6 py-4 font-semibold">Satuan</th>
                            <th class="px-6 py-4 font-semibold">Harga/Unit (@)</th>
                            <th class="px-6 py-4 font-semibold">Total</th>
                            <th class="px-6 py-4 font-semibold text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4 font-medium text-gray-900">Konsumsi</td>
                            <td class="px-6 py-4">Nasi Panitia</td>
                            <td class="px-6 py-4">20</td>
                            <td class="px-6 py-4">Kotak</td>
                            <td class="px-6 py-4">Rp 15.000</td>
                            <td class="px-6 py-4 font-semibold">Rp 300.000</td>
                            <td class="px-6 py-4 flex justify-center gap-2">
                                <button
                                    class="w-8 h-8 rounded-full bg-purple-500 hover:bg-purple-600 text-white flex items-center justify-center transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                        </path>
                                    </svg>
                                </button>
                                <button
                                    class="w-8 h-8 rounded-full bg-red-800 hover:bg-red-900 text-white flex items-center justify-center transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <!-- Footer Total -->
                    <tfoot>
                        <tr class="bg-purple-700 text-white text-sm font-bold uppercase tracking-wider">
                            <td colspan="6" class="px-6 py-4">TOTAL KESELURUHAN</td>
                            <td colspan="2" class="px-6 py-4">Rp 300.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Back Button -->
        <a href="/proposal"
            class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Proposal
        </a>

        <!-- Overlay Background & Modal (Hidden by default) -->
        <div id="itemModal"
            class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden animate-fade-in-up">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-purple-900 mb-1">Tambah Item Proposal</h2>
                    <p class="text-sm text-purple-600 mb-6">Kegiatan: <span class="font-bold">SIGMA BEM</span></p>

                    <form action="#" method="POST">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Jenis Pengeluaran</label>
                            <select
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 text-gray-600">
                                <option value="">Pilih jenis pengeluaran</option>
                                <option value="Konsumsi">Konsumsi</option>
                                <option value="Perlengkapan">Perlengkapan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Keterangan</label>
                            <input type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                placeholder="Contoh: Nasi Panitia">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Volume</label>
                                <input type="number"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                    placeholder="Contoh: 20">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Satuan</label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                    placeholder="Contoh: Kotak">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Harga/Unit (@)</label>
                            <input type="number"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                placeholder="Contoh: 15000">
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="submit"
                                class="flex-1 bg-purple-700 hover:bg-purple-800 text-white font-bold py-2.5 px-4 rounded-lg transition flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                    </path>
                                </svg>
                                Simpan
                            </button>
                            <button type="button" onclick="toggleModal()"
                                class="flex-1 bg-red-800 hover:bg-red-900 text-white font-bold py-2.5 px-4 rounded-lg transition flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Simple untuk memunculkan Modal -->
    <script>
        function toggleModal() {
            const modal = document.getElementById('itemModal');
            modal.classList.toggle('hidden');
        }
    </script>
@endsection
