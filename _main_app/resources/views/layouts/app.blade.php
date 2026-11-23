<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Luxury Elite - Official Website')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Outfit:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        obsidian: {
                            950: '#020612',
                            900: '#070b19',
                            850: '#0e1426',
                            800: '#161e36'
                        },
                        carbon: {
                            900: '#14171f',
                            800: '#1d222e',
                            700: '#2b3242'
                        },
                        gold: {
                            300: '#fae69e',
                            400: '#e5c07b',
                            500: '#d4af37',
                            600: '#b89428',
                            700: '#8c6e18'
                        }
                    },
                    fontFamily: {
                        sans: ['Outfit', 'Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace']
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .hud-border {
            border: 1px solid rgba(212, 175, 55, 0.22);
            box-shadow: inset 0 0 12px rgba(212, 175, 55, 0.04);
        }
        .gold-glow {
            text-shadow: 0 0 14px rgba(212, 175, 55, 0.45);
        }
        .gold-glow-box {
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.15);
        }
        .tactical-grid {
            background-size: 32px 32px;
            background-image: 
                linear-gradient(to right, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
        }

        /* Luxury Elite Animations */
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

        .float-anim {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-16px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-[#020612] text-zinc-100 font-sans min-h-screen flex flex-col selection:bg-gold-500 selection:text-black tactical-grid">
    
    <!-- TOP STATUS TELEMETRY BAR -->
    <div class="border-b border-zinc-800/80 bg-[#070b19]/90 backdrop-blur-md px-4 py-1.5 text-xs font-mono text-zinc-400 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center text-gold-400 font-semibold tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse mr-2"></span>
                TACTICAL NETWORK: ONLINE
            </span>
            <span class="hidden sm:inline text-zinc-500">|</span>
            <span class="hidden sm:inline text-zinc-400">DELTA FORCE DIVISION [ID: LX-DF-2026]</span>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-zinc-400">SERVER: <span class="text-zinc-200">ASIA / WIB</span></span>
            <span class="text-gold-500/80 font-bold">LUXURY ELITE</span>
        </div>
    </div>

    <!-- MAIN NAVIGATION -->
    <header class="sticky top-0 z-50 bg-[#020612]/90 backdrop-blur-xl border-b border-white/10" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- LOGO -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo-lx.png') }}" alt="Luxury Elite" class="h-12 md:h-14 w-auto object-contain transition-transform duration-500 group-hover:scale-105 drop-shadow-[0_0_12px_rgba(6,182,212,0.3)]">
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-wider text-white group-hover:text-gold-400 transition-colors">
                        LUXURY <span class="text-yellow-500">ELITE</span>
                    </span>
                    <span class="text-[10px] font-mono tracking-widest text-zinc-400 -mt-1 uppercase">
                        Official Esports Organization
                    </span>
                </div>
            </a>

            <!-- DESKTOP NAV -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-3">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded text-xs font-bold tracking-[0.15em] uppercase transition-all {{ request()->routeIs('home') ? 'text-cyan-400 border-b-2 border-cyan-400' : 'text-zinc-300 hover:text-cyan-400' }}">
                    HOME
                </a>
                <a href="{{ route('roster') }}" class="px-3.5 py-2 rounded text-xs font-bold tracking-[0.15em] uppercase transition-all {{ request()->routeIs('roster') ? 'text-cyan-400 border-b-2 border-cyan-400' : 'text-zinc-300 hover:text-cyan-400' }}">
                    ROSTER
                </a>
                <a href="{{ route('matches') }}" class="px-3.5 py-2 rounded text-xs font-bold tracking-[0.15em] uppercase transition-all {{ request()->routeIs('matches*') ? 'text-cyan-400 border-b-2 border-cyan-400' : 'text-zinc-300 hover:text-cyan-400' }}">
                    MATCHES
                </a>
                <a href="{{ route('join.squad') }}" class="px-3.5 py-2 rounded text-xs font-bold tracking-[0.15em] uppercase transition-all {{ request()->routeIs('join.squad*') ? 'text-cyan-400 border-b-2 border-cyan-400' : 'text-zinc-300 hover:text-cyan-400' }}">
                    JOIN SQUAD
                </a>
                <div class="h-4 w-px bg-zinc-800 mx-1"></div>
                <a href="{{ route('management.scrims.create') }}" class="px-2.5 py-1.5 rounded text-xs font-mono font-semibold text-zinc-400 hover:text-gold-400 transition-colors">
                    + SCRIM
                </a>
                <a href="{{ route('management.applications.index') }}" class="px-2.5 py-1.5 rounded text-xs font-mono font-semibold text-zinc-400 hover:text-gold-400 transition-colors">
                    TRIAGE
                </a>
            </nav>

            <!-- ACTION CTA (AUTH AWARE) -->
            <div class="hidden md:flex items-center space-x-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-zinc-900 border border-gold-500/30 text-xs font-mono text-zinc-200 hover:border-gold-500 transition-colors">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span class="font-bold text-white">{{ Auth::user()->playerProfile->ign ?? Auth::user()->name }}</span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] bg-gold-500/20 text-gold-400 font-bold uppercase">{{ Auth::user()->role }}</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-mono uppercase tracking-wider text-zinc-400 hover:text-red-400 px-2 py-1.5 transition-colors">
                            LOGOUT
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 border border-yellow-600/40 rounded-full text-xs font-bold text-yellow-500 hover:bg-yellow-500 hover:text-black transition-all duration-300 uppercase tracking-widest">
                        LOGIN
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded text-zinc-400 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': mobileOpen, 'block': !mobileOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{'hidden': !mobileOpen, 'block': mobileOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileOpen" x-cloak class="md:hidden border-t border-zinc-800 bg-[#070b19] px-4 pt-3 pb-5 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded text-sm font-bold tracking-wider uppercase {{ request()->routeIs('home') ? 'text-cyan-400 bg-white/5' : 'text-zinc-300 hover:text-white' }}">
                HOME
            </a>
            <a href="{{ route('roster') }}" class="block px-3 py-2 rounded text-sm font-bold tracking-wider uppercase {{ request()->routeIs('roster') ? 'text-cyan-400 bg-white/5' : 'text-zinc-300 hover:text-white' }}">
                ROSTER
            </a>
            <a href="{{ route('matches') }}" class="block px-3 py-2 rounded text-sm font-bold tracking-wider uppercase {{ request()->routeIs('matches*') ? 'text-cyan-400 bg-white/5' : 'text-zinc-300 hover:text-white' }}">
                MATCHES
            </a>
            <a href="{{ route('join.squad') }}" class="block px-3 py-2 rounded text-sm font-bold tracking-wider uppercase {{ request()->routeIs('join.squad*') ? 'text-cyan-400 bg-white/5' : 'text-zinc-300 hover:text-white' }}">
                JOIN SQUAD
            </a>
            <div class="pt-2 border-t border-zinc-800 flex items-center justify-between">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-xs font-mono text-gold-400 font-bold uppercase">Dashboard ({{ Auth::user()->name }})</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-mono text-red-400 uppercase">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center py-2 border border-yellow-500/50 rounded-full text-xs font-bold text-yellow-400 uppercase tracking-wider">
                        LOGIN
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- FLASH MESSAGES NOTIFICATION BANNER -->
    @if(session('status'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
        <div class="p-4 rounded-lg flex items-start space-x-3 border font-mono text-xs
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
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-white/10 bg-[#070b19] py-12 mt-20 text-xs text-zinc-400 font-mono">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-lx.png') }}" alt="LX Logo" class="h-6 w-auto object-contain">
                <span class="text-zinc-200 font-bold tracking-wider">LUXURY ELITE (LX)</span>
                <span class="text-zinc-600">|</span>
                <span class="text-zinc-400">DELTA FORCE COMPETITIVE BATTALION</span>
            </div>
            <div class="flex flex-wrap justify-center gap-6 text-xs uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-cyan-400 transition-colors">HOME</a>
                <a href="{{ route('roster') }}" class="hover:text-cyan-400 transition-colors">ROSTER</a>
                <a href="{{ route('matches') }}" class="hover:text-cyan-400 transition-colors">MATCHES</a>
                <a href="{{ route('join.squad') }}" class="hover:text-cyan-400 transition-colors">JOIN SQUAD</a>
                <a href="{{ route('management.scrims.create') }}" class="hover:text-cyan-400 transition-colors">SCHEDULE SCRIM</a>
            </div>
            <div class="text-zinc-500">
                &copy; {{ date('Y') }} LUXURY ELITE. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

</body>
</html>
