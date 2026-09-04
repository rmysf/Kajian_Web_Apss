<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="darkreader-lock">

    <title>Masuk - KajianKu</title>

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
        * { box-sizing: border-box; }
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
        
        .hero {
            position: relative;
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
            max-height: 90vh;
            overflow-y: auto;
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

        .login-input {
            width: 100%;
            padding: 12px 18px 12px 42px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: var(--paper);
            color: var(--ink);
            font-family: inherit;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        .login-input:focus {
            border-color: var(--gold) !important;
            box-shadow: 0 0 0 3px rgba(184,134,59, 0.15) !important;
        }
        .input-icon {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: var(--ink-soft);
            pointer-events: none;
        }

        .btn-solid {
            background: var(--jade-900);
            color: var(--parchment);
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 14px 30px rgba(10,43,32,0.28);
        }
        .btn-solid:hover { background: var(--jade-800); transform: translateY(-2px); }

        .btn-outline {
            background: transparent;
            color: var(--ink);
            border: 1px solid var(--gold);
            border-radius: 14px;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .btn-outline:hover { background: var(--gold-pale); transform: translateY(-2px); }

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

@if (session('status'))
    <div id="toast-success" style="position:fixed; top:24px; left:50%; transform:translateX(-50%); background:var(--jade-900); color:var(--parchment); padding:16px 24px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.2); z-index:9999; display:flex; align-items:center; gap:12px; font-size:14px; font-weight:600; animation: slideDown 0.4s ease-out forwards; width:max-content; max-width:90vw; text-align:center;">
        <svg style="flex-shrink:0" width="24" height="24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span>{{ session('status') }}</span>
        <button onclick="document.getElementById('toast-success').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer; margin-left:12px; padding:4px; display:flex; align-items:center; justify-content:center; opacity:0.8; transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <style>
        @keyframes slideDown {
            from { top: -50px; opacity: 0; }
            to { top: 24px; opacity: 1; }
        }
    </style>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if(toast) {
                toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 5000);
    </script>
@endif

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
    <div class="auth-card" style="background: #F4EEDC !important; border-radius: 32px; padding: 36px 48px; box-shadow: 0 40px 80px rgba(6,26,19,0.4); position: relative; z-index: 10; border: 1px solid rgba(231,199,126,0.3); max-height: 90vh; overflow-y: auto; width: 100%;">


            <div style="text-align: left; margin-bottom: 16px;">
                <a href="{{ url('/') }}" style="display:inline-flex; align-items:center; gap:8px; font-size:12px; font-weight:700; color:var(--jade-900); text-transform:uppercase; letter-spacing:1px; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>

            <div style="margin-bottom: 28px; text-align: center;">
                <div style="font-family:'Amiri',serif; font-size:22px; color:var(--gold); margin-bottom: 12px; font-weight:700;">
                    بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ
                </div>
                <div style="margin-bottom:8px;">
                    <h1 style="font-family:'Fraunces',serif; font-size:32px; font-weight:700; margin:0; color:var(--jade-950);">Kajian<em style="color:var(--gold); font-style:normal;">Ku</em></h1>
                </div>
                <p style="color:var(--ink-soft); font-size:14px; margin:0;">Ahlan wa sahlan, silakan masuk ke akun Anda</p>
            </div>

            <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:16px;">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" style="display:block; font-size:13px; font-weight:700; color:var(--jade-950); margin-bottom:6px;">Alamat Email</label>
                    <div style="position:relative;">
                        <svg class="input-icon" style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="login-input" style="width:100%; padding:12px 18px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;">
                    </div>
                    <x-input-error :messages="$errors->get('email')" style="margin-top:6px; color:#dc2626; font-size:12px;" />
                </div>

                <!-- Password -->
                <div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <label for="password" style="font-size:13px; font-weight:700; color:var(--jade-950);">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:12px; font-weight:600; color:var(--gold); text-decoration:none;">Lupa sandi?</a>
                        @endif
                    </div>
                    <div style="position:relative;">
                        <svg class="input-icon" style="position:absolute; top:50%; left:16px; transform:translateY(-50%); width:18px; height:18px; color:var(--ink-soft); pointer-events:none;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input id="password" type="password" name="password" required class="login-input" placeholder="••••••••" style="width:100%; padding:12px 42px 12px 42px; border-radius:14px; border:1px solid var(--line); background:var(--paper); color:var(--ink); font-family:inherit; font-size:14px; outline:none; transition:all 0.2s;">
                        <button type="button" onclick="togglePassword()" style="position:absolute; top:50%; right:16px; transform:translateY(-50%); background:none; border:none; padding:0; color:var(--ink-soft); cursor:pointer; display:flex; align-items:center; justify-content:center;">
                            <svg id="eye-icon" style="width:18px; height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" style="margin-top:6px; color:#dc2626; font-size:12px;" />
                </div>
                
                <script>
                    function togglePassword() {
                        var pwd = document.getElementById("password");
                        var icon = document.getElementById("eye-icon");
                        if (pwd.type === "password") {
                            pwd.type = "text";
                            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
                        } else {
                            pwd.type = "password";
                            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
                        }
                    }
                </script>

                <!-- Remember Me -->
                <div style="display:flex; align-items:center;">
                    <input id="remember_me" type="checkbox" name="remember" style="width:16px; height:16px; accent-color:var(--jade-900); cursor:pointer;">
                    <label for="remember_me" style="margin-left:8px; font-size:13px; font-weight:500; color:var(--ink); cursor:pointer;">Ingat saya</label>
                </div>

                <button type="submit" class="btn-solid" style="margin-top: 8px; background: var(--jade-900); color: var(--parchment); border: none; border-radius: 14px; padding: 14px; font-size: 15px; font-weight: 700; cursor: pointer; width: 100%; transition: background 0.2s; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 14px 30px rgba(10,43,32,0.28);">Masuk Sekarang</button>
                
                <div style="display:flex; align-items:center; margin: 4px 0;">
                    <div style="flex-grow:1; border-top:1px solid var(--line);"></div>
                    <span style="margin:0 16px; color:var(--ink-soft); font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">Atau</span>
                    <div style="flex-grow:1; border-top:1px solid var(--line);"></div>
                </div>

                <a href="{{ route('google.login') }}" class="btn-outline" style="background: transparent; color: var(--ink); border: 1px solid var(--gold); border-radius: 14px; padding: 12px; font-size: 14px; font-weight: 700; cursor: pointer; width: 100%; display: flex; align-items: center; justify-content: center; transition: all 0.2s; text-decoration: none;">
                    <svg style="width:18px; height:18px; margin-right:10px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Lanjutkan dengan Google
                </a>
            </form>

            <div style="margin-top:24px; text-align:center; font-size:13px; font-weight:500; color:var(--ink-soft);">
                Belum punya akun? <a href="{{ route('register') }}" style="font-weight:700; color:var(--jade-900); text-decoration:none;">Daftar sekarang</a>
            </div>
        </div>
    </div>
</header>
</main>
<script>
    const swup = new Swup();
</script>
</body>
</html>
