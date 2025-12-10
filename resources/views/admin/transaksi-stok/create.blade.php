@extends('layouts.master')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold mb-6">{{ $pageTitle }}</h1>
        <p class="text-gray-600 mb-8">{{ $pageDescription }}</p>

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100" id="stockForm">
            <form action="{{ route('transaksi.stok-admin.store') }}" method="POST" id="transactionForm">
                @csrf

                <!-- Bahan Baku -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bahan Baku</label>
                    <select name="bahan_id" id="bahanSelect"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white transition-all duration-200 hover:border-gray-300"
                        required>
                        <option value="">Pilih Bahan Baku</option>
                        @foreach ($bahans as $bahan)
                            <option value="{{ $bahan->id }}" data-stok="{{ $bahan->stok_sekarang }}">
                                {{ $bahan->nama_bahan }} (Stok: {{ $bahan->stok_sekarang }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stok Saat Ini -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Saat Ini</label>
                    <input type="text" id="currentStock" class="w-full px-4 py-3 border-2 rounded-xl bg-gray-100"
                        disabled>
                </div>

                <!-- Jenis Transaksi -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="block text-lg font-semibold text-gray-900">
                            <i class="fas fa-exchange-alt text-blue-500 mr-2"></i>
                            Jenis Transaksi
                        </label>

                        <div class="flex flex-col lg:flex-row gap-4">
                            <label class="cursor-pointer flex-1">
                                <input type="radio" name="move_type" value="in" class="sr-only peer">
                                <div
                                    class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300">
                                    <i class="fas fa-arrow-down text-2xl text-green-600 mb-2"></i>
                                    <p class="font-semibold text-gray-900">Stok Masuk</p>
                                    <p class="text-sm text-gray-500">Penambahan stok</p>
                                </div>
                            </label>

                            <label class="cursor-pointer flex-1">
                                <input type="radio" name="move_type" value="out" class="sr-only peer">
                                <div
                                    class="p-4 border-2 border-gray-200 rounded-xl text-center transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300">
                                    <i class="fas fa-arrow-up text-2xl text-red-600 mb-2"></i>
                                    <p class="font-semibold text-gray-900">Stok Keluar</p>
                                    <p class="text-sm text-gray-500">Pengurangan stok</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Quantity Input -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <label class="block text-lg font-semibold text-gray-900">
                                <i class="fas fa-balance-scale text-blue-500 mr-2"></i>
                                Jumlah Transaksi
                            </label>
                        </div>

                        <div class="relative">
                            <input type="number" name="qty" id="quantityInput" step="0.01" min="0.01"
                                class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 shadow-sm text-lg font-semibold"
                                placeholder="0.00" required>
                            <div class="absolute right-3 top-1/2 transform -translate-y-1/2 flex space-x-2">
                                <button type="button" id="increaseBtn" class="p-2 text-gray-500 hover:text-blue-600">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button type="button" id="decreaseBtn" class="p-2 text-gray-500 hover:text-blue-600">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div id="stockWarning" class="hidden p-3 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-2"></i>
                                <div>
                                    <p class="text-red-800 font-medium">Stok tidak mencukupi!</p>
                                    <p class="text-red-600 text-sm">
                                        Stok tersedia: <span class="font-bold" id="availableStock"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Keterangan -->
                <div class="space-y-4">
                    <label class="block text-lg font-semibold text-gray-900">
                        <i class="fas fa-sticky-note text-blue-500 mr-2"></i>
                        Keterangan
                    </label>

                    <textarea name="reference_type" id="description" rows="4"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300 shadow-sm resize-none"
                        placeholder="Masukkan keterangan transaksi (opsional). Contoh: 'Pembelian dari Supplier ABC', 'Rusak saat penyimpanan', 'Penyesuaian stock opname'"></textarea>
                </div>

                <!-- Stock Preview Card -->
                <div id="stockPreview"
                    class="hidden bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-6 border-2 border-blue-200 mt-6">
                    <h3 class="font-bold text-gray-900 text-lg mb-4 flex items-center">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        Preview Perubahan Stok
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-white rounded-lg border shadow-sm">
                            <p class="text-sm text-gray-600 mb-1">Stok Sebelum</p>
                            <p class="text-3xl font-bold text-gray-900" id="beforeStock"></p>
                        </div>

                        <div class="text-center p-4 bg-white rounded-lg border shadow-sm">
                            <p class="text-sm text-gray-600 mb-1">Jumlah Transaksi</p>
                            <p class="text-3xl font-bold" id="transactionAmount"></p>
                        </div>

                        <div class="text-center p-4 bg-white rounded-lg border shadow-sm">
                            <p class="text-sm text-gray-600 mb-1">Stok Sesudah</p>
                            <p class="text-3xl font-bold text-gray-900" id="afterStock"></p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-8">
                    <button type="button" id="submitButton"
                        class="bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center">
                        <i class="fas fa-save mr-3 text-lg"></i>
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 sm:mx-auto transform transition-all duration-300">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 rounded-t-2xl text-white">
                <div class="flex items-center justify-between">
                    <div class="text-center w-full">
                        <h3 class="text-xl font-bold">Konfirmasi Transaksi</h3>
                        <p class="text-blue-100 text-sm mt-1">Periksa kembali data sebelum menyimpan</p>
                    </div>
                    <button type="button" onclick="closeConfirmationModal()" class="text-white hover:text-blue-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-center mb-4">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                    </div>

                    <h4 class="text-center font-semibold text-gray-900 text-lg">Apakah Anda yakin?</h4>
                    <p class="text-center text-gray-600">Transaksi akan disimpan dan stok akan diperbarui secara permanen.
                    </p>

                    <!-- Transaction Summary -->
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 mt-4">
                        <h5 class="font-medium text-gray-900 mb-3">Ringkasan Transaksi</h5>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bahan Baku:</span>
                                <span class="font-semibold text-gray-900" id="modalBahan"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis:</span>
                                <span id="modalJenis" class="font-semibold"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah:</span>
                                <span class="font-bold text-gray-900" id="modalJumlah"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Stok Baru:</span>
                                <span class="font-bold text-gray-900" id="modalStokBaru"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Keterangan:</span>
                                <span class="text-gray-900 text-right" id="modalKeterangan"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Warning -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-2"></i>
                            <div>
                                <p class="text-yellow-800 text-sm font-medium">Perhatian!</p>
                                <p class="text-yellow-700 text-xs">Transaksi tidak dapat diubah setelah disimpan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-200 p-6">
                <div class="flex flex-col md:flex-row justify-between space-y-3 md:space-y-0 md:space-x-3">
                    <button type="button" onclick="closeConfirmationModal()"
                        class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </button>
                    <button type="button" onclick="submitTransaction()" id="confirmSubmitBtn"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl flex items-center justify-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Ya, Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 rounded-t-2xl text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold">Konfirmasi Transaksi</h3>
                        <p class="text-blue-100 text-sm mt-1">Periksa kembali data sebelum menyimpan</p>
                    </div>
                    <button type="button" onclick="closeConfirmationModal()" class="text-white hover:text-blue-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <!-- Modal Body -->
            <div class="p-6">
                <div class="space-y-4">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 text-lg">Transaksi Disimpan</h4>
                        <p class="text-gray-600 mt-2">Stok telah diperbarui sesuai transaksi</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Waktu</p>
                                <p class="font-semibold text-gray-900" id="successTime"></p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Status</p>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Berhasil
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="border-t border-gray-200 p-6">
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeSuccessModal()"
                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-700 hover:to-indigo-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl flex items-center">
                        <i class="fas fa-check mr-2"></i>
                        Oke, Mengerti
                    </button>
                    <button type="button" onclick="goToTransactions()"
                        class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-xl hover:bg-blue-50 transition-all duration-200 font-medium flex items-center">
                        <i class="fas fa-list mr-2"></i>
                        Lihat Daftar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elemen DOM
            const form = document.getElementById('transactionForm');
            const bahanSelect = document.getElementById('bahanSelect');
            const currentStockInput = document.getElementById('currentStock');
            const quantityInput = document.getElementById('quantityInput');
            const increaseBtn = document.getElementById('increaseBtn');
            const decreaseBtn = document.getElementById('decreaseBtn');
            const stockWarning = document.getElementById('stockWarning');
            const availableStock = document.getElementById('availableStock');
            const stockPreview = document.getElementById('stockPreview');
            const beforeStock = document.getElementById('beforeStock');
            const transactionAmount = document.getElementById('transactionAmount');
            const afterStock = document.getElementById('afterStock');
            const description = document.getElementById('description');
            const transactionTypeRadios = document.querySelectorAll('input[name="move_type"]');
            const submitButton = document.getElementById('submitButton');
            const confirmationModal = document.getElementById('confirmationModal');
            const successModal = document.getElementById('successModal');

            const closeConfirmButtons = document.querySelectorAll('.btn-close-confirm');
            const closeSuccessButtons = document.querySelectorAll('.btn-close-success');
            const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');

            // Variabel state
            let currentStock = 0;
            let moveType = '';
            let quantity = 0;
            let isSubmitting = false;

            // Event Listeners
            bahanSelect.addEventListener('change', updateCurrentStock);
            quantityInput.addEventListener('input', validateStock);
            increaseBtn.addEventListener('click', increaseQuantity);
            decreaseBtn.addEventListener('click', decreaseQuantity);
            transactionTypeRadios.forEach(radio => {
                radio.addEventListener('change', updateTransactionType);
            });
            submitButton.addEventListener('click', openConfirmationModal);

            // Fungsi untuk update stok saat ini
            function updateCurrentStock() {
                const selectedOption = bahanSelect.selectedOptions[0];
                if (selectedOption.value) {
                    currentStock = parseFloat(selectedOption.dataset.stok);
                    currentStockInput.value = currentStock.toFixed(2);
                    updateStockPreview();
                } else {
                    currentStock = 0;
                    currentStockInput.value = '';
                }
            }

            // Fungsi untuk update tipe transaksi
            function updateTransactionType(e) {
                moveType = e.target.value;
                validateStock();
                updateStockPreview();
            }

            // Fungsi untuk validasi stok
            function validateStock() {
                quantity = parseFloat(quantityInput.value) || 0;

                if (moveType === 'out' && quantity > currentStock) {
                    stockWarning.classList.remove('hidden');
                    availableStock.textContent = currentStock.toFixed(2);
                    quantityInput.classList.add('border-red-300');
                } else {
                    stockWarning.classList.add('hidden');
                    quantityInput.classList.remove('border-red-300');
                }

                updateStockPreview();
            }

            // Fungsi untuk menambah jumlah
            function increaseQuantity() {
                quantityInput.value = (parseFloat(quantityInput.value) || 0) + 1;
                validateStock();
            }

            // Fungsi untuk mengurangi jumlah
            function decreaseQuantity() {
                const currentValue = parseFloat(quantityInput.value) || 0;
                quantityInput.value = currentValue > 0.01 ? currentValue - 1 : 0;
                validateStock();
            }

            // Fungsi untuk update preview stok
            function updateStockPreview() {
                quantity = parseFloat(quantityInput.value) || 0;

                if (moveType && quantity > 0 && bahanSelect.value) {
                    stockPreview.classList.remove('hidden');
                    beforeStock.textContent = currentStock.toFixed(2);

                    if (moveType === 'in') {
                        transactionAmount.textContent = `+${quantity.toFixed(2)}`;
                        transactionAmount.classList.add('text-green-600');
                        transactionAmount.classList.remove('text-red-600');
                        afterStock.textContent = (currentStock + quantity).toFixed(2);
                    } else {
                        transactionAmount.textContent = `-${quantity.toFixed(2)}`;
                        transactionAmount.classList.add('text-red-600');
                        transactionAmount.classList.remove('text-green-600');
                        afterStock.textContent = (currentStock - quantity).toFixed(2);
                    }
                } else {
                    stockPreview.classList.add('hidden');
                }
            }

            // Fungsi untuk membuka modal konfirmasi
            function openConfirmationModal() {
                if (!isFormValid()) {
                    showToast('Harap isi semua field dengan benar', 'error');
                    return;
                }

                // Update modal content
                const selectedOption = bahanSelect.selectedOptions[0];
                document.getElementById('modalBahan').textContent = selectedOption.text.split('(')[0].trim();
                document.getElementById('modalJenis').innerHTML = moveType === 'in' ?
                    '<span class="text-green-600">Stok Masuk (+)</span>' :
                    '<span class="text-red-600">Stok Keluar (-)</span>';
                document.getElementById('modalJumlah').textContent = quantity.toFixed(2);
                document.getElementById('modalStokBaru').textContent = afterStock.textContent;
                document.getElementById('modalKeterangan').textContent = description.value ||
                    'Tidak ada keterangan';

                // Show modal with animation
                confirmationModal.classList.remove('hidden');
                setTimeout(() => {
                    confirmationModal.querySelector('.max-w-md').classList.remove('scale-95');
                    confirmationModal.querySelector('.max-w-md').classList.add('scale-100');
                }, 10);

                // Disable body scroll
                document.body.style.overflow = 'hidden';
            }

            // ====== CLOSE CONFIRMATION MODAL ======
            function closeConfirmationModal() {
                const modal = document.getElementById('confirmationModal');
                const box = modal.querySelector('.max-w-md') || modal.firstElementChild;
                box.classList.remove('scale-100');
                box.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 200);
            }

            // Fungsi untuk submit transaksi
            async function submitTransaction() {
                if (isSubmitting) return;

                isSubmitting = true;

                // Update button state
                confirmSubmitBtn.disabled = true;
                confirmSubmitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';

                try {
                    // Create FormData
                    const formData = new FormData(form);

                    // Send request
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(Object.fromEntries(formData))
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Close confirmation modal
                        closeConfirmationModal();

                        // Show success modal
                        showSuccessModal();

                        // Reset form after success
                        setTimeout(() => {
                            form.reset();
                            resetFormState();
                        }, 1000);
                    } else {
                        throw new Error(result.message || 'Gagal menyimpan transaksi');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast(error.message || 'Terjadi kesalahan saat menyimpan', 'error');

                    // Re-enable button
                    confirmSubmitBtn.disabled = false;
                    confirmSubmitBtn.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Ya, Simpan';
                } finally {
                    isSubmitting = false;
                }
            }

            // Fungsi untuk menampilkan modal sukses
            function showSuccessModal() {
                // Update time
                const now = new Date();
                document.getElementById('successTime').textContent =
                    now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                // Show modal with animation
                successModal.classList.remove('hidden');
                setTimeout(() => {
                    successModal.querySelector('.max-w-md').classList.remove('scale-95');
                    successModal.querySelector('.max-w-md').classList.add('scale-100');
                }, 10);

                // Redirect to index page after 7 seconds
                setTimeout(() => {
                    window.location.href =
                    "{{ route('transaksi.stok-admin') }}"; // Replace with your index route
                }, 7000); // 7000 milliseconds = 7 seconds
            }


            // Fungsi untuk menutup modal sukses
            function closeSuccessModal() {
                const modal = document.getElementById('successModal');
                const box = modal.querySelector('.max-w-md') || modal.firstElementChild;
                box.classList.remove('scale-100');
                box.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    window.location.href = "{{ route('transaksi.stok-admin') }}"
                }, 200);
            }

            // Fungsi untuk pergi ke daftar transaksi
            function goToTransactions() {
                window.location.href = "{{ route('transaksi.stok-admin') }}";
            }

            // Fungsi untuk reset state form
            function resetFormState() {
                currentStock = 0;
                moveType = '';
                quantity = 0;
                currentStockInput.value = '';
                stockPreview.classList.add('hidden');
                stockWarning.classList.add('hidden');
            }

            // Fungsi untuk menampilkan toast
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium animate-fade-in ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
                toast.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} mr-2"></i>
                ${message}
            </div>
        `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.classList.add('animate-fade-out');
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }

            // Fungsi untuk validasi form
            function isFormValid() {
                return bahanSelect.value && moveType && quantity > 0;
            }

            // ====== EVENT: Tombol Close & Batal ======
            closeConfirmButtons.forEach(btn => {
                btn.addEventListener('click', closeConfirmationModal);
            });

            closeSuccessButtons.forEach(btn => {
                btn.addEventListener('click', closeSuccessModal);
            });

            // Close modals with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!confirmationModal.classList.contains('hidden')) {
                        closeConfirmationModal();
                    }
                    if (!successModal.classList.contains('hidden')) {
                        closeSuccessModal();
                    }
                }
            });

            // Close modals when clicking outside
            confirmationModal.addEventListener('click', function(e) {
                if (e.target === confirmationModal) {
                    closeConfirmationModal();
                }
            });

            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    closeSuccessModal();
                }
            });
            // Expose ke global agar onclick di HTML tetap jalan
            window.closeConfirmationModal = closeConfirmationModal;
            window.closeSuccessModal = closeSuccessModal;
            window.submitTransaction = submitTransaction;
            window.goToTransactions = goToTransactions;
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-out {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        @keyframes scale-in {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes scale-out {
            from {
                transform: scale(1);
                opacity: 1;
            }

            to {
                transform: scale(0.9);
                opacity: 0;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .animate-fade-out {
            animation: fade-out 0.3s ease-out;
        }

        .scale-95 {
            transform: scale(0.95);
        }

        .scale-100 {
            transform: scale(1);
        }

        .transition-transform {
            transition: transform 0.2s ease-out;
        }

        /* Custom scrollbar */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Radio card selection animation */
        input[type="radio"]:checked+div {
            transform: scale(1.02);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Modal overlay */
        #confirmationModal,
        #successModal {
            backdrop-filter: blur(4px);
        }

        /* Disabled button state */
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        button:disabled:hover {
            transform: none !important;
            box-shadow: none !important;
        }

        /* Spinner animation */
        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
