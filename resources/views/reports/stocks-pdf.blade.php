<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        .header {
            margin-bottom: 20px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 12px;
        }

        .title {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .subtitle {
            margin-top: 4px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            text-align: left;
            font-weight: bold;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Laporan Stok Jayusmart</h1>
        <div class="subtitle">
            Sistem Monitoring Transaksi dan Stok Minimarket
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Cabang</th>
                <th>Stok Akhir</th>
                <th>Minimum Stok</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($stocks as $stock)
                <tr>
                    <td>{{ $stock->product->name ?? '-' }}</td>
                    <td>{{ $stock->product->category->name ?? '-' }}</td>
                    <td>{{ $stock->branch->name ?? '-' }}</td>
                    <td class="text-right">{{ $stock->quantity }}</td>
                    <td class="text-right">{{ $stock->minimum_stock }}</td>
                    <td>{{ $stock->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">
                        Belum ada data stok.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>