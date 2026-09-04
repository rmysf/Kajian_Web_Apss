<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="darkreader-lock">

    <title>Atur Ulang Sandi - KajianKu</title>

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
            
            <x-auth-session-status style="margin-bottom: 16px; color: var(--jade-800); font-weight: 600; font-size: 14px; text-align: center;" :status="session('status')" />

            <div style="margin-bottom: 28px; text-align: center;">
                <div style="margin-bottom:8px;">
                    <h1 style="font-family:'Fraunces',serif; font-size:32px; font-weight:700; margin:0; color:var(--jade-950);">Kajian<em style="color:var(--gold); font-style:normal;">Ku</em></h1>
                </div>
                <p style="color:var(--ink-soft); font-size:14px; margin:0;">
                    Silakan masukkan kata sandi baru Anda di bawah ini untuk mengatur ulang akses akun Anda.
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" style="display:flex; flex-direction:column; gap:16px;">
                @csrf
                
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <label for="email" style="display:block; font-size:13px; font-weight:700; color:var(--jade-950); margin-bottom:6px;">Alamat Email</label>
                    <div style="position:relative;">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="login-input" readonly style="background-color: rgba(21,42,32,0.05); color: var(--ink-soft); cursor: not-allowed;">
                    </div>
                    <x-input-error :messages="$errors->get('email')" style="margin-top:6px; color:#dc2626; font-size:12px;" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" style="display:block; font-size:13px; font-weight:700; color:var(--jade-950); margin-bottom:6px;">Kata Sandi Baru</label>
                    <div style="position:relative;">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="login-input" style="padding-right: 40px;">
                        <button type="button" onclick="togglePassword('password', this)" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; color:var(--ink-soft); cursor:pointer; padding:4px; display:flex; align-items:center; justify-content:center;">
                            <svg class="eye-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" style="margin-top:6px; color:#dc2626; font-size:12px;" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" style="display:block; font-size:13px; font-weight:700; color:var(--jade-950); margin-bottom:6px;">Konfirmasi Kata Sandi</label>
                    <div style="position:relative;">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="login-input" style="padding-right: 40px;">
                        <button type="button" onclick="togglePassword('password_confirmation', this)" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; color:var(--ink-soft); cursor:pointer; padding:4px; display:flex; align-items:center; justify-content:center;">
                            <svg class="eye-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" style="margin-top:6px; color:#dc2626; font-size:12px;" />
                </div>

                <button type="submit" class="btn-solid" style="margin-top: 8px;">Simpan Sandi Baru</button>
                
            </form>

        </div>
    </div>
</header>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const svg = btn.querySelector('.eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        } else {
            input.type = 'password';
            svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    }
</script>

</body>
</html>
