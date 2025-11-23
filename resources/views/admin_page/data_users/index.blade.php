@extends('layouts.admin_layout')
@section('title', 'Kelola Pengguna')
@section('content')

<div class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-lg font-bold text-gray-800">Daftar Pengguna</h2>
            <p class="text-xs text-gray-500">Kelola role dan akses pengguna sistem.</p>
        </div>

        {{-- Form Pencarian --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-yum-primary text-sm">
            <button type="submit" class="bg-yum-primary text-white px-4 py-2 rounded-r-lg hover:bg-yum-dark transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-100 text-green-600 px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-800 font-bold uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Pengguna</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    <th class="px-6 py-3">Bergabung</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    {{-- Nama & Foto --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 overflow-hidden">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-full object-cover">
                                @else
                                    {{ substr($user->nama, 0, 1) }}
                                @endif
                            </div>
                            <span class="font-bold text-gray-800">{{ $user->nama }}</span>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4">{{ $user->email }}</td>

                    {{-- Role Badge --}}
                    <td class="px-6 py-4">
                        @php
                            $roleColor = match($user->role) {
                                'admin' => 'bg-purple-100 text-purple-700',
                                'penjual' => 'bg-blue-100 text-blue-700',
                                default => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="{{ $roleColor }} px-2.5 py-0.5 rounded-full text-xs font-bold uppercase">
                            {{ $user->role }}
                        </span>
                    </td>

                    {{-- Tanggal Join --}}
                    <td class="px-6 py-4 text-xs">{{ $user->created_at->format('d M Y') }}</td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        @if($user->id !== Auth::id())
                            {{-- Tombol Edit Role --}}
                            <button onclick="openRoleModal('{{ $user->id }}', '{{ $user->nama }}', '{{ $user->role }}')" 
                                class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition" title="Ubah Role">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->nama }}? Semua data terkait (Gerai/Pesanan) akan ikut terhapus!')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400 italic">Akun Anda</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">User tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

{{-- MODAL EDIT ROLE --}}
<div id="role-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 transform transition-all scale-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Ubah Role Pengguna</h3>
        
        <p class="text-sm text-gray-600 mb-4">Mengubah role untuk: <span id="modal-user-name" class="font-bold text-yum-primary"></span></p>

        <form id="role-form" method="POST">
            @csrf @method('PATCH')
            
            <div class="space-y-2 mb-6">
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="role" value="user" class="text-yum-primary focus:ring-yum-primary">
                    <span class="ml-3 text-sm font-medium text-gray-700">User (Pembeli)</span>
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="role" value="penjual" class="text-yum-primary focus:ring-yum-primary">
                    <span class="ml-3 text-sm font-medium text-gray-700">Penjual</span>
                </label>
                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="role" value="admin" class="text-yum-primary focus:ring-yum-primary">
                    <span class="ml-3 text-sm font-medium text-gray-700">Admin</span>
                </label>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRoleModal()" class="px-4 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-lg transition">Batal</button>
                <button type="submit" class="bg-yum-primary text-white px-6 py-2 rounded-lg font-bold hover:bg-yum-dark transition shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRoleModal(id, name, role) {
        const modal = document.getElementById('role-modal');
        const form = document.getElementById('role-form');
        const nameSpan = document.getElementById('modal-user-name');
        
        // Set URL Form
        form.action = "/admin/users/" + id + "/role";
        
        // Set Nama User
        nameSpan.innerText = name;

        // Set Radio Button sesuai role saat ini
        const radios = document.getElementsByName('role');
        for (const radio of radios) {
            if (radio.value === role) {
                radio.checked = true;
            }
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRoleModal() {
        const modal = document.getElementById('role-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

@endsection