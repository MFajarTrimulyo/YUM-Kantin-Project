{{-- CART MODAL (Hidden by default) --}}
<div id="cart-modal" class="fixed inset-0 z-9999 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    <!-- Backdrop (Gelap) -->
    <div class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm" onclick="closeCartModal()"></div>

    <!-- Modal Panel -->
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                
                <!-- Tombol Close -->
                <button onclick="closeCartModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10 bg-white/80 rounded-full p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Form -->
                <form id="cart-form" method="POST" action="">
                    @csrf
                    
                    <div class="bg-white">
                        <!-- Gambar Produk (Header) -->
                        <div class="relative h-48 w-full bg-gray-100">
                            <img id="modal-img" src="" class="h-full w-full object-cover" onerror="this.style.display='none'">
                            <div id="modal-no-img" class="hidden absolute inset-0 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            
                            <!-- Badge Diskon -->
                            <span id="modal-badge-promo" class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-sm hidden">
                                Promo Hemat
                            </span>
                        </div>

                        <div class="p-6">
                            <!-- Detail Produk -->
                            <div class="mb-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 id="modal-gerai" class="text-xs font-bold text-yum-primary uppercase tracking-wide mb-1">Nama Gerai</h3>
                                        <h2 id="modal-nama" class="text-xl font-bold text-gray-900 leading-tight">Nama Produk</h2>
                                    </div>
                                    <div class="text-right">
                                        <p id="modal-harga-coret" class="text-xs text-gray-400 line-through hidden">Rp 0</p>
                                        <p id="modal-harga" class="text-lg font-bold text-yum-primary">Rp 0</p>
                                    </div>
                                </div>
                                
                                <!-- Stok Info -->
                                <p id="modal-stok" class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Stok Tersedia
                                </p>
                            </div>

                            {{-- Rasa / Varian --}}
                            <div id="modal-rasa-container" class="mb-6 hidden">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Varian / Rasa</label>
                                <div id="modal-rasa-options" class="flex flex-wrap gap-2">
                                </div>
                            </div>

                            <!-- Counter Qty -->
                            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-xl border border-gray-100 mb-4">
                                <span class="font-bold text-gray-700 text-sm">Jumlah Pesanan</span>
                                <div class="flex items-center gap-4">
                                    <button type="button" onclick="updateQty(-1)" class="w-8 h-8 rounded-full bg-white border border-gray-300 text-gray-600 hover:bg-yum-primary hover:text-white hover:border-yum-primary transition flex items-center justify-center font-bold">-</button>
                                    <input type="number" name="qty" id="modal-qty" value="1" min="1" class="w-fit pl-4 text-center bg-transparent font-bold text-gray-800 focus:outline-none" readonly>
                                    <button type="button" onclick="updateQty(1)" class="w-8 h-8 rounded-full bg-white border border-gray-300 text-gray-600 hover:bg-yum-primary hover:text-white hover:border-yum-primary transition flex items-center justify-center font-bold">+</button>
                                </div>
                            </div>

                            <!-- Catatan (Optional) -->
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="note" rows="2" class="w-full rounded-lg border-gray-300 border bg-white px-3 py-2 text-sm focus:border-yum-primary focus:ring-yum-primary" placeholder="Contoh: Jangan pedas, karetnya dua..."></textarea>
                            </div>

                            <!-- Action Button -->
                            <div class="flex gap-3">
                                <button type="button" onclick="closeCartModal()" class="flex-1 bg-white border border-gray-300 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition">
                                    Batal
                                </button>
                                <button type="submit" class="flex-2 bg-yum-primary text-white font-bold py-3 rounded-xl hover:bg-yum-dark shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('cart-modal');
    const qtyInput = document.getElementById('modal-qty');
    const form = document.getElementById('cart-form');

    // Element Rasa
    const rasaContainer = document.getElementById('modal-rasa-container');
    const rasaOptions = document.getElementById('modal-rasa-options');

    function openCartModal(product) {
        // 1. Set Action URL Form
        form.action = "/cart/add/" + product.id; 

        // 2. Isi Data Modal
        document.getElementById('modal-nama').innerText = product.nama;
        document.getElementById('modal-gerai').innerText = product.gerai;
        document.getElementById('modal-stok').innerText = "Sisa Stok: " + product.stok;
        
        // 3. Handle Gambar
        const img = document.getElementById('modal-img');
        const noImg = document.getElementById('modal-no-img');
        if(product.photo) {
            img.src = product.photo;
            img.style.display = 'block';
            noImg.classList.add('hidden');
        } else {
            img.style.display = 'none';
            noImg.classList.remove('hidden');
        }

        // 4. Handle Harga & Diskon
        const elHarga = document.getElementById('modal-harga');
        const elCoret = document.getElementById('modal-harga-coret');
        const elBadge = document.getElementById('modal-badge-promo');

        // Format Rupiah
        const formatRp = (num) => "Rp " + new Intl.NumberFormat('id-ID').format(num);

        if(product.diskon > 0) {
            elHarga.innerText = formatRp(product.harga);
            elHarga.classList.add('text-red-500');
            
            elCoret.innerText = formatRp(product.harga_asli);
            elCoret.classList.remove('hidden');
            elBadge.classList.remove('hidden');
        } else {
            elHarga.innerText = formatRp(product.harga);
            elHarga.classList.remove('text-red-500');
            
            elCoret.classList.add('hidden');
            elBadge.classList.add('hidden');
        }

        rasaOptions.innerHTML = ''; // Reset opsi lama
        
        if (product.rasa && product.rasa.trim() !== "") {
            rasaContainer.classList.remove('hidden');
            
            // Pecah string "Coklat, Keju" menjadi array
            const variants = product.rasa.split(',');

            variants.forEach((variant, index) => {
                variant = variant.trim(); // Hapus spasi
                
                // Wrapper Div
                const wrapper = document.createElement('div');
                
                // Input Radio (Hidden)
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'rasa'; // Name harus sama agar cuma bisa pilih 1
                radio.value = variant;
                radio.id = 'rasa-' + index;
                radio.className = 'peer sr-only'; // Sembunyikan dot radio asli
                
                // Auto-select opsi pertama
                if(index === 0) radio.checked = true; 

                // Label (Tampilan Tombol Pill Shape)
                const label = document.createElement('label');
                label.htmlFor = 'rasa-' + index;
                
                // Class CSS Updated: Rounded-full, Border-2, Solid Color on Checked
                label.className = `
                    cursor-pointer 
                    px-6 py-2 
                    rounded-full 
                    border-2 border-gray-200 
                    bg-white 
                    text-sm font-bold text-gray-500 
                    transition select-none
                    hover:border-yum-primary hover:text-yum-primary
                    peer-checked:bg-yum-primary peer-checked:text-white peer-checked:border-yum-primary
                    peer-checked:shadow-md
                `;
                
                label.innerText = variant;

                wrapper.appendChild(radio);
                wrapper.appendChild(label);
                rasaOptions.appendChild(wrapper);
            });

        } else {
            // Sembunyikan container jika produk tidak punya varian
            rasaContainer.classList.add('hidden');
        }

        // 5. Reset Qty
        qtyInput.value = 1;

        // 6. Tampilkan Modal
        modal.classList.remove('hidden');
    }

    function closeCartModal() {
        modal.classList.add('hidden');
    }

    function updateQty(change) {
        let newVal = parseInt(qtyInput.value) + change;
        if(newVal < 1) newVal = 1;
        // Opsional: Batasi max sesuai stok
        
        qtyInput.value = newVal;
    }

    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert("Nomor rekening berhasil disalin!");
        });
    }
</script>