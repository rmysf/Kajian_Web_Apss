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
    </style>
</head>
<body>

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

        <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:16px;">
            @csrf
            <input type="hidden" name="role" value="organizer">

            <!-- Name -->
            <div style="display:flex; flex-direction:column; gap:6px;">
                <label for="name" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Nama Lengkap</label>
                <div style="position:relative;">
                    <svg style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Fulan bin Fulan" class="login-input" style="width:100%; padding:12px 18px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;">
                    <x-input-error :messages="$errors->get('name')" style="margin-top:4px; color:#dc2626; font-size:12px;" />
                </div>
            </div>

            <!-- Email Address -->
            <div style="display:flex; flex-direction:column; gap:6px;">
                <label for="email" style="font-size:13px; font-weight:700; color:var(--jade-950); text-align:left;">Alamat Email</label>
                <div style="position:relative;">
                    <svg style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" class="login-input" style="width:100%; padding:12px 18px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;">
                    <x-input-error :messages="$errors->get('email')" style="margin-top:4px; color:#dc2626; font-size:12px;" />
                </div>
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
                    <x-input-error :messages="$errors->get('password')" style="margin-top:4px; color:#dc2626; font-size:12px;" />
                </div>
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
                    <x-input-error :messages="$errors->get('password_confirmation')" style="margin-top:4px; color:#dc2626; font-size:12px;" />
                </div>
            </div>

            <div style="margin-top:8px;">
                <button type="submit" class="btn btn-solid" style="width:100%; justify-content:center; padding:14px; font-size:15px; border-radius:14px; background: var(--jade-900); color: var(--parchment); border: none; font-weight: 700; cursor: pointer; transition: background 0.2s, transform 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; box-shadow: 0 14px 30px rgba(10,43,32,0.28);">
                    Daftar Sekarang
                </button>
            </div>
        </form>

        <div style="margin-top:20px; text-align:center; font-size:13px; font-weight:500; color:var(--ink-soft);">
            Sudah punya akun? <a href="{{ route('login') }}" style="font-weight:700; color:var(--jade-900); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--jade-900)'">Masuk di sini</a> &nbsp;|&nbsp; 
            Ingin mendaftar sebagai jamaah? <a href="{{ route('register') }}" style="font-weight:700; color:var(--jade-900); text-decoration:none; transition:color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--jade-900)'">Klik di sini</a>
        </div>
    </div>



  </div>
</header>

</body>
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
</script>
</html>
