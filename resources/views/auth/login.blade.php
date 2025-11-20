@extends('layouts.auth_layout')
@section('content')
<h2 class="text-center font-bold text-xl mb-8 tracking-widest text-gray-800">LOG IN</h2>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('login.post') }}" method="POST">
    @csrf
    
    <div class="mb-5">
        <input type="text" name="login" placeholder="Username/Email" 
                class="w-full border border-gray-300 bg-gray-50 px-4 py-3 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
    </div>
    
    <div class="mb-5 relative">
        <input id="password-input" type="password" name="password" placeholder="Password" 
                class="w-full border border-gray-300 bg-gray-50 px-4 py-3 pr-10 focus:outline-none focus:border-yum-primary focus:ring-1 focus:ring-yum-primary placeholder-gray-400 text-sm transition-colors">
        
        <!-- Tombol Ikon Mata -->
        <button type="button" id="password-toggle" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-yum-primary">
            <!-- Ikon Mata (Buka) -->
            <svg id="eye-icon" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 10.224 5.92 7 12 7s8.577 3.224 9.964 4.683c.214.212.214.563 0 .775C20.577 13.776 18.08 17 12 17s-8.577-3.224-9.964-4.683Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            <!-- Ikon Mata (Tutup) -->
            <svg id="eye-slash-icon" class="h-5 w-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 14.334 6.21 17 12 17c2.13 0 4.09-.746 5.67-1.99M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 0 1-4.74-4.74m4.74 4.74-2.489-2.489M9.75 9.75l-2.489-2.489M21 12c-1.29 2.334-4.276 5-9 5s-7.71-2.666-9.066-5c-.212-.38-.212-.832 0-1.212C3.226 9.666 6.214 7 12 7c2.13 0 4.09.746 5.67 1.99" />
            </svg>
        </button>
    </div>

    <div class="flex justify-between items-center text-xs text-gray-600 mb-8">
        <label class="flex items-center cursor-pointer hover:text-yum-primary">
            <input type="checkbox" name="remember" class="mr-2 rounded text-yum-primary focus:ring-yum-primary"> Remember Me
        </label>
        <a href="/forgot-password" class="hover:text-yum-primary hover:underline transition">Forgot your Password?</a>
    </div>

    <button type="submit" class="w-full bg-yum-primary text-white font-bold py-3 hover:bg-blue-700 active:translate-y-0.5 transition duration-200 rounded-sm shadow-md">
        LOGIN
    </button>
</form>

<div class="mt-6 text-center text-xs text-gray-500">
    Don't have an account? <a href="{{ route('register') }}" class="font-bold text-gray-900 hover:text-yum-primary hover:underline ml-1">Register</a>
</div>
@endsection