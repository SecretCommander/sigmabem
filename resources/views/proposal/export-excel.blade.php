<table>
    <thead>
        <tr>
            <th colspan="8" style="text-align: center; font-size: 16px;">
                <strong>RENCANA ANGGARAN BIAYA (RAB)</strong><br>
                <strong>{{ strtoupper($kegiatan->Nama_Kegiatan) }}</strong>
            </th>
        </tr>
        <tr></tr>
        <tr>
            <th style="border: 1px solid #000; text-align:center;">No</th>
            <th style="border: 1px solid #000; text-align:center;">Sie</th>
            <th style="border: 1px solid #000; text-align:center;">Keterangan</th>
            <th style="border: 1px solid #000; text-align:center;">Jenis Pengeluaran</th>
            <th style="border: 1px solid #000; text-align:center;">Qty</th>
            <th style="border: 1px solid #000; text-align:center;">Satuan</th>
            <th style="border: 1px solid #000; text-align:center;">Harga Unit</th>
            <th style="border: 1px solid #000; text-align:center;">Total</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($sies as $sie)
            @php 
                $rowspan = $sie->items->count() > 0 ? $sie->items->count() : 1; 
                $first = true;
            @endphp

            @forelse($sie->items as $item)
                <tr>
                    @if($first)
                        <td rowspan="{{ $rowspan }}" style="text-align: center; vertical-align: top;">{{ $no++ }}</td>
                        <td rowspan="{{ $rowspan }}" style="vertical-align: top;">{{ $sie->Nama_Sie }}</td>
                    @endif
                    
                    <td>{{ $item->Keterangan }}</td>
                    <td>{{ $item->Jenis_Pengeluaran }}</td>
                    <td style="text-align: center;">{{ $item->Qty }}</td>
                    <td>{{ $item->Satuan }}</td>
                    <td>{{ $item->Harga_Unit }}</td>
                    <td>{{ $item->Qty * $item->Harga_Unit }}</td>
                </tr>
                @php $first = false; @endphp
            @empty
                <tr>
                    <td style="text-align: center;">{{ $no++ }}</td>
                    <td>{{ $sie->Nama_Sie }}</td>
                    <td colspan="6" style="text-align: center;">Belum ada item anggaran</td>
                </tr>
            @endforelse
        @endforeach
    </tbody>
</table>