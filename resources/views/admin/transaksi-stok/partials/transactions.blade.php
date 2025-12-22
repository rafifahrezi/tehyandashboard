<!-- Transactions Table -->
<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-200">
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Bahan</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jenis</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok Sebelum
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok Sesudah
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pegawai</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Keterangan
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($transactions as $transaction)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <!-- Tanggal -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $transaction['tanggal'] }}</div>
                    </td>

                    <!-- Bahan -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $transaction['bahan'] }}</div>
                    </td>

                    <!-- Jenis -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        {{ $transaction['jenis_color'] == 'green' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <i
                                class="fas {{ $transaction['jenis'] == 'Masuk' ? 'fa-arrow-down mr-1' : 'fa-arrow-up mr-1' }} text-xs"></i>
                            {{ $transaction['jenis'] }}
                        </span>
                    </td>

                    <!-- Jumlah -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div
                            class="text-sm font-bold
                        {{ $transaction['jenis'] == 'Masuk' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction['jumlah'] }}
                        </div>
                    </td>

                    <!-- Stok Sebelum -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-600">{{ $transaction['stok_sebelum'] }}</div>
                    </td>

                    <!-- Stok Sesudah -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $transaction['stok_sesudah'] }}</div>
                    </td>

                    <!-- Pegawai -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold mr-3">
                                {{ substr($transaction['pegawai'], 0, 1) }}
                            </div>
                            <span class="text-sm text-gray-700">{{{ $transaction['pegawai'] }}}</span>
                        </div>
                    </td>

                    <!-- Keterangan -->
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600 max-w-xs truncate" title="{{ $transaction['keterangan'] }}">
                            {{ $transaction['keterangan'] }}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="border-t border-gray-200 px-6 py-4">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="text-sm text-gray-600 mb-4 lg:mb-0">
            Menampilkan <span class="font-semibold">{{ $transactions->count() }}</span> transaksi
        </div>
        <div class="flex items-center space-x-2">
            {{ $pagination->links() }}
        </div>
    </div>
</div>


