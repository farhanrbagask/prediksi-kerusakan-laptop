@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Profil Saya</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola informasi akun Anda</p>
    </div>

    <div class="grid grid-cols-1 gap-6">
        <!-- Update Profile Information -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
                <h2 class="text-lg font-bold text-white">Informasi Profil</h2>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600/40 to-purple-600/40 border-b border-white/20">
                <h2 class="text-lg font-bold text-white">Ubah Password</h2>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/20 shadow-xl">
            <div class="px-6 py-4 bg-gradient-to-r from-red-600/40 to-pink-600/40 border-b border-white/20">
                <h2 class="text-lg font-bold text-white">Hapus Akun</h2>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('dashboard') }}"
            class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors border border-gray-300">
            Kembali ke Dashboard
        </a>
    </div>
@endsection
