<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Session::get('user_id');

        $kegiatan = Kegiatan::where('ID_Pengguna', '=', $user, 'and')->get();

        $site = $request->segment(1);
        if ($site === 'lpj') {
            return view('lpj.index', compact('kegiatan'));
        }
        return view('proposal.index', compact('kegiatan'));
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
        $user = Session::get('user_id');

        $request->validate([
            'Nama_Kegiatan' => 'required|string|max:255',
            'Tanggal_Pelaksanaan' => 'required|date',
            'Jenis_RAB' => 'required|string|max:255',
        ]);

        $kegiatan = new Kegiatan();
        $kegiatan->Nama_Kegiatan = $request->Nama_Kegiatan;
        $kegiatan->Tanggal_Pelaksanaan = $request->Tanggal_Pelaksanaan;
        $kegiatan->Jenis_RAB = $request->Jenis_RAB;
        $kegiatan->ID_Pengguna = $user;
        $kegiatan->save();

        return redirect()->route('proposal.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.  
     */
    public function show(int $id, Request $request)
    {
        $kegiatan = Kegiatan::with(['sie.items','items'])->findOrFail($id);
        $sie = $kegiatan->sie;


        $site = $request->segment(1);
        if ($site === 'lpj') {
            $kegiatan = Kegiatan::with(['sie.items', 'sie.item_lpj'])->findOrFail($id);
            $sie = $kegiatan->sie;
            return view('lpj.show', compact('kegiatan', 'sie'));
        }
        return view('proposal.show', compact('kegiatan', 'sie'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan)
    {
        $kegiatan = Kegiatan::findOrFail($kegiatan->ID_Kegiatan);
        return view('proposal.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'Nama_Kegiatan' => 'required|string|max:255',
            'Tanggal_Pelaksanaan' => 'required|date',
            'Jenis_RAB' => 'required|string|max:255',
        ]);

        $kegiatan->Nama_Kegiatan = $request->Nama_Kegiatan;
        $kegiatan->Tanggal_Pelaksanaan = $request->Tanggal_Pelaksanaan;
        $kegiatan->Jenis_RAB = $request->Jenis_RAB;

        $kegiatan->save();

        return redirect()->route('proposal.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete($kegiatan->ID_Kegiatan);
        return redirect()->route('proposal.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
