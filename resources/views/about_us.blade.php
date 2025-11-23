@extends('layouts.user_layout')
@section('title', 'Tentang Kami')
@section('content')

{{-- Hero Section --}}
<div class="bg-white py-16 md:py-24">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <span class="text-yum-primary font-bold tracking-wider text-sm uppercase mb-2 block">Tentang YUM</span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                Solusi Cerdas <br> <span class="text-yum-yellow">Kantin Kampus</span>
            </h1>
            <p class="text-gray-600 text-lg leading-relaxed mb-8">
                YUM adalah platform digital yang dirancang khusus untuk mempermudah civitas akademika Universitas Negeri Malang dalam memesan makanan di kantin tanpa antri.
            </p>
            
            <div class="flex gap-4">
                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 w-1/2">
                    <h3 class="font-bold text-blue-800 text-xl mb-1">Cepat</h3>
                    <p class="text-sm text-blue-600">Pesan dari mana saja, ambil saat pesanan siap.</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 w-1/2">
                    <h3 class="font-bold text-yellow-800 text-xl mb-1">Praktis</h3>
                    <p class="text-sm text-yellow-600">Beragam pilihan menu kantin dalam satu genggaman.</p>
                </div>
            </div>
        </div>
        
        <div class="md:w-1/2 flex justify-center md:justify-end relative">
            <div class="absolute inset-0 bg-yum-primary/5 rounded-full filter blur-3xl transform translate-x-10 translate-y-10"></div>
            {{-- Ganti dengan gambar mascot atau ilustrasi team --}}
            <img src="{{ asset('pictures/happy-cakra.png') }}" alt="Tentang YUM" class="relative z-10 w-3/4 md:w-2/3 drop-shadow-2xl hover:scale-105 transition duration-500">
        </div>
    </div>
</div>

{{-- Developer Section --}}
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-12">Tim Pengembang</h2>
        <div class="grid grid-cols-3 gap-6">
            <!-- Developer Card -->
            <div class="max-w-sm mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:-translate-y-2 transition duration-300">
                <div class="h-32 bg-yum-primary relative">
                    <div class="absolute -bottom-12 left-0 right-0 flex justify-center">
                        <div class="w-24 h-24 bg-white p-1 rounded-full shadow-md">
                            {{-- Inisial Nama --}}
                            {{-- <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-2xl font-bold text-gray-500">
                                Z
                            </div> --}}
                            <img src="{{ asset('pictures/developer/zacky.jpg') }}" class="rounded-full w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="pt-16 pb-8 px-6">
                    <h3 class="text-xl font-bold text-gray-800">Muhammad Kharissah Ibnu Zacky</h3>
                    <p class="text-yum-primary font-medium text-sm mb-4">Mahasiswa Universitas Negeri Malang</p>
                    <p class="text-gray-500 text-sm">
                        S1 Pendidikan Teknik Informatika <br>
                        Departemen Teknik Elektro dan Informatika
                    </p>
                </div>
            </div>
            <div class="max-w-sm mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:-translate-y-2 transition duration-300">
                <div class="h-32 bg-yum-primary relative">
                    <div class="absolute -bottom-12 left-0 right-0 flex justify-center">
                        <div class="w-24 h-24 bg-white p-1 rounded-full shadow-md">
                            {{-- Inisial Nama --}}
                            {{-- <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-2xl font-bold text-gray-500">
                                M
                            </div> --}}
                            <img src="{{ asset('pictures/developer/fajar-web.jpg') }}" class="rounded-full w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <div class="pt-16 pb-8 px-6">
                    <h3 class="text-xl font-bold text-gray-800">Muhammad Fajar Tri Mulyo</h3>
                    <p class="text-yum-primary font-medium text-sm mb-4">Mahasiswa Universitas Negeri Malang</p>
                    <p class="text-gray-500 text-sm">
                        S1 Pendidikan Teknik Informatika <br>
                        Departemen Teknik Elektro dan Informatika
                    </p>
                </div>
            </div>
            <div class="max-w-sm mx-auto bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:-translate-y-2 transition duration-300">
                <div class="h-32 bg-yum-primary relative">
                    <div class="absolute -bottom-12 left-0 right-0 flex justify-center">
                        <div class="w-24 h-24 bg-white p-1 rounded-full shadow-md">
                            {{-- Inisial Nama --}}
                            <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-2xl font-bold text-gray-500">
                                L
                            </div>
                            {{-- Jika ada foto: <img src="..." class="rounded-full w-full h-full object-cover"> --}}
                        </div>
                    </div>
                </div>
                <div class="pt-16 pb-8 px-6">
                    <h3 class="text-xl font-bold text-gray-800">Luigy. M. C. Liem Saunoah</h3>
                    <p class="text-yum-primary font-medium text-sm mb-4">Mahasiswa Universitas Negeri Malang</p>
                    <p class="text-gray-500 text-sm">
                        S1 Pendidikan Teknik Informatika <br>
                        Departemen Teknik Elektro dan Informatika
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection