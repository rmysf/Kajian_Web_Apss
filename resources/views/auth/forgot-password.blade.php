<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="view-transition" content="same-origin" />
    <meta name="layout" content="auth" data-turbo-track="reload">
    <meta name="darkreader-lock">

    <title>Lupa Sandi - KajianKu</title>
    @vite(['resources/js/app.js'])

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
        
        .hero {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
            background: radial-gradient(900px 500px at 82% -10%, rgba(184,134,59,0.20), transparent 60%), linear-gradient(180deg, #0A2B20 0%, #0C3B2A 55%, #0F5137 100%);
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

    </style>

    
    

</head>

<body>

<header class="hero">
  <svg class="hero-lattice" viewBox="0 0 1180 700" preserveAspectRatio="xMidYMid slice">
    <defs>
      <pattern id="star8" width="86" height="86" patternUnits="userSpaceOnUse" patternTransform="rotate(15)">
        <g stroke="#E7C77E" stroke-width="1" fill="none">
          <path d="M43 4 L57 22 L79 22 L64 40 L79 58 L57 58 L43 78 L29 58 L7 58 L22 40 L7 22 L29 22 Z"/>
        </g>
      </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#star8)"/>
  </svg>

  <div class="auth-wrapper">
    <div class="auth-card">
            <!-- Session Status will be handled by SweetAlert2 -->
            <div style="text-align: left; margin-bottom: 16px;">
                <a href="{{ route('login') }}" style="display:inline-flex; align-items:center; gap:8px; font-size:12px; font-weight:700; color:var(--jade-900); text-transform:uppercase; letter-spacing:1px; text-decoration:none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>

            <div style="margin-bottom: 28px; text-align: center;">
                <div style="margin-bottom:8px;">
                    <h1 style="font-family:'Fraunces',serif; font-size:32px; font-weight:700; margin:0; color:var(--jade-950);">Kajian<em style="color:var(--gold); font-style:normal;">Ku</em></h1>
                </div>
                <p style="color:var(--ink-soft); font-size:14px; margin:0;">
                    Lupa kata sandi? Tidak masalah. Berikan alamat email Anda, dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
                </p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" style="display:flex; flex-direction:column; gap:16px;">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" style="display:block; font-size:13px; font-weight:700; color:var(--jade-950); margin-bottom:6px;">Alamat Email</label>
                    <div style="position:relative;">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="login-input">
                    </div>
                    <x-input-error :messages="$errors->get('email')" style="margin-top:6px; color:#dc2626; font-size:12px;" />
                </div>

                <button type="submit" class="btn-solid" style="margin-top: 8px;">Kirim Tautan Reset</button>
                
            </form>

        </div>
    </div>
</header>

@if(session('status'))
    <div id="toast-status" style="position:fixed; top:24px; left:50%; transform:translateX(-50%); background:var(--jade-900); color:var(--parchment); padding:16px 24px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.2); z-index:9999; display:flex; align-items:center; gap:12px; font-size:14px; font-weight:600; animation: slideDownToast 0.4s ease-out forwards; width:max-content; max-width:90vw; text-align:center;">
        <svg style="flex-shrink:0" width="24" height="24" fill="none" stroke="var(--gold)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span>{{ session('status') }}</span>
        <button onclick="document.getElementById('toast-status').style.display='none'" style="background:none; border:none; color:inherit; cursor:pointer; margin-left:12px; padding:4px; display:flex; align-items:center; justify-content:center; opacity:0.8; transition:opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    
    <style>
        @keyframes slideDownToast {
            from { top: -50px; opacity: 0; }
            to { top: 24px; opacity: 1; }
        }
    </style>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-status');
            if(toast) {
                toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 5000);
    </script>
@endif

</body>

</html>
