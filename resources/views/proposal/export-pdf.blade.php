<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Export PDF RAB</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .ttd-container {
            width: 100%;
            margin-top: 40px;
        }

        .ttd-box {
            width: 33%;
            float: left;
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="text-center title">
        RENCANA ANGGARAN BIAYA (RAB)<br>
        KEGIATAN {{ strtoupper($kegiatan->Nama_Kegiatan) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Sie</th>
                <th>Keterangan</th>
                <th>Jenis Pengeluaran</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Harga Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $grandTotal = 0;
            @endphp

            @foreach ($sies as $sie)
                @php
                    $rowspan = $sie->items->count() > 0 ? $sie->items->count() : 1;
                    $first = true;
                @endphp

                @forelse($sie->items as $item)
                    @php $grandTotal += ($item->Qty * $item->Harga_Unit); @endphp
                    <tr>
                        @if ($first)
                            <td rowspan="{{ $rowspan }}" class="text-center" style="vertical-align: top;">
                                {{ $no++ }}</td>
                            <td rowspan="{{ $rowspan }}" style="vertical-align: top;">{{ $sie->Nama_Sie }}</td>
                        @endif

                        <td>{{ $item->Keterangan }}</td>
                        <td>{{ $item->Jenis_Pengeluaran }}</td>
                        <td class="text-center">{{ $item->Qty }}</td>
                        <td class="text-center">{{ $item->Satuan }}</td>
                        <td class="text-right">Rp {{ number_format($item->Harga_Unit, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->Qty * $item->Harga_Unit, 0, ',', '.') }}</td>
                    </tr>
                    @php $first = false; @endphp
                @empty
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>{{ $sie->Nama_Sie }}</td>
                        <td colspan="6" class="text-center font-bold">Belum ada item anggaran di sie ini</td>
                    </tr>
                @endforelse
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-right font-bold">TOTAL KESELURUHAN</th>
                <th class="text-right font-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
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
