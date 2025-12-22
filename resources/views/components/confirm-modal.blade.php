<!-- resources/views/components/confirm-modal.blade.php -->
<div id="confirmModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="modalBox">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Pengguna?</h3>
            <p class="text-gray-600">Anda akan menghapus pengguna: <strong id="confirmUserName">User</strong></p>
            <p class="text-sm text-gray-500 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
        </div>

        <div class="border-t border-gray-200 p-4 flex gap-3">
            <button type="button" id="cancelDeleteBtn"
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition">
                Batal
            </button>
            <button type="button" id="confirmDeleteBtn"
                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    // Global modal state
    let currentDeleteForm = null;

    function openConfirmModal(userName, formId) {
        document.getElementById('confirmUserName').textContent = userName;
        currentDeleteForm = document.getElementById(formId);
        
        const modal = document.getElementById('confirmModal');
        const box = document.getElementById('modalBox');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        const box = document.getElementById('modalBox');
        
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            currentDeleteForm = null;
        }, 300);
    }

    document.getElementById('cancelDeleteBtn')?.addEventListener('click', closeConfirmModal);
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
        if (currentDeleteForm) {
            currentDeleteForm.submit();
        }
        closeConfirmModal();
    });

    // Tutup dengan klik luar atau Esc
    document.getElementById('confirmModal')?.addEventListener('click', e => {
        if (e.target === document.getElementById('confirmModal')) {
            closeConfirmModal();
        }
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && !document.getElementById('confirmModal').classList.contains('hidden')) {
            closeConfirmModal();
        }
    });
</script>