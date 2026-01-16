<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Laporan</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            color: #2d3748;
            font-size: 18px;
        }
        .filter-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f0f4f8;
            border-radius: 4px;
            font-size: 10px;
        }
        .filter-info strong {
            display: block;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
        }
        table th {
            background-color: #2d3748;
            color: white;
            padding: 8px;
            border: 1px solid #2d3748;
            text-align: left;
        }
        table td {
            padding: 6px 8px;
            border: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #718096;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .summary {
            margin-top: 15px;
            padding: 10px;
            background-color: #f0f4f8;
            border-radius: 4px;
            font-size: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daftar Laporan</h1>
        <div>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</div>
        <div>Total: {{ $reports->count() }} laporan</div>
    </div>

    <!-- Informasi Filter -->
    @if(count(array_filter($filterParams ?? [])) > 0)
    <div class="filter-info">
        <strong>Filter yang digunakan:</strong>
        @if(isset($filterParams['tanggal_mulai']) && $filterParams['tanggal_mulai'])
            • Tanggal Mulai: {{ \Carbon\Carbon::parse($filterParams['tanggal_mulai'])->format('d/m/Y') }}<br>
        @endif
        @if(isset($filterParams['tanggal_akhir']) && $filterParams['tanggal_akhir'])
            • Tanggal Akhir: {{ \Carbon\Carbon::parse($filterParams['tanggal_akhir'])->format('d/m/Y') }}<br>
        @endif
        @if(isset($filterParams['jenis_transaksi']) && $filterParams['jenis_transaksi'] != 'semua')
            • Jenis Transaksi: {{ ucfirst($filterParams['jenis_transaksi']) }}<br>
        @endif
        @if(isset($filterParams['bahan_id']) && $filterParams['bahan_id'])
            • Bahan Baku: {{ \App\Models\Bahan::find($filterParams['bahan_id'])->nama_bahan ?? 'ID: ' . $filterParams['bahan_id'] }}<br>
        @endif
    </div>
    @endif

    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Laporan</th>
                <th>Jenis Laporan</th>
                <th>Periode</th>
                <th>Jenis Transaksi</th>
                <th>Bahan Baku</th>
                <th>Status</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Dibuat</th>
                <th>Terakhir Diupdate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $report->nama_laporan }}</td>
                <td>
                    <span class="badge" style="background-color: {{ $report->jenis_laporan == 'harian' ? '#c6f6d5' : ($report->jenis_laporan == 'bulanan' ? '#bee3f8' : '#e9d8fd') }}; color: {{ $report->jenis_laporan == 'harian' ? '#22543d' : ($report->jenis_laporan == 'bulanan' ? '#2c5282' : '#553c9a') }};">
                        {{ ucfirst($report->jenis_laporan) }}
                    </span>
                </td>
                <td>
                    @if($report->jenis_laporan == 'harian')
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('d/m/Y') }}
                    @elseif($report->jenis_laporan == 'bulanan')
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('F Y') }}
                    @elseif($report->jenis_laporan == 'tahunan')
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($report->tanggal_mulai)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($report->tanggal_akhir)->format('d/m/Y') }}
                    @endif
                </td>
                <td>
                    <span class="badge" style="background-color: {{ $report->jenis_transaksi == 'masuk' ? '#c6f6d5' : '#fed7d7' }}; color: {{ $report->jenis_transaksi == 'masuk' ? '#22543d' : '#742a2a' }};">
                        {{ ucfirst($report->jenis_transaksi) }}
                    </span>
                </td>
                <td>{{ $report->bahan->nama_bahan ?? 'Semua Bahan' }}</td>
                <td>
                    <span class="badge" style="background-color: {{ $report->status == 'published' ? '#c6f6d5' : '#feebc8' }}; color: {{ $report->status == 'published' ? '#22543d' : '#744210' }};">
                        {{ ucfirst($report->status) }}
                    </span>
                </td>
                <td>{{ $report->user->name ?? 'User' }}</td>
                <td>{{ $report->created_at->format('d/m/Y') }}</td>
                <td>{{ $report->updated_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div class="summary">
        <strong>Ringkasan:</strong><br>
        • Total Laporan: {{ $reports->count() }}<br>
        • Status Published: {{ $reports->where('status', 'published')->count() }}<br>
        • Status Draft: {{ $reports->where('status', 'draft')->count() }}<br>
        • Jenis Harian: {{ $reports->where('jenis_laporan', 'harian')->count() }}<br>
        • Jenis Bulanan: {{ $reports->where('jenis_laporan', 'bulanan')->count() }}<br>
        • Jenis Tahunan: {{ $reports->where('jenis_laporan', 'tahunan')->count() }}<br>
        • Transaksi Masuk: {{ $reports->where('jenis_transaksi', 'masuk')->count() }}<br>
        • Transaksi Keluar: {{ $reports->where('jenis_transaksi', 'keluar')->count() }}
    </div>
</body>
</html>
