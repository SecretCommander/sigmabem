<table>
    <thead>
        <tr>
            <th colspan="13" style="text-align: center; font-size: 16px;">
                <strong>LAPORAN PERTANGGUNGJAWABAN (LPJ)</strong><br>
                <strong>{{ strtoupper($kegiatan->Nama_Kegiatan) }}</strong>
            </th>
        </tr>
        <tr></tr>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Sie</th>
            <th rowspan="2">Keterangan</th>
            <th rowspan="2">Jenis Pengeluaran</th>
            <th colspan="4" style="text-align: center">Anggaran Proposal</th>
            <th colspan="4" style="text-align: center">Realisasi</th>
            <th rowspan="2">Bukti (Bon)</th>
            <th rowspan="2">Total Kwitansi</th>
        </tr>
        <tr>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Harga Unit</th>
            <th>Total Anggaran</th>
            <th>Qty</th>
            <th>Satuan</th>
            <th>Harga Unit</th>
            <th>Total Realisasi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($sies as $sie)
            @php
                $unifiedItems = [];

                // 1. Ambil Semua Item Anggaran (RAB Awal)
                foreach ($sie->items as $item) {
                    $lpj = $sie->item_lpj
                        ->where('Keterangan', $item->Keterangan)
                        ->where('Jenis_Pengeluaran', $item->Jenis_Pengeluaran)
                        ->first();

                    $unifiedItems[] = (object) [
                        'Keterangan' => $item->Keterangan,
                        'Jenis_Pengeluaran' => $item->Jenis_Pengeluaran,
                        'Qty_Anggaran' => $item->Qty,
                        'Satuan_Anggaran' => $item->Satuan,
                        'Harga_Anggaran' => $item->Harga_Unit,
                        'Total_Anggaran' => $item->Qty * $item->Harga_Unit,
                        'Qty_Realisasi' => $lpj ? $lpj->Qty_Realisasi : null,
                        'Satuan_Realisasi' => $lpj ? $lpj->Satuan_Realisasi : '-',
                        'Harga_Realisasi' => $lpj ? $lpj->Harga_Realisasi : null,
                        'Total_Realisasi' => $lpj ? $lpj->Qty_Realisasi * $lpj->Harga_Realisasi : 0,
                        'ID_Bon' => $item->ID_Bon, // Bisa Null jika belum direalisasikan
                        'Nama_Bon' => $item->bon ? $item->bon->Nama_Bon : '-',
                    ];
                }

                // 2. Ambil "Item Baru" (Hanya terdaftar di LPJ, tidak ada di RAB)
                foreach ($sie->item_lpj as $lpj) {
                    $existsInProposal = $sie->items
                        ->where('Keterangan', $lpj->Keterangan)
                        ->where('Jenis_Pengeluaran', $lpj->Jenis_Pengeluaran)
                        ->isNotEmpty();

                    if (!$existsInProposal) {
                        $unifiedItems[] = (object) [
                            'Keterangan' => $lpj->Keterangan,
                            'Jenis_Pengeluaran' => $lpj->Jenis_Pengeluaran,
                            'Qty_Anggaran' => null,
                            'Satuan_Anggaran' => '-',
                            'Harga_Anggaran' => null,
                            'Total_Anggaran' => 0,
                            'Qty_Realisasi' => $lpj->Qty_Realisasi,
                            'Satuan_Realisasi' => $lpj->Satuan_Realisasi,
                            'Harga_Realisasi' => $lpj->Harga_Realisasi,
                            'Total_Realisasi' => $lpj->Qty_Realisasi * $lpj->Harga_Realisasi,
                            'ID_Bon' => $lpj->ID_Bon,
                            'Nama_Bon' => $lpj->bon ? $lpj->bon->Nama_Bon : '-',
                        ];
                    }
                }

                // 3. Kelompokkan (Grouping) berdasarkan Bon.
                // Jika ID_Bon kosong (null), kumpulkan dalam grup bernama 'no_bon'
                $itemsByBon = collect($unifiedItems)->groupBy(function ($item) {
                    return $item->ID_Bon ? $item->ID_Bon : 'no_bon';
                });
            @endphp

            @foreach ($itemsByBon as $bonId => $items)
                @php
                    $rowspan = count($items);
                    $first = true;
                    $totalKwitansi = $items->sum('Total_Realisasi');
                @endphp

                @foreach ($items as $item)
                    <tr>
                        @if ($first)
                            <td rowspan="{{ $rowspan }}">{{ $no++ }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $sie->Nama_Sie }}</td>
                        @endif

                        <td>{{ $item->Keterangan }}</td>
                        <td>{{ $item->Jenis_Pengeluaran }}</td>

                        <td>{{ $item->Qty_Anggaran ?? '-' }}</td>
                        <td>{{ $item->Satuan_Anggaran }}</td>
                        <td>{{ $item->Harga_Anggaran ?? '-' }}</td>
                        <td>{{ $item->Total_Anggaran ? $item->Total_Anggaran : '-' }}</td>

                        <td>{{ $item->Qty_Realisasi ?? '-' }}</td>
                        <td>{{ $item->Satuan_Realisasi }}</td>
                        <td>{{ $item->Harga_Realisasi ?? '-' }}</td>
                        <td>{{ $item->Total_Realisasi ? $item->Total_Realisasi : '-' }}</td>

                        @if ($first)
                            <td rowspan="{{ $rowspan }}">{{ $item->Nama_Bon }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $bonId !== 'no_bon' ? $totalKwitansi : '-' }}</td>
                        @endif
                    </tr>
                    @php $first = false; @endphp
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
