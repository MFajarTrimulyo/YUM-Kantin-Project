@extends('layouts.auth_layout')
@section('content')
<h2 class="text-center font-bold text-xl mb-8 tracking-widest text-gray-800">REGISTER</h2>

<form action="{{ route('register.post') }}" method="POST">
    @csrf
    
    <div class="mb-5">
        <input type="text" name="nama" placeholder="Full Name" 
                class="w-full border border-gray-300 bg-gray-50 px-4 py-3 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
        @error('nama')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
    

    <div class="mb-5">
        <input type="text" name="username" placeholder="Username" 
                class="w-full border border-gray-300 bg-gray-50 px-4 py-3 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
        @error('username')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <input type="email" name="email" placeholder="Email" 
                class="w-full border border-gray-300 bg-gray-50 px-4 py-3 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <input type="password" name="password" placeholder="Password" 
                class="w-full border border-gray-300 bg-gray-50 px-4 py-3 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <input type="password" name="password_confirmation" placeholder="Confirm Password" 
                class="w-full border border-gray-300 bg-gray-50 px-4 py-3 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
    </div>

    <button type="submit" class="w-full bg-yum-primary text-white font-bold py-3 hover:bg-blue-700 active:translate-y-0.5 transition duration-200 rounded-sm shadow-md">
        REGISTER
    </button>
</form>

<div class="mt-6 text-center text-xs text-gray-500">
    Already have an account? <a href="{{ route('login') }}" class="font-bold text-gray-900 hover:text-yum-primary hover:underline ml-1">Login</a>
</div>
@endsection