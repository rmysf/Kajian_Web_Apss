<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="darkreader-lock">

    <title>Daftar - KajianKu</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500;1,9..144,600&family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/swup@4"></script>
    
    <style>
        :root {
            --parchment: #F4EEDC;
            --parchment-deep: #E9DFC2;
            --paper: #FBF7EC;
            --ink: #152A20;
            --ink-soft: #4B5D52;
            --jade-950: #0A2B20;
            --jade-900: #0C3B2A;
            --jade-800: #0F5137;
            --gold: #B8863B;
            --gold-soft: #E7C77E;
            --gold-pale: #F3E3B8;
            --line: rgba(21,42,32,0.14);
        }
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        body {
            font-family: "Plus Jakarta Sans", ui-sans-serif, system-ui, sans-serif;
            color: var(--ink);
            background: var(--jade-950);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        a {
            color: inherit;
            text-decoration: none;
        }
        .container {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 28px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 26px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-solid {
            background: var(--jade-900);
            color: var(--parchment);
            box-shadow: 0 14px 30px rgba(10,43,32,0.28);
        }
        .btn-solid:hover {
            background: var(--jade-800);
        }
        .btn-outline {
            border-color: var(--gold);
            color: var(--ink);
            background: transparent;
        }
        .btn-outline:hover {
            background: var(--gold-pale);
        }

        .hero {
            position: relative;
            background: radial-gradient(900px 500px at 82% -10%, rgba(184,134,59,0.20), transparent 60%), linear-gradient(180deg, var(--jade-950) 0%, var(--jade-900) 55%, var(--jade-800) 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .hero-lattice {
            position: absolute;
            inset: 0;
            opacity: 0.16;
            pointer-events: none;
            width: 100%;
            height: 100%;
        }
        
        .login-input:focus {
            border-color: var(--gold) !important;
            box-shadow: 0 0 0 3px rgba(184,134,59, 0.15) !important;
        }


        .auth-wrapper {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: var(--parchment);
            border-radius: 32px;
            padding: 36px 48px;
            box-shadow: 0 40px 80px rgba(6,26,19,0.4);
            position: relative;
            z-index: 10;
            border: 1px solid rgba(231,199,126,0.3);
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .auth-card::-webkit-scrollbar {
            width: 8px;
        }
        .auth-card::-webkit-scrollbar-track {
            background: transparent;
            margin: 16px 0;
        }
        .auth-card::-webkit-scrollbar-thumb {
            background-color: var(--gold-soft);
            border-radius: 20px;
        }
        .auth-card::-webkit-scrollbar-thumb:hover {
            background-color: var(--gold);
        }
        
        @media (max-width: 576px) {
            .auth-card {
                padding: 32px 24px;
                border-radius: 28px;
            }
            .auth-wrapper {
                padding: 0 16px;
            }
        }

        /* Swup Transition Styles (No Animation) */
        html.is-animating .transition-fade {
            opacity: 1;
            transform: none;
        }
        .transition-fade {
            transition: none;
            opacity: 1;
            transform: none;
        }
    </style>
</head>
<body>

<main id="swup" class="transition-fade">
<header class="hero" style="position: relative; height: 100vh; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px 0; background: radial-gradient(900px 500px at 82% -10%, rgba(184,134,59,0.20), transparent 60%), linear-gradient(180deg, #0A2B20 0%, #0C3B2A 55%, #0F5137 100%); width: 100%;">
  <svg class="hero-lattice" viewBox="0 0 1180 700" preserveAspectRatio="xMidYMid slice" style="position: absolute; inset: 0; opacity: 0.16; pointer-events: none; width: 100%; height: 100%;">
    <defs>
      <pattern id="star8" width="86" height="86" patternUnits="userSpaceOnUse" patternTransform="rotate(15)">
        <g stroke="#E7C77E" stroke-width="1" fill="none">
          <path d="M43 4 L57 22 L79 22 L64 40 L79 58 L57 58 L43 78 L29 58 L7 58 L22 40 L7 22 L29 22 Z"/>
        </g>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#star8)"/>
  </svg>

  <div class="auth-wrapper" style="width: 100%; max-width: 520px; margin: 0 auto; padding: 0 20px; position: relative; z-index: 10;">
    
    <!-- Bagian Form Register -->
    <div class="auth-card" style="background: #F4EEDC !important; border-radius: 32px; padding: 36px 48px; box-shadow: 0 40px 80px rgba(6,26,19,0.4); position: relative; z-index: 10; border: 1px solid rgba(231,199,126,0.3); width: 100%;">
        
        <div style="text-align: left; margin-bottom: 12px;">
            <a href="{{ url('/') }}" style="display:inline-flex; align-items:center; gap:8px; font-size:12px; font-weight:700; color:var(--jade-900); text-transform:uppercase; letter-spacing:1px; transition:transform 0.2s; text-decoration:none;" onmouseover="this.style.transform='translateX(-5px)'" onmouseout="this.style.transform='translateX(0)'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        <div style="margin-bottom: 28px; text-align: center;">
            <div style="font-family:'Amiri',serif; font-size:24px; color:var(--gold); margin-bottom: 8px; font-weight:700;">
                أَهْلًا وَسَهْلًا
            </div>
            <div style="margin-bottom:8px;">
                <h1 style="font-family:'Fraunces',serif; font-size:32px; font-weight:700; margin:0; color:var(--jade-950);">Kajian<em style="color:var(--gold); font-style:normal;">Ku</em></h1>
            </div>
            <p style="color:var(--ink-soft); font-size:14px; margin:0;">Pendaftaran Penyelenggara Kajian</p>
        </div>

        <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:16px;">
            @csrf
            <input type="hidden" name="role" value="organizer">

            <!-- STEP 1 -->
            <div id="step-1" style="display:flex; flex-direction:column; gap:16px;">
                <!-- Name -->
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="name" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Nama Lengkap</label>
                    <div style="position:relative;">
                        <svg style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Fulan bin Fulan" class="login-input" style="width:100%; padding:12px 18px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;">
                    </div>
                    <x-input-error :messages="$errors->get('name')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <!-- Email Address -->
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="email" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Alamat Email</label>
                    <div style="position:relative;">
                        <svg style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" class="login-input" style="width:100%; padding:12px 18px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;" oninvalid="showEmailWarning(event)" oninput="hideEmailWarning()">
                    </div>
                    <span id="email-warning" style="display:none; margin-top:0px; color:#dc2626; font-size:12px;">Format email tidak valid (harus mengandung @ dan domain).</span>
                    <x-input-error :messages="$errors->get('email')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <!-- Password -->
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="password" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Kata Sandi</label>
                    <div style="position:relative;">
                        <svg style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="login-input" style="width:100%; padding:12px 42px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;">
                        <button type="button" onclick="togglePassword('password', 'eyeIcon1')" style="position:absolute; top:50%; right:16px; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--ink-soft); padding:0; display:flex; align-items:center; justify-content:center; transition:color 0.2s;" onmouseover="this.style.color='var(--jade-900)'" onmouseout="this.style.color='var(--ink-soft)'">
                            <svg id="eyeIcon1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <!-- Confirm Password -->
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="password_confirmation" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Konfirmasi Kata Sandi</label>
                    <div style="position:relative;">
                        <svg style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="login-input" style="width:100%; padding:12px 42px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;">
                        <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')" style="position:absolute; top:50%; right:16px; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--ink-soft); padding:0; display:flex; align-items:center; justify-content:center; transition:color 0.2s;" onmouseover="this.style.color='var(--jade-900)'" onmouseout="this.style.color='var(--ink-soft)'">
                            <svg id="eyeIcon2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <div style="margin-top:8px;">
                    <button type="button" onclick="goToStep2()" class="btn btn-solid" style="width:100%; justify-content:center; padding:14px; font-size:15px; border-radius:14px; background: var(--jade-900); color: var(--parchment); border: none; font-weight: 700; cursor: pointer; transition: background 0.2s, transform 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; box-shadow: 0 14px 30px rgba(10,43,32,0.28);">
                        Lanjutkan
                    </button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div id="step-2" style="display:none; flex-direction:column; gap:16px;">
                
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="phone" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Nomor Telepon / WhatsApp</label>
                    <div style="position:relative;">
                        <svg style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 08123456789" class="login-input" style="width:100%; padding:12px 18px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;" inputmode="numeric" pattern="^08[0-9]*$" oninput="this.value = this.value.replace(/[^0-9]/g, ''); hidePhoneWarning();" oninvalid="showPhoneWarning(event)">
                    </div>
                    <span id="phone-warning" style="display:none; margin-top:0px; color:#dc2626; font-size:12px;">Nomor telepon harus berupa angka dan diawali dengan 08.</span>
                    <x-input-error :messages="$errors->get('phone')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="address" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Alamat Pusat / Sekretariat</label>
                    <div style="position:relative;">
                        <textarea id="address" name="address" required placeholder="Alamat lengkap lembaga/komunitas" class="login-input" style="width:100%; padding:12px 18px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s; resize:none; overflow-y:auto; height:80px;">{{ old('address') }}</textarea>
                    </div>
                    <x-input-error :messages="$errors->get('address')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="description" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Deskripsi Lembaga (Opsional)</label>
                    <div style="position:relative;">
                        <textarea id="description" name="description" placeholder="Ceritakan singkat tentang lembaga Anda" class="login-input" style="width:100%; padding:12px 18px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s; resize:none; overflow-y:auto; height:80px;">{{ old('description') }}</textarea>
                    </div>
                    <x-input-error :messages="$errors->get('description')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label for="logo" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Logo Yayasan/Masjid (Opsional)</label>
                    <div style="position:relative;">
                        <div class="login-input" style="position:relative; display:flex; align-items:center; width:100%; border-radius:14px; border:1px solid var(--line); background:var(--paper); padding:8px 18px 8px 8px; font-family:inherit;">
                            <input id="logo" type="file" accept="image/*" name="logo" style="opacity:0; position:absolute; inset:0; width:100%; height:100%; cursor:pointer; z-index:2;" onchange="handleLogoChange(this)">
                            <div style="background:var(--gold-pale); border:1px solid var(--gold); color:var(--jade-950); padding:6px 14px; border-radius:8px; font-weight:700; font-size:13px; margin-right:12px; pointer-events:none; z-index:1; white-space:nowrap;">
                                Pilih File
                            </div>
                            <span id="fileName" style="font-size:14px; color:var(--ink-soft); pointer-events:none; z-index:1; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; padding-right:10px;">
                                Tidak ada file yang dipilih
                            </span>
                        </div>
                        <div style="font-size:11px; color:var(--ink-soft); margin-top:4px;">Format: JPG, PNG, WEBP. Maks 2MB.</div>
                    </div>
                    <span id="logo-warning" style="display:none; margin-top:0px; color:#dc2626; font-size:12px;">Ukuran file logo maksimal 2MB.</span>
                    <x-input-error :messages="$errors->get('logo')" style="margin-top:0px; color:#dc2626; font-size:12px;" />
                </div>

                <div style="margin-top:8px; display:flex; gap:12px;">
                    <button type="button" onclick="goToStep1()" class="btn btn-outline" style="flex:1; justify-content:center; padding:14px; font-size:15px; border-radius:14px; color: var(--jade-900); border: 1px solid var(--jade-900); font-weight: 700; cursor: pointer; transition: background 0.2s;">
                        Kembali
                    </button>
                    <button type="submit" class="btn btn-solid" style="flex:2; justify-content:center; padding:14px; font-size:15px; border-radius:14px; background: var(--jade-900); color: var(--parchment); border: none; font-weight: 700; cursor: pointer; transition: background 0.2s, transform 0.2s, box-shadow 0.2s; box-shadow: 0 14px 30px rgba(10,43,32,0.28);">
                        Daftar Sekarang
                    </button>
                </div>
            </div>
        </form>

        <div style="margin-top:20px; text-align:center; font-size:13px; font-weight:500; color:var(--ink-soft);">
            Sudah punya akun? <a href="{{ route('login') }}" style="font-weight:700; color:var(--jade-900); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--jade-900)'">Masuk di sini</a> &nbsp;|&nbsp; 
            Ingin mendaftar sebagai jamaah? <a href="{{ route('register') }}" style="font-weight:700; color:var(--jade-900); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--jade-900)'">Klik di sini</a>
        </div>
    </div>



  </div>
</header>
<script>
function togglePassword(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
}

function goToStep2() {
    // Validate Step 1 first
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const pwdInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    
    if (!nameInput.checkValidity() || !emailInput.checkValidity() || !pwdInput.checkValidity() || !confirmInput.checkValidity()) {
        document.getElementById('registerForm').reportValidity();
        return;
    }

    document.getElementById('step-1').style.display = 'none';
    document.getElementById('step-2').style.display = 'flex';
}

function goToStep1() {
    document.getElementById('step-2').style.display = 'none';
    document.getElementById('step-1').style.display = 'flex';
}

// Auto-open step 2 if there are validation errors in step 2 fields
document.addEventListener('DOMContentLoaded', function() {
    const hasStep2Errors = {{ $errors->hasAny(['phone', 'address', 'description', 'logo']) ? 'true' : 'false' }};
    if (hasStep2Errors) {
        goToStep2();
    }
});

function showEmailWarning(e) {
    e.preventDefault();
    document.getElementById('email-warning').style.display = 'block';
    document.getElementById('email').style.borderColor = '#dc2626';
}

function hideEmailWarning() {
    document.getElementById('email-warning').style.display = 'none';
    document.getElementById('email').style.borderColor = 'var(--line)';
}

function showPhoneWarning(e) {
    e.preventDefault();
    document.getElementById('phone-warning').style.display = 'block';
    document.getElementById('phone').style.borderColor = '#dc2626';
}

function hidePhoneWarning() {
    document.getElementById('phone-warning').style.display = 'none';
    document.getElementById('phone').style.borderColor = 'var(--line)';
}

function handleLogoChange(input) {
    var warning = document.getElementById('logo-warning');
    var fileNameSpan = document.getElementById('fileName');
    
    if (input.files.length > 0) {
        if (input.files[0].size > 2 * 1024 * 1024) {
            warning.style.display = 'block';
            input.value = ''; // Reset file
            fileNameSpan.textContent = 'Tidak ada file yang dipilih';
            fileNameSpan.style.color = '#dc2626';
        } else {
            warning.style.display = 'none';
            fileNameSpan.textContent = input.files[0].name;
            fileNameSpan.style.color = 'var(--ink-soft)';
        }
    } else {
        warning.style.display = 'none';
        fileNameSpan.textContent = 'Tidak ada file yang dipilih';
        fileNameSpan.style.color = 'var(--ink-soft)';
    }
}
</script>
</main>
<script>
    const swup = new Swup();
</script>
</body>
</html>
