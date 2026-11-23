<div class="space-y-6">
    <!-- TOP COMMAND HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-yellow-500/20 pb-5">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono tracking-widest text-yellow-400 uppercase">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                <span>TACTICAL OPERATIONS SECTOR</span>
                <span class="text-zinc-600">/</span>
                <span class="text-zinc-400">LUXURY ELITE HQ</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-wider uppercase mt-1">
                @yield('page_title', 'Management Command Console')
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <div class="px-3 py-1.5 rounded-lg bg-carbon-900 border border-zinc-800 text-xs font-mono text-zinc-300 flex items-center gap-2">
                <span class="text-zinc-500">OPERATOR:</span>
                <strong class="text-white">{{ Auth::user()->name }}</strong>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                    @if(Auth::user()->role === 'superadmin') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                    @elseif(Auth::user()->role === 'manager') bg-cyan-500/20 text-cyan-400 border border-cyan-500/30
                    @elseif(Auth::user()->role === 'coach') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                    @else bg-zinc-700 text-zinc-300
                    @endif">
                    {{ strtoupper(Auth::user()->role) }}
                </span>
            </div>

            <a href="{{ route('tools.randomizer') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-yellow-500/10 hover:bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 text-xs font-bold tracking-wider uppercase transition flex items-center gap-1.5">
                <i class="fa-solid fa-dharmachakra"></i>
                <span class="hidden sm:inline">Draft 20v20</span>
            </a>
        </div>
    </div>

    <!-- COMMAND TAB NAVIGATION -->
    <div class="flex items-center gap-2 border-b border-zinc-800/80 overflow-x-auto pb-0">
        <a href="{{ route('management.dashboard') }}"
            class="px-4 py-3 text-xs font-bold uppercase tracking-widest transition flex items-center gap-2 whitespace-nowrap border-b-2
            {{ request()->routeIs('management.dashboard') ? 'border-yellow-400 text-yellow-400 bg-yellow-500/5' : 'border-transparent text-zinc-400 hover:text-white hover:border-zinc-700' }}">
            <i class="fa-solid fa-gauge-high"></i> Overview
        </a>

        <a href="{{ route('management.players.index') }}"
            class="px-4 py-3 text-xs font-bold uppercase tracking-widest transition flex items-center gap-2 whitespace-nowrap border-b-2
            {{ request()->routeIs('management.players*') ? 'border-yellow-400 text-yellow-400 bg-yellow-500/5' : 'border-transparent text-zinc-400 hover:text-white hover:border-zinc-700' }}">
            <i class="fa-solid fa-users"></i> 1. Management Player
        </a>

        <a href="{{ route('management.scrims.index') }}"
            class="px-4 py-3 text-xs font-bold uppercase tracking-widest transition flex items-center gap-2 whitespace-nowrap border-b-2
            {{ request()->routeIs('management.scrims*') ? 'border-yellow-400 text-yellow-400 bg-yellow-500/5' : 'border-transparent text-zinc-400 hover:text-white hover:border-zinc-700' }}">
            <i class="fa-solid fa-crosshairs"></i> 2. Management Scrim
        </a>

        <a href="{{ route('management.tournaments.index') }}"
            class="px-4 py-3 text-xs font-bold uppercase tracking-widest transition flex items-center gap-2 whitespace-nowrap border-b-2
            {{ request()->routeIs('management.tournaments*') ? 'border-yellow-400 text-yellow-400 bg-yellow-500/5' : 'border-transparent text-zinc-400 hover:text-white hover:border-zinc-700' }}">
            <i class="fa-solid fa-trophy"></i> 3. Management Tour
        </a>

        <a href="{{ route('management.applications.index') }}"
            class="px-4 py-3 text-xs font-bold uppercase tracking-widest transition flex items-center gap-2 whitespace-nowrap border-b-2
            {{ request()->routeIs('management.applications*') ? 'border-yellow-400 text-yellow-400 bg-yellow-500/5' : 'border-transparent text-zinc-400 hover:text-white hover:border-zinc-700' }}">
            <i class="fa-solid fa-user-plus"></i> Recruitment Triage
        </a>
    </div>
</div>
