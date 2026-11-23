<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Luxury Elite - Official Website')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Google Fonts: Instrument Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Instrument Sans"', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'monospace']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        :root {
            --font-instrument-sans: "Instrument Sans", "Inter", sans-serif;
        }

        body {
            font-family: var(--font-instrument-sans);
            background-color: #020612;
            color: #ffffff;
        }

        /* Efek kilauan emas pada teks */
        .gold-shimmer {
            background: linear-gradient(
                to right,
                #fde047 20%,
                #ca8a04 40%,
                #fde047 60%,
                #ca8a04 80%
            );
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shine 5s linear infinite;
        }

        @keyframes shine {
            to {
                background-position: 200% center;
            }
        }

        /* Efek mengapung halus untuk hero image */
        .float-anim {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0%,
            100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-[#020612] text-white font-sans min-h-screen flex flex-col selection:bg-yellow-500 selection:text-black overflow-x-hidden antialiased">

    <!-- NAVBAR (EXACT REPLICATION FROM SVELTE NAVBAR) -->
    <nav class="absolute top-0 w-full z-50 flex items-center justify-between px-8 md:px-12 py-6 bg-gradient-to-b from-black/90 to-transparent backdrop-blur-[2px]" x-data="{ mobileOpen: false }">
        <!-- BRAND LOGO -->
        <a href="{{ route('home') }}" class="flex items-center gap-0 cursor-pointer group">
            <img
                src="{{ asset('images/logo-lx.png') }}"
                alt="Logo Luxury Elite"
                class="h-16 md:h-20 w-auto object-contain transition-transform duration-500 group-hover:scale-110"
            />
            <span class="text-lg md:text-xl font-light tracking-[0.3em] text-gray-200 hidden lg:block -ml-2">
                LUXURY <span class="font-bold text-yellow-500">ELITE</span>
            </span>
        </a>

        <!-- DESKTOP NAV MENU -->
        <div class="hidden md:flex gap-8 text-[11px] font-bold tracking-[0.2em] uppercase text-gray-400">
            <a
                href="{{ route('home') }}"
                class="hover:text-cyan-400 transition-colors duration-300 {{ request()->routeIs('home') ? 'text-cyan-400 border-b border-cyan-400' : '' }}"
            >
                Home
            </a>
            <a
                href="{{ route('roster') }}"
                class="hover:text-cyan-400 transition-colors duration-300 {{ request()->routeIs('roster*') ? 'text-cyan-400 border-b border-cyan-400' : '' }}"
            >
                Roster
            </a>
            <a
                href="{{ route('matches') }}"
                class="hover:text-cyan-400 transition-colors duration-300 {{ request()->routeIs('matches*') ? 'text-cyan-400 border-b border-cyan-400' : '' }}"
            >
                Matches
            </a>
            <a
                href="{{ route('join.squad') }}"
                class="hover:text-cyan-400 transition-colors duration-300 {{ request()->routeIs('join.squad*') ? 'text-cyan-400 border-b border-cyan-400' : '' }}"
            >
                Join Squad
            </a>
            <a
                href="{{ route('tools.randomizer') }}"
                class="hover:text-yellow-400 text-yellow-400/90 font-semibold transition-colors duration-300 {{ request()->routeIs('tools.randomizer') ? 'text-yellow-400 border-b border-yellow-400' : '' }}"
            >
                Draft 20v20
            </a>
            @auth
                @if(in_array(Auth::user()->role, ['superadmin', 'manager', 'coach']))
                <a
                    href="{{ route('management.dashboard') }}"
                    class="hover:text-cyan-400 transition-colors duration-300 {{ request()->routeIs('management*') ? 'text-cyan-400 border-b border-cyan-400' : '' }}"
                >
                    Manage
                </a>
                @endif
            @endauth
        </div>

        <!-- AUTH BUTTONS -->
        <div class="hidden md:flex items-center gap-4">
            @auth
                <a
                    href="{{ route('dashboard') }}"
                    class="px-5 py-2 border border-yellow-600/30 rounded-full text-xs font-bold text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-500 uppercase tracking-widest"
                >
                    {{ Auth::user()->playerProfile->ign ?? Auth::user()->name }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs uppercase tracking-wider text-zinc-400 hover:text-red-400 transition-colors font-mono">
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="px-6 py-2 border border-yellow-600/30 rounded-full text-xs font-bold text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-500 uppercase tracking-widest"
                >
                    Login
                </a>
            @endauth
        </div>

        <!-- MOBILE MENU BUTTON -->
        <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-zinc-300 hover:text-white focus:outline-none">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path :class="{'hidden': mobileOpen, 'block': !mobileOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path :class="{'hidden': !mobileOpen, 'block': mobileOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- MOBILE DROPDOWN -->
        <div x-show="mobileOpen" x-cloak class="md:hidden absolute top-full left-0 w-full bg-[#020612]/95 border-b border-white/10 px-6 py-6 space-y-4 backdrop-blur-lg">
            <a href="{{ route('home') }}" class="block text-xs font-bold uppercase tracking-[0.2em] {{ request()->routeIs('home') ? 'text-cyan-400' : 'text-zinc-300' }}">Home</a>
            <a href="{{ route('roster') }}" class="block text-xs font-bold uppercase tracking-[0.2em] {{ request()->routeIs('roster*') ? 'text-cyan-400' : 'text-zinc-300' }}">Roster</a>
            <a href="{{ route('matches') }}" class="block text-xs font-bold uppercase tracking-[0.2em] {{ request()->routeIs('matches*') ? 'text-cyan-400' : 'text-zinc-300' }}">Matches</a>
            <a href="{{ route('join.squad') }}" class="block text-xs font-bold uppercase tracking-[0.2em] {{ request()->routeIs('join.squad*') ? 'text-cyan-400' : 'text-zinc-300' }}">Join Squad</a>
            <a href="{{ route('tools.randomizer') }}" class="block text-xs font-bold uppercase tracking-[0.2em] text-yellow-400">Draft 20v20</a>
            @auth
                @if(in_array(Auth::user()->role, ['superadmin', 'manager', 'coach']))
                    <a href="{{ route('management.dashboard') }}" class="block text-xs font-bold uppercase tracking-[0.2em] text-cyan-400">Management Ops</a>
                @endif
                <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                    <a href="{{ route('dashboard') }}" class="text-xs text-yellow-400 font-bold uppercase tracking-wider">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-red-400 uppercase tracking-wider">Logout</button>
                    </form>
                </div>
            @else
                <div class="pt-3 border-t border-white/10">
                    <a href="{{ route('login') }}" class="block text-center py-2 border border-yellow-600/30 rounded-full text-xs font-bold text-yellow-500 uppercase tracking-widest">
                        Login
                    </a>
                </div>
            @endauth
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    @if(session('status'))
    <div class="max-w-7xl mx-auto px-6 mt-28 w-full z-40">
        <div class="p-4 rounded-xl flex items-start space-x-3 border font-mono text-xs
            @if(session('status.type') === 'success') bg-emerald-950/40 border-emerald-500/40 text-emerald-300
            @elseif(session('status.type') === 'warning') bg-amber-950/40 border-amber-500/40 text-amber-300
            @else bg-blue-950/40 border-blue-500/40 text-blue-300
            @endif">
            <span class="w-2.5 h-2.5 rounded-full mt-0.5
                @if(session('status.type') === 'success') bg-emerald-400
                @elseif(session('status.type') === 'warning') bg-amber-400
                @else bg-blue-400
                @endif"></span>
            <div>
                <div class="font-bold tracking-wider uppercase">
                    [{{ session('status.code', 'NOTICE') }}]
                </div>
                <div class="mt-0.5 text-zinc-200">
                    {{ session('status.message') }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MAIN CONTENT -->
    <main class="flex-1 {{ request()->routeIs('home') ? '' : 'pt-28 md:pt-32' }}">
        @yield('content')
    </main>

    <!-- FOOTER (EXACT LUXURY ELITE MINIMALIST FOOTER) -->
    <footer class="border-t border-white/5 bg-[#020612] py-12 text-xs text-gray-500 font-sans">
        <div class="max-w-7xl mx-auto px-8 md:px-12 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-lx.png') }}" alt="LX Logo" class="h-8 w-auto object-contain">
                <span class="text-gray-300 font-light tracking-[0.2em]">LUXURY <span class="font-bold text-yellow-500">ELITE</span></span>
                <span class="text-zinc-700">|</span>
                <span class="text-zinc-500 text-[11px] uppercase tracking-wider">Delta Force Division</span>
            </div>
            <div class="flex flex-wrap justify-center gap-8 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-cyan-400 transition-colors">Home</a>
                <a href="{{ route('roster') }}" class="hover:text-cyan-400 transition-colors">Roster</a>
                <a href="{{ route('matches') }}" class="hover:text-cyan-400 transition-colors">Matches</a>
                <a href="{{ route('join.squad') }}" class="hover:text-cyan-400 transition-colors">Join Squad</a>
            </div>
            <div class="text-[11px] text-zinc-500 tracking-wider">
                &copy; {{ date('Y') }} LUXURY ELITE. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

</body>
</html>
