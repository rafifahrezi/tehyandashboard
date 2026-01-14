<div
    x-data
    x-show="$store.confirm.show"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>
    <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg">
        <h2 class="text-lg font-semibold text-gray-900"
            x-text="$store.confirm.title"></h2>

        <p class="mt-2 text-gray-600"
            x-text="$store.confirm.message"></p>

        <div class="mt-6 flex justify-end gap-2">
            <button
                type="button"
                @click="$store.confirm.close()"
                class="px-4 py-2 rounded-lg border text-gray-700">
                Batal
            </button>

            <button
                type="button"
                @click="$store.confirm.confirm()"
                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Hapus
            </button>
        </div>
    </div>
</div>
