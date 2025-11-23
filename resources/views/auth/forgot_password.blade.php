@extends('layouts.auth_layout')
@section('content')

<h2 class="text-center font-bold text-xl mb-2 tracking-widest text-gray-800">LUPA PASSWORD</h2>
<p class="text-center text-xs text-gray-500 mb-8">
    Masukkan email yang terdaftar.
</p>

{{-- Alert Status (Sukses Kirim Email) --}}
@if (session('status'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm">
        {{ session('status') }}
    </div>
@endif

{{-- Alert Error --}}
@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('password.email') }}" method="POST">
    @csrf
    
    <div class="mb-6">
        <input type="email" name="email" placeholder="Masukkan Alamat Email" value="{{ old('email') }}"
            class="w-full border border-gray-300 bg-gray-50 px-4 py-3 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
    </div>

    <button type="submit" class="w-full bg-yum-primary text-white font-bold py-3 hover:bg-blue-700 active:translate-y-0.5 transition duration-200 rounded-sm shadow-md uppercase text-sm tracking-wide">
        Kirim Link Reset
    </button>
</form>

<div class="mt-6 text-center text-xs text-gray-500">
    Sudah ingat password? <a href="{{ route('login') }}" class="font-bold text-gray-900 hover:text-yum-primary hover:underline ml-1">Login Kembali</a>
</div>

@endsection