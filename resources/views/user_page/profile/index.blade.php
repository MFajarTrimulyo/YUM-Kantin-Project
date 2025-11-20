@extends('layouts.user_layout')
@section('content')

<div class="container mx-auto px-6 py-12">
    
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-800">Pengaturan Profil</h1>
            <p class="text-gray-500 mt-1">Kelola informasi akun dan keamananmu di sini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Left Column: Profile Card -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <div class="w-24 h-24 bg-yum-primary/10 rounded-full flex items-center justify-center text-yum-primary text-4xl font-bold mx-auto mb-4">
                        @if($user->photo == null)
                            {{ substr($user->nama, 0, 1) }}
                        @else
                            <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover rounded-full">
                        @endif
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->nama }}</h2>
                    <p class="text-sm text-gray-500 mb-4">{{ '@' . $user->username }}</p>
                    
                    <div class="w-full bg-gray-50 rounded-lg p-3 mb-2">
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Status</p>
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                            @if($user->role === 'admin')
                                Admin
                            @elseif($user->role === 'petugas')
                                Petugas
                            @else
                                User
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <!-- Right Column: Edit Form -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                    
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update', ['username' => $user->username]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-8 flex flex-col items-center md:flex-row md:items-start gap-6">
                            <!-- Upload Input -->
                            <div class="flex-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil</label>
                                <input type="file" name="photo" accept="image/*"
                                    class="block w-full text-sm text-gray-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-yum-primary/10 file:text-yum-primary
                                            hover:file:bg-yum-primary/20 cursor-pointer">
                                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, JPEG. Max: 2MB.</p>
                                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Section: Personal Info -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Pribadi</h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <!-- Nama -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" 
                                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none @error('nama') border-red-500 @enderror">
                                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Username -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold">@</span>
                                        <input type="text" name="username" value="{{ old('username', $user->username) }}" 
                                            class="w-full pl-10 pr-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none @error('username') border-red-500 @enderror">
                                    </div>
                                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none @error('email') border-red-500 @enderror">
                                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Change Password -->
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Ganti Password</h3>
                            <p class="text-xs text-gray-400 mb-4">Kosongkan jika tidak ingin mengubah password.</p>

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">Password Saat Ini</label>
                                    <input type="password" name="current_password" placeholder="********"
                                        class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none @error('current_password') border-red-500 @enderror">
                                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-2">Password Baru</label>
                                        <input type="password" name="new_password" placeholder="Minimal 8 karakter"
                                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none @error('new_password') border-red-500 @enderror">
                                        @error('new_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 mb-2">Konfirmasi Password Baru</label>
                                        <input type="password" name="new_password_confirmation" placeholder="Ulangi password baru"
                                            class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-yum-primary focus:ring-2 focus:ring-yum-primary/20 focus:bg-white transition outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end items-center gap-4 pt-4">
                            <button type="reset" class="px-6 py-2.5 rounded-lg text-gray-500 font-bold hover:bg-gray-100 transition">
                                Batal
                            </button>
                            <button type="submit" class="bg-yum-primary text-white px-8 py-2.5 rounded-lg font-bold shadow-md hover:bg-yum-dark hover:shadow-lg transition transform hover:-translate-y-0.5">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection