@extends('layouts.landing')

@section('content')
<div class="container" style="padding-top: 40px; padding-bottom: 60px; min-height: 70vh; max-width: 800px;">

    <!-- Header & Logout -->
    <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 40px; border-bottom: 1px solid var(--line); padding-bottom: 24px;">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h2 style="font-family: 'Fraunces', serif; font-size: 32px; font-weight: 700; color: var(--jade-950); margin: 0 0 8px;">
                    Pengaturan <em style="color: var(--gold); font-style: italic;">Akun</em>
                </h2>
                <p style="color: var(--ink-soft); font-size: 15px; margin: 0;">
                    Kelola informasi profil, kata sandi, dan preferensi akun Anda.
                </p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline" style="border-color: #dc2626; color: #dc2626; padding: 10px 20px;">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 32px;">

        <!-- 1. Informasi Profil -->
        <div style="background: var(--paper); border: 1px solid var(--line); border-radius: 24px; padding: 32px; box-shadow: var(--shadow);">
            <h3 style="font-family: 'Fraunces', serif; font-size: 24px; color: var(--jade-950); margin: 0 0 8px;">Informasi Profil</h3>
            <p style="color: var(--ink-soft); font-size: 14px; margin: 0 0 24px;">Perbarui nama dan alamat email akun Anda.</p>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                @method('patch')

                <!-- Name -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="name" style="font-size: 13px; font-weight: 700; color: var(--jade-950);">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; color: var(--ink); font-family: inherit; font-size: 14px; outline: none;">
                    <x-input-error class="mt-2" :messages="$errors->get('name')" style="color:#dc2626; font-size:12px;" />
                </div>

                <!-- Email -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="email" style="font-size: 13px; font-weight: 700; color: var(--jade-950);">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; color: var(--ink); font-family: inherit; font-size: 14px; outline: none;">
                    <x-input-error class="mt-2" :messages="$errors->get('email')" style="color:#dc2626; font-size:12px;" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div style="margin-top: 12px;">
                            <p style="font-size: 13px; color: var(--ink-soft);">
                                Email Anda belum diverifikasi.
                                <button form="send-verification" style="background: none; border: none; padding: 0; color: var(--gold); font-weight: 600; cursor: pointer; text-decoration: underline;">
                                    Klik di sini untuk mengirim ulang email verifikasi.
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p style="margin-top: 8px; font-size: 13px; color: #16a34a; font-weight: 600;">
                                    Tautan verifikasi baru telah dikirim ke email Anda.
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div style="display: flex; align-items: center; gap: 16px; margin-top: 8px;">
                    <button type="submit" class="btn btn-solid" style="padding: 12px 24px;">Simpan Perubahan</button>
                    @if (session('status') === 'profile-updated')
                        <p style="font-size: 13px; color: #16a34a; font-weight: 600; margin: 0;">✓ Tersimpan.</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- 2. Ubah Kata Sandi -->
        <div style="background: var(--paper); border: 1px solid var(--line); border-radius: 24px; padding: 32px; box-shadow: var(--shadow);">
            <h3 style="font-family: 'Fraunces', serif; font-size: 24px; color: var(--jade-950); margin: 0 0 8px;">Ubah Kata Sandi</h3>
            <p style="color: var(--ink-soft); font-size: 14px; margin: 0 0 24px;">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>

            <form method="post" action="{{ route('password.update') }}" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="update_password_current_password" style="font-size: 13px; font-weight: 700; color: var(--jade-950);">Kata Sandi Saat Ini</label>
                    <div style="position: relative; width: 100%;">
                        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" style="width: 100%; padding: 12px 48px 12px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; color: var(--ink); font-family: inherit; font-size: 14px; outline: none;">
                        <button type="button" onclick="togglePassword('update_password_current_password', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; color: var(--ink-soft);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-slash-icon" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" style="color:#dc2626; font-size:12px; margin-top: 4px;" />
                </div>

                <!-- New Password -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="update_password_password" style="font-size: 13px; font-weight: 700; color: var(--jade-950);">Kata Sandi Baru</label>
                    <div style="position: relative; width: 100%;">
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password" style="width: 100%; padding: 12px 48px 12px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; color: var(--ink); font-family: inherit; font-size: 14px; outline: none;">
                        <button type="button" onclick="togglePassword('update_password_password', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; color: var(--ink-soft);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-slash-icon" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password')" style="color:#dc2626; font-size:12px; margin-top: 4px;" />
                </div>

                <!-- Confirm Password -->
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="update_password_password_confirmation" style="font-size: 13px; font-weight: 700; color: var(--jade-950);">Konfirmasi Kata Sandi</label>
                    <div style="position: relative; width: 100%;">
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" style="width: 100%; padding: 12px 48px 12px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; color: var(--ink); font-family: inherit; font-size: 14px; outline: none;">
                        <button type="button" onclick="togglePassword('update_password_password_confirmation', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; color: var(--ink-soft);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-slash-icon" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" style="color:#dc2626; font-size:12px; margin-top: 4px;" />
                </div>

                <div style="display: flex; align-items: center; gap: 16px; margin-top: 8px;">
                    <button type="submit" class="btn btn-solid" style="padding: 12px 24px;">Perbarui Sandi</button>
                    @if (session('status') === 'password-updated')
                        <p style="font-size: 13px; color: #16a34a; font-weight: 600; margin: 0;">✓ Sandi Diperbarui.</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- 3. Hapus Akun -->
        <div style="background: #fff0f0; border: 1px solid #fecaca; border-radius: 24px; padding: 32px; box-shadow: var(--shadow);">
            <h3 style="font-family: 'Fraunces', serif; font-size: 24px; color: #991b1b; margin: 0 0 8px;">Hapus Akun</h3>
            <p style="color: #7f1d1d; font-size: 14px; margin: 0 0 24px;">
                Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
            </p>

            <button type="button" onclick="document.getElementById('delete-account-modal').style.display = 'flex'" class="btn" style="background: #dc2626; color: white; padding: 12px 24px;">
                Hapus Akun Saya
            </button>
        </div>

    </div>

    <!-- Modal Hapus Akun -->
    <div id="delete-account-modal" style="display: {{ $errors->userDeletion->isNotEmpty() ? 'flex' : 'none' }}; position: fixed; inset: 0; background: rgba(10,43,32,0.6); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: var(--parchment); border-radius: 24px; padding: 32px; max-width: 500px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
            <h2 style="font-family: 'Fraunces', serif; font-size: 24px; color: var(--jade-950); margin: 0 0 12px;">Apakah Anda yakin ingin menghapus akun?</h2>
            <p style="color: var(--ink-soft); font-size: 14px; margin: 0 0 24px; line-height: 1.6;">
                Setelah dihapus, semua data Anda akan hilang permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" style="display: flex; flex-direction: column; gap: 16px;">
                @csrf
                @method('delete')

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label for="password" style="font-size: 13px; font-weight: 700; color: var(--jade-950);">Kata Sandi</label>
                    <div style="position: relative; width: 100%;">
                        <input id="password" name="password" type="password" placeholder="Masukkan sandi Anda" style="width: 100%; padding: 12px 48px 12px 16px; border-radius: 12px; border: 1px solid var(--line); background: #fff; color: var(--ink); font-family: inherit; font-size: 14px; outline: none;">
                        <button type="button" onclick="togglePassword('password', this)" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); background: none; border: none; padding: 0; cursor: pointer; color: var(--ink-soft);">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="eye-slash-icon" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->userDeletion->get('password')" style="color:#dc2626; font-size:12px; margin-top: 4px;" />
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 16px;">
                    <button type="button" onclick="document.getElementById('delete-account-modal').style.display = 'none'" class="btn btn-outline" style="padding: 10px 20px;">
                        Batal
                    </button>
                    <button type="submit" class="btn" style="background: #dc2626; color: white; padding: 10px 20px;">
                        Ya, Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const eyeIcon = button.querySelector('.eye-icon');
        const eyeSlashIcon = button.querySelector('.eye-slash-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.style.display = 'none';
            eyeSlashIcon.style.display = 'block';
        } else {
            input.type = 'password';
            eyeIcon.style.display = 'block';
            eyeSlashIcon.style.display = 'none';
        }
    }
</script>
@endsection
