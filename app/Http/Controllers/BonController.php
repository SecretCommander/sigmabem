<?php

namespace App\Http\Controllers;

use App\Models\Bon;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Perbaikan Typo pada Validasi
        $request->validate([
            'kegiatan_id' => 'required',
            'sie_id' => 'required',
            'nama_bon' => 'required|string|max:255',
            'bukti_pembayaran' => 'required|image|mimes:jpg,png,jpeg|max:2048', // Typo iamge diperbaiki
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:Item,ID_Item', // Sesuaikan dengan nama tabel aslinya
            'realisasi_qty' => 'required|array',
            'realisasi_qty.*' => 'numeric',
            'realisasi_harga' => 'required|array', // Typo realisai diperbaiki
            'realisasi_harga.*' => 'numeric',
            'realisasi_satuan' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // 1. Upload file Bukti Pembayaran
            $file = $request->file('bukti_pembayaran');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/bon'), $fileName);

            // 2. Simpan data Master Bon
            $bon = new Bon;
            $bon->ID_Sie = $request->sie_id; // WAJIB diisi karena dipakai untuk relasi
            $bon->Nama_Bon = $request->nama_bon;
            $bon->Foto_Bon = $fileName; // Ubah dari Bukti_Pembayaran jadi Foto_Bon sesuai Model
            $bon->save();

            // 3. Loop Item Terpilih untuk Sinkronisasi ID_Bon & Catat Item_Lpj
            foreach ($request->item_ids as $itemId) {
                // Update ID_Bon pada baris Item anggaran terpilih
                $item = Item::findOrFail($itemId);
                $item->ID_Bon = $bon->ID_Bon;
                $item->save();

                // Ambil data realisasi dari input form
                $qtyRealisasi = $request->realisasi_qty[$itemId];
                $hargaRealisasi = $request->realisasi_harga[$itemId];

                // Simpan data Item LPJ
                DB::table('item_lpj')->insert([
                    'ID_Sie' => $request->sie_id, // Wajib sesuai migration
                    'ID_Bon' => $bon->ID_Bon,
                    'Jenis_Pengeluaran' => $item->Jenis_Pengeluaran,
                    'Keterangan' => $item->Keterangan, // Keterangan harus K besar (case-sensitive)
                    'Qty_Realisasi' => $qtyRealisasi,
                    'Satuan_Realisasi' => $request->realisasi_satuan[$itemId], // Typo pemanggilan input
                    'Harga_Realisasi' => $hargaRealisasi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 4. PROSES INPUT ITEM BARU (DI LUAR ANGGARAN PROPOSAL) jika ada
            if ($request->has('baru_keterangan')) {
                foreach ($request->baru_keterangan as $key => $keterangan) {
                    // A. Buat record Item baru di tabel Item anggaran
                    // $newItem = new Item;
                    // $newItem->ID_Sie = $request->sie_id; // Wajib diisi!
                    // $newItem->Jenis_Pengeluaran = $request->baru_jenis[$key];
                    // $newItem->Keterangan = $keterangan;
                    // $newItem->Qty = $request->baru_qty[$key];
                    // $newItem->Satuan = $request->baru_satuan[$key];
                    // $newItem->Harga_Unit = $request->baru_harga[$key];
                    // $newItem->ID_Bon = $bon->ID_Bon; 
                    // $newItem->save();

                    // B. Catat LPJ-nya juga agar sesuai format Migration
                    DB::table('item_lpj')->insert([
                        'ID_Sie' => $request->sie_id,
                        'ID_Bon' => $bon->ID_Bon,
                        'Jenis_Pengeluaran' => $request->baru_jenis[$key],
                        'Keterangan' => $keterangan,
                        'Qty_Realisasi' => $request->baru_qty[$key],
                        'Satuan_Realisasi' => $request->baru_satuan[$key],
                        'Harga_Realisasi' => $request->baru_harga[$key],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('lpj.show', ['id' => $request->kegiatan_id])->with('success', 'Bon berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            // Jika ada kolom database yang typo, error aslinya akan tampil di sini
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat Bon: '.$e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
