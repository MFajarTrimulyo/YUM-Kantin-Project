<div id="modal-bukti" class="fixed inset-0 z-9999 hidden items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeBukti()">
    <div class="relative max-w-lg w-full p-4 transform transition-all scale-100">
        <button onclick="closeBukti()" class="absolute -top-2 -right-2 bg-white rounded-full p-2 text-gray-800 hover:bg-gray-200 shadow-lg z-10 border border-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        
        <img id="img-bukti" src="" class="w-full h-auto max-h-[80vh] object-contain rounded-lg shadow-2xl border border-white/20 bg-black">
        <p class="text-center text-white/80 mt-2 text-sm font-medium">Bukti Pembayaran Pembeli</p>
    </div>
</div>

<script>
    function showBukti(url) {
        document.getElementById('img-bukti').src = url;
        const modal = document.getElementById('modal-bukti');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBukti() {
        const modal = document.getElementById('modal-bukti');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
