@extends('layouts.app')

@section('title', 'Detail LPJ - BEM System')

@section('content')
    <div class="max-w-6xl mx-auto relative">
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r shadow-sm animate-fade-in-up">
                <div class="flex items-center mb-1">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <h3 class="text-red-800 font-bold text-sm">Gagal Menyimpan Bon</h3>
                </div>
                <ul class="list-disc list-inside text-red-600 text-xs ml-7 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm font-semibold shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Top Actions & Title -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-purple-900 mb-1">LPJ: {{ $kegiatan->Nama_Kegiatan }}</h1>
                <p class="text-gray-500 text-sm">Laporan Penanggung Jawaban — Format LPJ</p>
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
                <button onclick="toggleModalBon()"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Bon
                </button>
                <!-- Tombol ini akan membuka Modal -->
                {{-- <button onclick="toggleModal()"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Item
                </button> --}}
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
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @forelse ($sie as $index => $s)
                            <tr class="bg-purple-200 border-b border-purple-300">
                                <td colspan="8" class="px-6 py-3">
                                    <div class="flex items-center justify-between w-full">
                                        <span class="text-purple-900 font-bold text-sm uppercase tracking-wider">
                                            {{ $s->Nama_Sie }}
                                        </span>
                                    </div>
                                </td>
                            </tr>

                            @php
                                $no = 1;
                                // Kelompokkan item berdasarkan ID_Bon
                                $itemsWithBon = $s->item_lpj->groupBy('ID_Bon');

                                $itemsWithoutBon = $s->items->whereNull('ID_Bon');
                                $hasItems = $s->items->count() > 0;
                                $subtotalSie = 0; // Variabel untuk menghitung total aktual (RAB + LPJ)
                            @endphp

                            @if ($hasItems)
                                {{-- BAGIAN A: SUDAH ADA BON (TAMPILKAN DATA DARI TABEL ITEM_LPJ) --}}
                                @foreach ($itemsWithBon as $bonId => $groupedItems)
                                $totalBon = $groupedItems->sum('Total');
                                    @foreach ($groupedItems as $itemIndex => $item)
                                        @php
                                            // Prioritaskan data LPJ, jika tidak ada fallback ke data Item RAB
                                            $qtyTampil = $item->Qty_Realisasi;
                                            $satuanTampil = $item->Satuan_Realisasi;
                                            $hargaTampil = $item->Harga_Realisasi;
                                            $totalTampil = $qtyTampil * $hargaTampil;
                                            $totalBon = $groupedItems->sum('Total_Realisasi');
                                            $subtotalSie += $totalTampil; 
                                        @endphp

                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition bg-green-50/20">
                                            <td class="px-6 py-4">{{ $no++ }}</td>
                                            <td class="px-6 py-4 font-medium text-gray-900">
                                                {{ $item->Jenis_Pengeluaran }}
                                                @if ($item->created_at == $item->updated_at && $item->isNew)
                                                    <span
                                                        class="ml-1 px-1.5 py-0.5 bg-amber-100 text-amber-700 text-[10px] rounded-full">Baru</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">{{ $item->Keterangan }}</td>
                                            <td class="px-6 py-4 font-semibold text-blue-700">{{ $qtyTampil }}</td>
                                            <td class="px-6 py-4">{{ $satuanTampil }}</td>
                                            <td class="px-6 py-4 font-semibold text-blue-700">Rp
                                                {{ number_format($hargaTampil, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 font-bold text-green-700">Rp
                                                {{ number_format($totalTampil, 0, ',', '.') }}</td>

                                            {{-- Logika Rowspan Aksi: Tombol "Lihat Bukti" --}}
                                            @if ($loop->first)
                                                @php
                                                    // Mengambil data nama & foto bon dari relasi
                                                    $fotoBon = $item->bon ? $item->bon->Foto_Bon : '';
                                                    $urlFoto = $fotoBon ? asset('uploads/bon/' . $fotoBon) : '';
                                                    $namaBon = $item->bon ? $item->bon->Nama_Bon : 'Kwitansi';
                                                @endphp
                                                <td class="px-6 py-4 text-center align-middle border-l border-gray-100"
                                                    rowspan="{{ count($groupedItems) }}">
                                                    <button type="button"
                                                        onclick="viewKwitansi('{{ $urlFoto }}', '{{ $namaBon }}')"
                                                        class="inline-flex flex-col items-center justify-center gap-1 text-purple-600 hover:text-purple-800 transition bg-purple-50 hover:bg-purple-100 px-3 py-2 rounded-lg">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                        <span class="text-xs font-semibold">Lihat Bukti</span>
                                                        Total : Rp {{ number_format($totalBon, 0, ',', '.') }}
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach

                                {{-- BAGIAN B: BELUM ADA BON (TAMPILKAN ITEM RAB ASLI) --}}
                                @foreach ($itemsWithoutBon as $item)
                                    @php $subtotalSie += $item->Total; @endphp
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">{{ $no++ }}</td>
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->Jenis_Pengeluaran }}</td>
                                        <td class="px-6 py-4">{{ $item->Keterangan }}</td>
                                        <td class="px-6 py-4">{{ $item->Qty }}</td>
                                        <td class="px-6 py-4">{{ $item->Satuan }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($item->Harga_Unit, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-600">Rp
                                            {{ number_format($item->Total, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-center border-l border-gray-100">
                                            <button title="Isi Bukti Bon"
                                                onclick="bukaBonSpesifikSie('{{ $s->ID_Sie }}')"
                                                class="px-4 py-1.5 rounded-full bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium transition shadow-sm">
                                                Isi Bukti
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="border-b border-gray-100 bg-gray-50/50">
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-400 italic">
                                        Belum ada item anggaran untuk Sie ini.
                                    </td>
                                </tr>
                            @endif

                            <tr class="bg-violet-300 border-b border-purple-300">
                                <td colspan="8" class="px-6 py-3">
                                    <div class="flex items-center justify-end w-full">
                                        <span class="text-purple-900 font-bold text-sm uppercase tracking-wider">
                                            Total {{ $s->Nama_Sie }}
                                        </span>
                                        <span class="ml-3 text-purple-900 font-bold text-sm uppercase tracking-wider mr-6">
                                            Rp {{ number_format($subtotalSie, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada Sie yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <tfoot>
                        <tr class="bg-purple-700 text-white text-sm font-bold uppercase tracking-wider">
                            <td colspan="6" class="px-6 py-4 text-right">TOTAL KESELURUHAN</td>
                            <td colspan="2" class="px-6 py-4">
                                {{ number_format($kegiatan->items->sum('Total'), 0, ',', '.') }}</td>
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
                    <p class="text-sm text-purple-600 mb-6">Kegiatan: <span
                            class="font-bold">{{ $kegiatan->Nama_Kegiatan }}</span></p>

                    <form action="{{ route('Item.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_sie" id="id_sie" value="">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Jenis Pengeluaran</label>
                            <select name="Jenis_Pengeluaran"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 text-gray-600">
                                <option value="">Pilih jenis pengeluaran</option>
                                <option value="Konsumsi">Konsumsi</option>
                                <option value="Perlengkapan">Perlengkapan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Keterangan</label>
                            <input type="text" name="Keterangan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                placeholder="Contoh: Nasi Panitia">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Volume/Jumlah</label>
                                <input type="number" name="Qty"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                    placeholder="Contoh: 20">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Satuan</label>
                                <input type="text" name="Satuan"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                    placeholder="Contoh: Kotak">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Harga/Unit (@)</label>
                            <input type="number" name="Harga_Unit"
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

        {{-- Modal Edit Item --}}
        <div id="editItemModal"
            class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden animate-fade-in-up">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-purple-900 mb-1">Edit Item Proposal</h2>
                    <p class="text-sm text-purple-600 mb-6">Kegiatan: <span
                            class="font-bold">{{ $kegiatan->Nama_Kegiatan }}</span></p>

                    <form id="editItemForm" action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_item" id="editItemId" value="">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Jenis Pengeluaran</label>
                            <select name="Jenis_Pengeluaran"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 text-gray-600">
                                <option value="">Pilih jenis pengeluaran</option>
                                <option value="Konsumsi">Konsumsi</option>
                                <option value="Perlengkapan">Perlengkapan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Keterangan</label>
                            <input type="text" name="Keterangan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                placeholder="Contoh: Nasi Panitia">
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Volume/Jumlah</label>
                                <input type="number" name="Qty"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                    placeholder="Contoh: 20">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Satuan</label>
                                <input type="text" name="Satuan"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600"
                                    placeholder="Contoh: Kotak">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Harga/Unit (@)</label>
                            <input type="number" name="Harga_Unit"
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

        {{-- Modal Bon --}}
        <div id="bonModal"
            class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div
                class="bg-white rounded-2xl w-full max-w-5xl shadow-xl overflow-hidden animate-fade-in-up max-h-[90vh] flex flex-col">

                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-purple-900 text-white">
                    <div>
                        <h2 class="text-xl font-bold">Buat Bon & Realisasi Dana</h2>
                        <p class="text-xs text-purple-200">Upload bukti kwitansi dan isi dana realisasi dari item yang
                            terpilih</p>
                    </div>
                    <button type="button" onclick="toggleModalBon()"
                        class="text-purple-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form action="{{ route('Bon.store') }}" method="POST" enctype="multipart/form-data"
                    class="flex flex-col flex-1 overflow-hidden">
                    @csrf

                    <div class="p-6 overflow-y-auto grid grid-cols-1 md:grid-cols-12 gap-6 flex-1 bg-gray-50">
                        <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->ID_Kegiatan }}">
                        <div
                            class="md:col-span-5 bg-white p-5 rounded-xl border border-gray-200 shadow-sm space-y-4 h-fit">
                            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider border-b pb-2">Data Bukti
                                Pembayaran</h3>

                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Bon</label>
                                <input type="text" name="nama_bon" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 text-sm"
                                    placeholder="Contoh: Nota Konsumsi Sie Acara">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Pemilik Bon</label>
                                <select name="sie_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-600 text-sm">
                                    <option value="">Pilih Sie</option>
                                    @foreach ($sie as $s)
                                        <option value="{{ $s->ID_Sie }}">{{ $s->Nama_Sie }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2">Bukti Pembayaran /
                                    Kuitansi</label>
                                <div class="flex items-center justify-center w-full">
                                    <label id="upload-label"
                                        class="relative flex flex-col items-center justify-center w-full h-44 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition overflow-hidden">

                                        <div id="upload-text"
                                            class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-2">
                                            <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                </path>
                                            </svg>
                                            <p class="text-xs text-gray-500 font-semibold">Klik untuk upload bukti gambar
                                            </p>
                                            <p class="text-[10px] text-gray-400 mt-1">PNG, JPG, JPEG (Max. 2MB)</p>
                                        </div>

                                        <div id="preview-container"
                                            class="hidden absolute inset-0 w-full h-full bg-white flex items-center justify-center">
                                            <img id="image-preview" src="#" alt="Preview Kuitansi"
                                                class="w-full h-full object-contain">
                                            <div
                                                class="absolute bottom-2 right-2 bg-purple-900/80 text-white text-[10px] px-2 py-1 rounded backdrop-blur-sm pointer-events-none">
                                                Klik untuk Mengganti Gambar
                                            </div>
                                        </div>

                                        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" required
                                            class="hidden" accept="image/*" onchange="previewImage(this)" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div
                            class="md:col-span-7 bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col max-h-[60vh] md:max-h-full">
                            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider border-b pb-2 mb-3">Pilih
                                Item Anggaran</h3>

                            <div class="space-y-3 overflow-y-auto flex-1 pr-1">
                                @foreach ($sie as $s)
                                    <div class="sie-group" data-sie-id="{{ $s->ID_Sie }}">
                                        <div class="text-xs font-bold text-purple-800 bg-purple-50 px-2 py-1 rounded mb-2">
                                            {{ $s->Nama_Sie }}
                                        </div>

                                        {{-- Tampilkan item yang belum memiliki klaim Bon --}}
                                        @foreach ($s->items->whereNull('ID_Bon') as $item)
                                            <div
                                                class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition space-y-3">
                                                <div class="flex items-start justify-between gap-3">
                                                    <div class="flex items-start gap-3">
                                                        <input type="checkbox" name="item_ids[]"
                                                            value="{{ $item->ID_Item }}"
                                                            class="item-checkbox mt-1 w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                                                            data-qty="{{ $item->Qty }}"
                                                            data-satuan="{{ $item->Satuan }}"
                                                            data-harga="{{ $item->Harga_Unit }}"
                                                            onchange="handleItemCheckbox(this)">
                                                        <div>
                                                            <p class="text-sm font-semibold text-gray-800">
                                                                {{ $item->Keterangan }}</p>
                                                            <p class="text-xs text-gray-500">Anggaran: {{ $item->Qty }}
                                                                {{ $item->Satuan }} @ Rp
                                                                {{ number_format($item->Harga_Unit, 0, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="text-xs font-bold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">
                                                        Rp {{ number_format($item->Total, 0, ',', '.') }}
                                                    </span>
                                                </div>

                                                <div
                                                    class="realisasi-container hidden border-t pt-3 grid grid-cols-3 gap-3 bg-purple-50/50 p-2 rounded-md">
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-gray-600 mb-1">Qty
                                                            Realisasi</label>
                                                        <input type="number" name="realisasi_qty[{{ $item->ID_Item }}]"
                                                            disabled
                                                            class="realisasi-qty w-full px-2 py-1 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-purple-600">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="block text-[11px] font-bold text-gray-600 mb-1">Satuan
                                                            Realisasi</label>
                                                        <input type="text"
                                                            name="realisasi_satuan[{{ $item->ID_Item }}]" disabled
                                                            class="realisasi-satuan w-full px-2 py-1 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-purple-600">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] font-bold text-gray-600 mb-1">Harga
                                                            Unit (Rp)</label>
                                                        <input type="number"
                                                            name="realisasi_harga[{{ $item->ID_Item }}]" disabled
                                                            class="realisasi-harga w-full px-2 py-1 border border-gray-300 rounded text-xs focus:outline-none focus:ring-1 focus:ring-purple-600">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                <div class="mt-6 pt-4 border-t-2 border-dashed border-gray-250">
                                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                                        <div
                                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4">
                                            <div>
                                                <h4 class="text-xs font-bold text-amber-800 uppercase tracking-wider">
                                                    Belanja di Luar Anggaran (Item Baru)
                                                </h4>
                                                <p class="text-[11px] text-amber-600">Gunakan jika ada pembelian item yang
                                                    tidak terdaftar di proposal</p>
                                            </div>
                                            <div class="w-full sm:w-32">
                                                <input type="number" id="jumlah_item_baru" min="1"
                                                    max="10"
                                                    class="w-full px-2 py-1.5 border border-amber-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white"
                                                    placeholder="Jumlah item...">
                                            </div>
                                        </div>

                                        <div id="container_item_baru" class="space-y-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-100 flex gap-3 bg-gray-50 justify-end">
                        <button type="button" onclick="toggleModalBon()"
                            class="px-5 py-2 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 font-semibold text-sm transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 rounded-lg bg-purple-700 hover:bg-purple-800 text-white font-bold text-sm transition flex items-center gap-2">
                            Simpan & Ambil Realisasi
                        </button>
                    </div>
                </form>
            </div>

            {{-- Modal Lihat Bukti --}}
            <div id="lihatBuktiModal"
                class="hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm z-[60] flex items-center justify-center p-4">
                <div
                    class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full flex flex-col overflow-hidden animate-fade-in-up">

                    <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                        <h3 class="font-bold text-gray-800 text-lg" id="lihatBuktiTitle">Bukti Kwitansi</h3>
                        <button onclick="closeLihatBukti()" class="text-gray-500 hover:text-red-500 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 overflow-auto flex justify-center items-center bg-gray-200 min-h-[50vh]">
                        <img id="lihatBuktiImage" src="" alt="Bukti Kwitansi"
                            class="max-w-full max-h-[70vh] object-contain rounded shadow">
                    </div>

                </div>
            </div>

        </div>



        <!-- Script Simple untuk memunculkan Modal -->
        <script>
            function toggleModalBon() {
                const modal = document.getElementById('bonModal');
                modal.classList.toggle('hidden');

                if (modal.classList.contains('hidden')) {
                    const form = document.querySelector('#bonModal form');

                    // 1. Reset seluruh isi form (termasuk checkbox dan dropdown)
                    form.reset();

                    // 2. Sembunyikan dan kunci kembali seluruh field realisasi
                    document.querySelectorAll('.realisasi-container').forEach(container => {
                        container.classList.add('hidden');
                    });
                    document.querySelectorAll('.realisasi-qty, .realisasi-satuan, .realisasi-harga').forEach(input => {
                        input.disabled = true;
                    });

                    // 3. Reset Item Baru
                    document.getElementById('container_item_baru').innerHTML = '';

                    // 4. Reset Preview Gambar & Input File
                    document.getElementById('image-preview').src = '#';
                    document.getElementById('upload-text').classList.remove('hidden');
                    document.getElementById('preview-container').classList.add('hidden');

                    // 5. Tampilkan ulang semua grup sie (reset filter)
                    document.querySelectorAll('.sie-group').forEach(group => {
                        group.style.display = 'block';
                    });
                }
            }

            function previewImage(input) {
                const uploadText = document.getElementById('upload-text');
                const previewContainer = document.getElementById('preview-container');
                const imagePreview = document.getElementById('image-preview');

                // Jika ada file yang dipilih
                if (input.files && input.files[0]) {
                    const file = input.files[0];

                    // Validasi opsional: pastikan file adalah gambar
                    if (!file.type.startsWith('image/')) {
                        alert('File yang diunggah harus berupa gambar!');
                        input.value = ''; // Reset input
                        return;
                    }

                    const reader = new FileReader();

                    // Ketika file selesai dibaca oleh FileReader
                    reader.onload = function(e) {
                        // Set source gambar ke data URL hasil bacaan file
                        imagePreview.src = e.target.result;

                        // Sembunyikan teks petunjuk upload, tampilkan kontainer preview
                        uploadText.classList.add('hidden');
                        previewContainer.classList.remove('hidden');
                    }

                    // Baca file sebagai Data URL
                    reader.readAsDataURL(file);
                }
            }

            // Filter Item berdasarkan Sie yang dipilih
            document.querySelector('select[name="sie_id"]').addEventListener('change', function() {
                const selectedSieId = this.value;
                const sieGroups = document.querySelectorAll('.sie-group');

                sieGroups.forEach(group => {
                    // Tampilkan semua jika dropdown kosong, atau tampilkan yang ID-nya cocok
                    if (selectedSieId === '' || group.getAttribute('data-sie-id') === selectedSieId) {
                        group.style.display = 'block';
                    } else {
                        group.style.display = 'none';
                    }
                });
            });

            function handleItemCheckbox(checkbox) {
                const parentContainer = checkbox.closest('.border');
                const realisasiContainer = parentContainer.querySelector('.realisasi-container');

                // Ambil ketiga elemen input
                const qtyInput = parentContainer.querySelector('.realisasi-qty');
                const satuanInput = parentContainer.querySelector('.realisasi-satuan');
                const hargaInput = parentContainer.querySelector('.realisasi-harga');

                if (checkbox.checked) {
                    realisasiContainer.classList.remove('hidden');

                    // Aktifkan form agar nilainya dikirim
                    qtyInput.disabled = false;
                    satuanInput.disabled = false;
                    hargaInput.disabled = false;

                    // Beri nilai otomatis
                    qtyInput.value = checkbox.getAttribute('data-qty');
                    satuanInput.value = checkbox.getAttribute('data-satuan');
                    hargaInput.value = checkbox.getAttribute('data-harga');
                } else {
                    realisasiContainer.classList.add('hidden');

                    // Kunci kembali form dan kosongkan datanya
                    qtyInput.disabled = true;
                    satuanInput.disabled = true;
                    hargaInput.disabled = true;

                    qtyInput.value = '';
                    satuanInput.value = '';
                    hargaInput.value = '';
                }
            }

            document.getElementById('jumlah_item_baru').addEventListener('input', function() {
                const container = document.getElementById('container_item_baru');
                let count = parseInt(this.value);

                // Bersihkan isi kontainer sebelumnya
                container.innerHTML = '';

                if (isNaN(count) || count < 1) return;
                if (count > 10) count = 10; // Batasi maksimal 10 item baru per bon demi performa

                for (let i = 1; i <= count; i++) {
                    const itemBaruHtml = `
            <div class="bg-white p-3 rounded-lg border border-amber-200 shadow-sm space-y-2 animate-fade-in-up">
                <div class="text-[11px] font-bold text-amber-700 border-b pb-1 mb-2">Item Baru #${i}</div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Jenis Pengeluaran</label>
                        <select name="baru_jenis[]" required class="w-full px-2 py-1 border border-gray-300 rounded text-xs bg-gray-50">
                            <option value="Konsumsi">Konsumsi</option>
                            <option value="Perlengkapan">Perlengkapan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Nama/Keterangan Barang</label>
                        <input type="text" name="baru_keterangan[]" required placeholder="Misal: Lakban Hitam"
                            class="w-full px-2 py-1 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Qty</label>
                        <input type="number" name="baru_qty[]" required placeholder="0"
                            class="w-full px-2 py-1 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Satuan</label>
                        <input type="text" name="baru_satuan[]" required placeholder="Pcs/Roll"
                            class="w-full px-2 py-1 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold text-gray-600 mb-0.5">Harga Satuan (Rp)</label>
                        <input type="number" name="baru_harga[]" required placeholder="0"
                            class="w-full px-2 py-1 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-amber-500">
                    </div>
                </div>
            </div>
        `;
                    container.insertAdjacentHTML('beforeend', itemBaruHtml);
                }
            });

            function toggleModal(buttonElement = null) {
                const modal = document.getElementById('itemModal');
                modal.classList.toggle('hidden');

                if (buttonElement) {
                    const sieId = buttonElement.getAttribute('data-sie-id');
                    modal.querySelector('#id_sie').value = sieId;
                }
            }

            function editItem(buttonElement) {
                const modal = document.getElementById('editItemModal');
                modal.classList.remove('hidden');

                // Ambil data dari atribut data-* dari tombol yang diklik
                const itemId = buttonElement.getAttribute('data-item-id');
                const jenisPengeluaran = buttonElement.getAttribute('data-item-jenis');
                const keterangan = buttonElement.getAttribute('data-item-keterangan');
                const qty = buttonElement.getAttribute('data-item-qty');
                const satuan = buttonElement.getAttribute('data-item-satuan');
                const hargaUnit = buttonElement.getAttribute('data-item-harga');

                // Masukkan data ke dalam form
                document.getElementById('editItemId').value = itemId;
                document.querySelector('#editItemForm select[name="Jenis_Pengeluaran"]').value = jenisPengeluaran;
                document.querySelector('#editItemForm input[name="Keterangan"]').value = keterangan;
                document.querySelector('#editItemForm input[name="Qty"]').value = qty;
                document.querySelector('#editItemForm input[name="Satuan"]').value = satuan;
                document.querySelector('#editItemForm input[name="Harga_Unit"]').value = hargaUnit;

                // Arahkan action form ke rute update. 
                // CATATAN: Pastikan URL ini sesuai dengan route web.php kamu! 
                // Contoh jika routenya menggunakan resource: /item/{id}
                const form = document.getElementById('editItemForm');
                form.action = `/proposal/edit-item/${itemId}`;
            }

            // Membuka form Bon dengan filter otomatis berdasarkan Sie yang diklik
            function bukaBonSpesifikSie(sieId) {
                toggleModalBon(); // Buka modalnya

                // Set dropdown Sie dan trigger event change untuk memfilter list di sebelah kanan
                const selectSie = document.querySelector('#bonModal select[name="sie_id"]');
                if (selectSie) {
                    selectSie.value = sieId;
                    selectSie.dispatchEvent(new Event('change'));
                }
            }

            // Menampilkan gambar bon saat text "Lihat Bukti" ditekan
            function viewKwitansi(imageUrl, bonTitle) {
                if (!imageUrl || imageUrl.trim() === '') {
                    alert('Foto bukti kuitansi belum diunggah atau gagal dimuat.');
                    return;
                }

                document.getElementById('lihatBuktiImage').src = imageUrl;
                document.getElementById('lihatBuktiTitle').innerText = 'Kwitansi: ' + bonTitle;
                document.getElementById('lihatBuktiModal').classList.remove('hidden');
            }

            // Menutup modal gambar bon
            function closeLihatBukti() {
                document.getElementById('lihatBuktiModal').classList.add('hidden');
                document.getElementById('lihatBuktiImage').src = ''; // Clear memory
            }
        </script>
    @endsection
