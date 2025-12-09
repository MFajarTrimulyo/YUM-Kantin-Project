<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ substr($order->id, -6) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page { margin: 0; size: 80mm auto; } /* Standard Thermal Paper Size */
            body { margin: 10mm; }
            .no-print { display: none; }
        }
        body { font-family: 'Courier New', Courier, monospace; } /* Monospace for receipt look */
    </style>
</head>
<body class="bg-gray-100 flex items-start justify-center min-h-screen py-10">

    <div class="bg-white w-[300px] p-4 shadow-lg text-xs text-gray-800">
        
        {{-- Header --}}
        <div class="text-center mb-4 border-b border-dashed border-gray-400 pb-4">
            <h1 class="text-xl font-bold uppercase mb-1">YUM KANTIN</h1>
            <p class="font-bold uppercase">{{ $order->gerai->nama }}</p>
            <p class="text-[10px] text-gray-500">{{ $order->gerai->lokasi ?? 'Kantin UM' }}</p>
        </div>

        {{-- Info Order --}}
        <div class="mb-4 flex flex-col gap-1">
            <div class="flex justify-between">
                <span>No. Order</span>
                <span class="font-bold">#{{ substr($order->id, -6) }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span>{{ $order->created_at->format('d/m/y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pelanggan</span>
                <span>{{ substr($order->user->nama, 0, 15) }}</span>
            </div>
        </div>

        {{-- Items --}}
        <div class="border-b border-dashed border-gray-400 pb-4 mb-4">
            @foreach($order->detail_pemesanans as $detail)
            <div class="mb-2">
                <div class="font-bold">{{ $detail->produk->nama }}</div>
                <div class="flex justify-between">
                    <span>{{ $detail->qty }} x {{ number_format($detail->harga_satuan_saat_beli, 0, ',', '.') }}</span>
                    <span>{{ number_format($detail->qty * $detail->harga_satuan_saat_beli, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Total --}}
        <div class="flex justify-between font-bold text-sm mb-6">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
        </div>

        {{-- Footer --}}
        <div class="text-center text-[10px] text-gray-500 mt-6">
            <p>Terima Kasih atas pesanan Anda.</p>
            <p>Simpan struk ini sebagai bukti pembayaran.</p>
        </div>

        {{-- Print Button (Hidden when printing) --}}
        <div class="no-print mt-6 text-center">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700 w-full mb-2">
                Cetak Struk
            </button>
            <button onclick="window.close()" class="text-gray-500 underline text-xs">Tutup</button>
        </div>

    </div>

    {{-- Auto Print Script --}}
    <script>
        window.onload = function() {
            // Uncomment line below to auto-print when opened
            // window.print();
        }
    </script>
</body>
</html>