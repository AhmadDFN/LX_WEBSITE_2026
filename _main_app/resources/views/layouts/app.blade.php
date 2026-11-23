<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Luxury Elite') | Delta Force Esports Hub</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        obsidian: {
                            950: '#090a0f',
                            900: '#0e1118',
                            850: '#131722',
                            800: '#181e2b'
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
                        sans: ['Outfit', 'sans-serif'],
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
                linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-obsidian-950 text-zinc-100 font-sans min-h-screen flex flex-col selection:bg-gold-500 selection:text-black tactical-grid">
    
    <!-- TOP STATUS TELEMETRY BAR -->
    <div class="border-b border-zinc-800/80 bg-obsidian-900/90 backdrop-blur-md px-4 py-1.5 text-xs font-mono text-zinc-400 flex justify-between items-center">
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
    <header class="sticky top-0 z-50 bg-obsidian-900/95 backdrop-blur-lg border-b border-gold-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- LOGO -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-sm bg-gradient-to-br from-gold-400 via-gold-500 to-amber-700 flex items-center justify-center font-black text-black text-xl shadow-lg shadow-gold-500/20 group-hover:scale-105 transition-transform">
                    LX
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-wider text-white group-hover:text-gold-400 transition-colors">
                        LUXURY <span class="text-gold-500">ELITE</span>
                    </span>
                    <span class="text-[10px] font-mono tracking-widest text-zinc-400 -mt-1 uppercase">
                        Delta Force Tactical Esports
                    </span>
                </div>
            </a>

            <!-- DESKTOP NAV -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded text-sm font-semibold tracking-wide transition-all {{ request()->routeIs('home') ? 'text-gold-400 bg-gold-500/10 border-b-2 border-gold-500' : 'text-zinc-300 hover:text-white hover:bg-zinc-800/50' }}">
                    HOME
                </a>
                <a href="{{ route('roster') }}" class="px-3 py-2 rounded text-sm font-semibold tracking-wide transition-all {{ request()->routeIs('roster') ? 'text-gold-400 bg-gold-500/10 border-b-2 border-gold-500' : 'text-zinc-300 hover:text-white hover:bg-zinc-800/50' }}">
                    ROSTER & SQUADS
                </a>
                <a href="{{ route('matches') }}" class="px-3 py-2 rounded text-sm font-semibold tracking-wide transition-all {{ request()->routeIs('matches*') ? 'text-gold-400 bg-gold-500/10 border-b-2 border-gold-500' : 'text-zinc-300 hover:text-white hover:bg-zinc-800/50' }}">
                    MATCH CENTER
                </a>
                <a href="{{ route('join.squad') }}" class="px-3 py-2 rounded text-sm font-semibold tracking-wide transition-all {{ request()->routeIs('join.squad*') ? 'text-gold-400 bg-gold-500/10 border-b-2 border-gold-500' : 'text-zinc-300 hover:text-white hover:bg-zinc-800/50' }}">
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
            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-1.5 rounded bg-carbon-800 border border-gold-500/30 text-xs font-mono text-zinc-200 hover:border-gold-500 transition-colors">
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
                    <a href="{{ route('login') }}" class="text-xs font-mono uppercase tracking-wider text-zinc-400 hover:text-gold-400 px-3 py-2 transition-colors">
                        LOGIN
                    </a>
                    <a href="{{ route('join.squad') }}" class="relative inline-flex items-center justify-center px-4 py-2 text-xs font-bold uppercase tracking-wider text-black bg-gradient-to-r from-gold-400 to-gold-500 hover:from-gold-300 hover:to-gold-400 rounded transition-all shadow-md shadow-gold-500/20 active:scale-95">
                        JOIN SQUAD
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
    <footer class="border-t border-gold-500/20 bg-obsidian-950 py-10 mt-16 text-xs text-zinc-400 font-mono">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center space-x-3">
                <span class="w-2 h-2 bg-gold-500 rounded-sm"></span>
                <span class="text-zinc-300 font-bold tracking-wider">LUXURY ELITE ESPORTS (LX)</span>
                <span class="text-zinc-600">|</span>
                <span>DELTA FORCE COMPETITIVE BRIGADE</span>
            </div>
            <div class="flex space-x-6">
                <a href="{{ route('home') }}" class="hover:text-gold-400 transition-colors">HOME</a>
                <a href="{{ route('roster') }}" class="hover:text-gold-400 transition-colors">ROSTER</a>
                <a href="{{ route('matches') }}" class="hover:text-gold-400 transition-colors">MATCHES</a>
                <a href="{{ route('join.squad') }}" class="hover:text-gold-400 transition-colors">JOIN SQUAD</a>
                <a href="{{ route('management.scrims.create') }}" class="hover:text-gold-400 transition-colors">SCHEDULE SCRIM</a>
            </div>
            <div class="text-zinc-500">
                &copy; {{ date('Y') }} LUXURY ELITE. ALL RIGHTS RESERVED.
            </div>
        </div>
    </footer>

</body>
</html>
