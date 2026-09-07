<x-admin-layout>
    <x-slot name="header">
        Tambah Pengguna Baru
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-brand-ink">Tambah Pengguna</h2>
            <a href="{{ route('admin.user.index') }}" class="inline-flex items-center text-sm font-medium text-brand-ink-soft hover:text-brand-emerald-900 transition">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i> Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-brand-ink mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm" required placeholder="Masukkan nama pengguna">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-bold text-brand-ink mb-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm" required placeholder="contoh@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Peran (Role) -->
                        <div>
                            <label for="role" class="block text-sm font-bold text-brand-ink mb-1">Peran (Role) <span class="text-red-500">*</span></label>
                            <select id="role" name="role" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-emerald-500 focus:ring-brand-emerald-500">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Jamaah Biasa)</option>
                                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer (Penyelenggara Kajian)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Sistem)</option>
                            </select>
                            <p class="mt-2 text-xs text-gray-500">
                                <i data-lucide="info" class="w-3 h-3 inline mr-1"></i> Jika Anda memilih Organizer, sistem akan otomatis membuat profil penyelenggara untuk pengguna ini.
                            </p>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ showPassword: false, showPasswordConfirmation: false }">
                            <div>
                                <label for="password" class="block text-sm font-bold text-brand-ink mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" name="password" id="password" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm pr-10" required placeholder="Minimal 8 karakter">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i data-lucide="eye" class="w-5 h-5" x-show="!showPassword"></i>
                                        <i data-lucide="eye-off" class="w-5 h-5" x-show="showPassword" x-cloak></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-brand-ink mb-1">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showPasswordConfirmation ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-brand-emerald-500 focus:ring-brand-emerald-500 shadow-sm pr-10" required placeholder="Ketik ulang kata sandi">
                                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <i data-lucide="eye" class="w-5 h-5" x-show="!showPasswordConfirmation"></i>
                                        <i data-lucide="eye-off" class="w-5 h-5" x-show="showPasswordConfirmation" x-cloak></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-2 border border-transparent text-sm font-bold rounded-lg text-white bg-brand-emerald-900 hover:bg-brand-emerald-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
