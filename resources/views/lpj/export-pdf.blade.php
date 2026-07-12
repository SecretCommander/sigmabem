<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export PDF LPJ</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .title { font-size: 14px; font-weight: bold; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; vertical-align: middle; }
        th { background-color: #f2f2f2; text-align: center; }
        .ttd-container { width: 100%; margin-top: 30px; }
        .ttd-box { width: 33%; float: left; text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="text-center title">
        LAPORAN PERTANGGUNGJAWABAN (LPJ)<br>
        KEGIATAN {{ strtoupper($kegiatan->Nama_Kegiatan) }}
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Sie</th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2">Jenis Pengeluaran</th>
                <th colspan="3">Anggaran</th>
                <th colspan="4">Realisasi</th>
                <th rowspan="2">Nama Bon</th>
                <th rowspan="2">Total Kwitansi</th>
            </tr>
            <tr>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Selisih</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1; 
                $grandTotalAnggaran = 0; 
                $grandTotalRealisasi = 0; 
            @endphp
            @foreach($sies as $sie)
                @php
                    $unifiedItems = [];
                    
                    // 1. Ambil Semua Item Anggaran
                    foreach($sie->items as $item) {
                        $lpj = $sie->item_lpj->where('Keterangan', $item->Keterangan)->where('Jenis_Pengeluaran', $item->Jenis_Pengeluaran)->first();
                        
                        $unifiedItems[] = (object) [
                            'Keterangan' => $item->Keterangan,
                            'Jenis_Pengeluaran' => $item->Jenis_Pengeluaran,
                            'Qty_Anggaran' => $item->Qty,
                            'Harga_Anggaran' => $item->Harga_Unit,
                            'Total_Anggaran' => $item->Qty * $item->Harga_Unit,
                            'Qty_Realisasi' => $lpj ? $lpj->Qty_Realisasi : null,
                            'Harga_Realisasi' => $lpj ? $lpj->Harga_Realisasi : null,
                            'Total_Realisasi' => $lpj ? ($lpj->Qty_Realisasi * $lpj->Harga_Realisasi) : 0,
                            'ID_Bon' => $item->ID_Bon,
                            'Nama_Bon' => $item->bon ? $item->bon->Nama_Bon : '-',
                        ];
                    }
                    
                    // 2. Ambil "Item Baru" (Hanya di LPJ)
                    foreach($sie->item_lpj as $lpj) {
                        $existsInProposal = $sie->items->where('Keterangan', $lpj->Keterangan)->where('Jenis_Pengeluaran', $lpj->Jenis_Pengeluaran)->isNotEmpty();
                        
                        if (!$existsInProposal) {
                            $unifiedItems[] = (object) [
                                'Keterangan' => $lpj->Keterangan,
                                'Jenis_Pengeluaran' => $lpj->Jenis_Pengeluaran,
                                'Qty_Anggaran' => null,
                                'Harga_Anggaran' => null,
                                'Total_Anggaran' => 0,
                                'Qty_Realisasi' => $lpj->Qty_Realisasi,
                                'Harga_Realisasi' => $lpj->Harga_Realisasi,
                                'Total_Realisasi' => $lpj->Qty_Realisasi * $lpj->Harga_Realisasi,
                                'ID_Bon' => $lpj->ID_Bon,
                                'Nama_Bon' => $lpj->bon ? $lpj->bon->Nama_Bon : '-',
                            ];
                        }
                    }
                    
                    // Grouping berdasarkan Bon
                    $itemsByBon = collect($unifiedItems)->groupBy(function($item) {
                        return $item->ID_Bon ? $item->ID_Bon : 'no_bon';
                    });
                @endphp

                @foreach($itemsByBon as $bonId => $items)
                    @php 
                        $rowspan = count($items); 
                        $first = true;
                        $totalKwitansi = $items->sum('Total_Realisasi');
                    @endphp

                    @foreach($items as $item)
                        @php 
                            $grandTotalAnggaran += $item->Total_Anggaran;
                            $grandTotalRealisasi += $item->Total_Realisasi;
                        @endphp
                        <tr>
                            @if($first)
                                <td rowspan="{{ $rowspan }}" class="text-center">{{ $no++ }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $sie->Nama_Sie }}</td>
                            @endif
                            
                            <td>{{ $item->Keterangan }}</td>
                            <td>{{ $item->Jenis_Pengeluaran }}</td>
                            
                            <td class="text-center">{{ $item->Qty_Anggaran ?? '-' }}</td>
                            <td class="text-right">{{ $item->Harga_Anggaran ? number_format($item->Harga_Anggaran,0,',','.') : '-' }}</td>
                            <td class="text-right">{{ $item->Total_Anggaran ? number_format($item->Total_Anggaran,0,',','.') : '-' }}</td>
                            
                            <td class="text-center">{{ $item->Qty_Realisasi ?? '-' }}</td>
                            <td class="text-right">{{ $item->Harga_Realisasi ? number_format($item->Harga_Realisasi,0,',','.') : '-' }}</td>
                            <td class="text-right">{{ $item->Total_Realisasi ? number_format($item->Total_Realisasi,0,',','.') : '-' }}</td>
                            
                            <td class="text-right">{{ number_format($item->Total_Anggaran - $item->Total_Realisasi,0,',','.') }}</td>

                            @if($first)
                                <td rowspan="{{ $rowspan }}" class="text-center">{{ $item->Nama_Bon }}</td>
                                <td rowspan="{{ $rowspan }}" class="text-right font-bold">
                                    {{ $bonId !== 'no_bon' ? number_format($totalKwitansi,0,',','.') : '-' }}
                                </td>
                            @endif
                        </tr>
                        @php $first = false; @endphp
                    @endforeach
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">TOTAL KESELURUHAN</th>
                <th class="text-right">{{ number_format($grandTotalAnggaran,0,',','.') }}</th>
                <th colspan="2"></th>
                <th class="text-right">{{ number_format($grandTotalRealisasi,0,',','.') }}</th>
                <th class="text-right">{{ number_format($grandTotalAnggaran - $grandTotalRealisasi,0,',','.') }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    <div class="ttd-container">
        <div class="ttd-box">
            Mengetahui,<br>Ketua Panitia<br><br><br><br>
            <strong>( .................................... )</strong>
        </div>
        <div class="ttd-box" style="float: right;">
            <br>Bendahara<br><br><br><br>
            <strong>( .................................... )</strong>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>