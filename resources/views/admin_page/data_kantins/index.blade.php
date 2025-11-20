@extends('layouts.admin_layout')
@section('title', 'Kelola Kantin')
@section('content')

<div class="bg-white rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] border border-gray-100 p-6">
    
    <div class="flex justify-end items-center gap-4 mb-6">
        <a href="{{ route('kantins.create') }}" class="bg-yum-primary text-sm text-white px-6 py-2 rounded-lg font-semibold hover:bg-yum-dark transition flex items-center shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kantin
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="px-4 py-3 font-semibold rounded-tl-lg">ID</th>
                    <th class="px-4 py-3 font-semibold">Nama Kantin</th>
                    <th class="px-4 py-3 font-semibold text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                
                @foreach($kantins as $kantin)
                <tr class="hover:bg-gray-50/50 transition group">
                    <td class="px-4 py-3">{{ $kantin->id }}</td>
                    <td class="px-4 py-3">{{ $kantin->nama}}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('kantins.edit', $kantin->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('kantins.destroy', $kantin->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="confirm('Hapus menu ini?')" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $kantins->links() }}
    </div>
</div>

@endsection