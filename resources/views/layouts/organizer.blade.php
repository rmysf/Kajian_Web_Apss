<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="view-transition" content="same-origin" />
    <meta name="layout" content="organizer" data-turbo-track="reload">

    <title>KajianKu - Penyelenggara</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Flatpickr (Loaded globally for Turbo compatibility) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FA;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .sidebar-bg {
            background-color: #0A2B20;
            background-image: radial-gradient(400px 400px at 50% -10%, rgba(184,134,59,.20), transparent 60%),
                              linear-gradient(180deg, #0A2B20 0%, #0C3B2A 55%, #0F5137 100%);
        }
        .sidebar-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.15;
            pointer-events: none;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-[#F8F9FA]" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" @resize.window="sidebarOpen = window.innerWidth >= 1024">
    <div class="h-screen overflow-hidden flex w-full">
    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0 lg:ml-0' : '-translate-x-full lg:-ml-64'" class="fixed lg:relative inset-y-0 left-0 z-50 w-64 sidebar-bg text-white transition-all duration-300 ease-in-out flex flex-col h-full shrink-0 overflow-hidden lg:transform-none">
        
        <!-- Pattern SVG -->
        <svg class="sidebar-pattern" viewBox="0 0 256 1000" preserveAspectRatio="xMidYMid slice">
            <defs>
                <pattern id="star8" width="86" height="86" patternUnits="userSpaceOnUse" patternTransform="rotate(15)">
                    <g stroke="#E7C77E" stroke-width="1.5" fill="none">
                        <path d="M43 4 L57 22 L79 22 L64 40 L79 58 L57 58 L43 78 L29 58 L7 58 L22 40 L7 22 L29 22 Z"/>
                    </g>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#star8)"/>
        </svg>

        <div class="relative z-10 flex flex-col h-full">
            <!-- Logo Area -->
            <div class="h-16 flex items-center px-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-white text-[#0A2B20] flex items-center justify-center font-bold text-xl shadow-md">
                        K
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-[#E7C77E]">KajianKu</h1>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-3">
                <a href="{{ url('/organizer') }}" class="flex items-center px-4 py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->is('organizer') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3 {{ request()->is('organizer') ? 'text-[#E7C77E]' : '' }}"></i> Dashboard
                </a>
                
                <a href="{{ route('organizer.kajian.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('organizer.kajian.*') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}">
                    <i data-lucide="calendar-check" class="w-5 h-5 mr-3 {{ request()->routeIs('organizer.kajian.*') ? 'text-[#E7C77E]' : '' }}"></i> Kelola Kajian
                </a>
                

                <a href="{{ route('organizer.profile.edit') }}" class="flex items-center px-4 py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('organizer.profile.*') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}">
                    <i data-lucide="user" class="w-5 h-5 mr-3 {{ request()->routeIs('organizer.profile.*') ? 'text-[#E7C77E]' : '' }}"></i> Profil Penyelenggara
                </a>

                <a href="{{ route('organizer.peserta.global') }}" class="flex items-center px-4 py-3.5 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('organizer.peserta.*') ? 'bg-white/15 text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/10 ring-1 ring-white/5' : 'text-[#B7C9BE] hover:text-white hover:bg-white/10 hover:shadow-lg' }}">
                    <i data-lucide="users" class="w-5 h-5 mr-3 {{ request()->routeIs('organizer.peserta.*') ? 'text-[#E7C77E]' : '' }}"></i> Daftar Peserta
                </a>
            </nav>

            <!-- Settings / Logout Area -->
            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-medium text-[#B7C9BE] hover:text-white hover:bg-red-500/20 hover:shadow-md transition-all rounded-xl">
                        <i data-lucide="log-out" class="w-5 h-5 mr-3"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm lg:hidden" style="display: none;"></div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">
        
        <!-- Topbar -->
        <header class="h-16 px-6 flex items-center justify-between shrink-0 bg-white border-b border-gray-200">
            <div class="flex items-center">
                <button @click="sidebarOpen = !sidebarOpen" class="mr-4 p-2 text-gray-500 rounded-lg hover:bg-gray-100 transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
            
            <div class="flex items-center space-x-4">

                
                <!-- Profile -->
                <div class="flex items-center gap-3">
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Penyelenggara</p>
                    </div>
                    @if(Auth::user()->organizer && Auth::user()->organizer->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url(Auth::user()->organizer->logo) }}" class="w-9 h-9 rounded-full border border-gray-200 object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=111827" class="w-9 h-9 rounded-full border border-gray-200">
                    @endif
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-[#F8F9FA]">
            <div class="max-w-[1400px] mx-auto">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 text-emerald-800 rounded-lg flex items-center border border-emerald-100 text-sm font-medium">
                        <i data-lucide="check-circle-2" class="w-5 h-5 mr-3 text-emerald-500"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg flex items-center border border-red-100 text-sm font-medium">
                        <i data-lucide="alert-circle" class="w-5 h-5 mr-3 text-red-500"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if (isset($header))
                    <header class="mb-6">
                        <div class="text-xl font-bold text-gray-900">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
