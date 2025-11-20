@extends('layouts.user_layout')
@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        {{-- Icon Jam / Menunggu --}}
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-yellow-100 mb-6">
            <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h2 class="text-3xl font-extrabold text-gray-900">
            Menunggu Verifikasi
        </h2>
        <p class="mt-2 text-md text-gray-600">
            Data Gerai <strong>{{ Auth::user()->gerai->nama ?? 'Anda' }}</strong> sudah kami terima.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border-t-4 border-yum-primary">
            <div class="space-y-6">
                <p class="text-gray-700 text-center">
                    Admin kami sedang memverifikasi data pendaftaran gerai anda. Proses ini biasanya memakan waktu <strong>1x24 Jam</strong>.
                </p>
                
                <div class="bg-blue-50 p-4 rounded-md">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Silakan cek halaman ini secara berkala. Anda akan otomatis diarahkan ke Dashboard setelah disetujui.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="/" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-yum-primary bg-yum-primary/10 hover:bg-yum-primary/20">
                        Kembali ke Beranda
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection