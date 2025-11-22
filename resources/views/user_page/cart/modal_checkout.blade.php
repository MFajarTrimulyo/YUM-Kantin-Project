<div id="checkout-modal" class="fixed inset-0 z-9999 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/75 transition-opacity backdrop-blur-sm" onclick="closeCheckoutModal()"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100">
                
                <div class="bg-yum-primary px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-white">Konfirmasi Pembayaran</h3>
                    <button onclick="closeCheckoutModal()" class="text-white/80 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('cart.checkout') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    
                    {{-- Info Rekening --}}
                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mb-6 text-center">
                        <p class="text-sm text-blue-600 mb-1">Silakan transfer sebesar:</p>
                        <p class="text-2xl font-bold text-blue-800 mb-3">Rp {{ number_format($total, 0, ',', '.') }}</p>
                        
                        <div class="bg-white p-3 rounded-lg border border-blue-100 inline-block w-full">
                            <p class="text-xs text-gray-500 uppercase font-bold">Bank BRI (Admin YUM)</p>
                            <p class="text-lg font-mono font-bold text-gray-800 tracking-wider">1234-5678-9012-3456</p>
                            <p class="text-xs text-gray-400 mt-1">a.n. YUM Official</p>
                        </div>
                    </div>

                    {{-- Input File --}}
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Bukti Transfer</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="bukti-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-sm text-gray-500"><span class="font-bold">Klik untuk upload</span></p>
                                    <p class="text-xs text-gray-400">JPG, PNG (Max 2MB)</p>
                                </div>
                                <input id="bukti-file" name="bukti_bayar" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" required />
                            </label>
                        </div>
                        
                        {{-- Preview Image --}}
                        <div id="image-preview-container" class="hidden mt-4 text-center">
                            <p class="text-xs text-gray-500 mb-2">Preview:</p>
                            <img id="image-preview" class="mx-auto h-32 rounded-lg border border-gray-200 object-cover">
                        </div>

                        @error('bukti_bayar')
                            <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-yum-primary text-white font-bold py-3 rounded-xl hover:bg-yum-dark transition shadow-lg">
                        Kirim Bukti & Selesaikan Pesanan
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>