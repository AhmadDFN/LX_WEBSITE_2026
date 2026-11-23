@extends('layouts.app')

@section('title', 'Luxury Elite - Official Website')

@section('content')
<div class="space-y-24 pb-20 overflow-x-hidden">

    <!-- HERO SECTION (LUXURY ELITE VISUAL AESTHETIC) -->
    <section class="relative min-h-[85vh] flex items-center pt-8 md:pt-16 px-6 md:px-12">
        <!-- Ambient Skew Polygon Background -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-[-5%] w-[55%] h-full bg-gradient-to-br from-blue-950/40 to-transparent transform skew-x-[-12deg] border-r border-blue-500/10"></div>
            <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[120px] animate-pulse"></div>
        </div>

        <div class="container mx-auto flex flex-col md:flex-row items-center relative z-10 w-full">
            <!-- Left Visual: Glowing Floating Logo -->
            <div class="w-full md:w-1/2 flex justify-center items-center relative h-[45vh] md:h-[75vh]">
                <img
                    src="{{ asset('images/logo-lx.png') }}"
                    alt="LX Logo Ambient Glow"
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[85%] max-w-[500px] opacity-15 blur-[10px] z-0 pointer-events-none select-none"
                />
                <div class="float-anim z-10 relative">
                    <img
                        src="{{ asset('images/logo-lx.png') }}"
                        alt="LX Main Visual"
                        class="max-h-[380px] sm:max-h-[460px] md:max-h-[540px] w-auto object-contain drop-shadow-[0_0_50px_rgba(6,182,212,0.35)] transition-transform duration-500 hover:scale-105"
                    />
                </div>
            </div>

            <!-- Right Column: Hero Typography & CTA -->
            <div class="w-full md:w-1/2 flex flex-col items-start space-y-6 mt-8 md:mt-0">
                <div>
                    <h2 class="text-cyan-400 font-mono tracking-[0.5em] text-xs sm:text-sm md:text-base mb-3 uppercase">
                        // Tactical Delta Force
                    </h2>
                    <h1 class="text-4xl sm:text-5xl md:text-6xl xl:text-7xl font-black leading-none tracking-tighter break-words text-white">
                        WELCOME TO <br />
                        <span class="gold-shimmer italic">LUXURY ELITE</span>
                    </h1>
                </div>

                <p class="text-base md:text-lg text-gray-300 font-light max-w-xl leading-relaxed border-l-2 border-cyan-500 pl-4 sm:pl-6">
                    Uniting <span class="text-white font-medium">Ultimate Skill</span>, Precision Strategy, and
                    <span class="text-white font-medium">Pure Elegance</span>. Dominate the battlefield with the elite.
                </p>

                <div class="flex flex-wrap gap-4 sm:gap-6 pt-2">
                    <a
                        href="#roster"
                        class="group relative px-8 sm:px-10 py-3.5 sm:py-4 overflow-hidden rounded-sm bg-cyan-500 font-bold uppercase tracking-[0.2em] text-xs sm:text-sm text-black transition-all shadow-lg shadow-cyan-500/25 hover:shadow-cyan-500/40 inline-flex items-center justify-center"
                    >
                        <span class="relative z-10">Meet The Team</span>
                        <div class="absolute inset-0 bg-white translate-y-[100%] group-hover:translate-y-0 transition-transform duration-300"></div>
                    </a>

                    <a
                        href="{{ route('join.squad') }}"
                        class="px-8 sm:px-10 py-3.5 sm:py-4 border border-yellow-500/50 text-yellow-400 font-bold uppercase tracking-[0.2em] text-xs sm:text-sm rounded-sm hover:bg-yellow-500/10 transition-all duration-300 flex items-center gap-2"
                    >
                        <span>Join Squad</span>
                        <span class="text-xs">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- TELEMETRY METRICS BAR -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-5 rounded-2xl bg-[#070b19]/90 border border-white/10 hover:border-cyan-400/30 transition-all text-center">
                <span class="text-[11px] font-mono text-zinc-400 uppercase tracking-widest">ACTIVE OPERATORS</span>
                <div class="text-3xl font-black text-cyan-400 font-mono mt-1">{{ $activePlayersCount }}</div>
                <span class="text-[10px] font-mono text-zinc-500">ROSTER VERIFIED</span>
            </div>

            <div class="p-5 rounded-2xl bg-[#070b19]/90 border border-white/10 hover:border-gold-500/30 transition-all text-center">
                <span class="text-[11px] font-mono text-zinc-400 uppercase tracking-widest">WARFARE PLATOON</span>
                <div class="text-3xl font-black text-white font-mono mt-1">20v20</div>
                <span class="text-[10px] font-mono text-zinc-500">5 SUB-TEAMS + RESERVES</span>
            </div>

            <div class="p-5 rounded-2xl bg-[#070b19]/90 border border-white/10 hover:border-emerald-500/30 transition-all text-center">
                <span class="text-[11px] font-mono text-zinc-400 uppercase tracking-widest">WIN RATE</span>
                <div class="text-3xl font-black text-emerald-400 font-mono mt-1">{{ $winRate }}%</div>
                <span class="text-[10px] font-mono text-zinc-500">TACTICAL DOMINANCE</span>
            </div>

            <div class="p-5 rounded-2xl bg-[#070b19]/90 border border-white/10 hover:border-yellow-500/30 transition-all text-center">
                <span class="text-[11px] font-mono text-zinc-400 uppercase tracking-widest">SCHEDULED SCRIMS</span>
                <div class="text-3xl font-black text-yellow-400 font-mono mt-1">{{ $upcomingMatchesCount }}</div>
                <span class="text-[10px] font-mono text-zinc-500">UPCOMING ENGAGEMENTS</span>
            </div>
        </div>
    </section>

    <!-- ROSTER SECTION (EXACT LUXURY ELITE SVELTE REPLICATION) -->
    <section id="roster" class="max-w-7xl mx-auto px-6 py-12 relative scroll-mt-24">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-500/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

        <div class="mb-16 text-center md:text-left">
            <p class="text-cyan-400 uppercase tracking-[0.6em] text-xs sm:text-sm font-bold animate-pulse">
                Luxury Elite Members
            </p>
            <h2 class="text-5xl sm:text-6xl md:text-7xl font-black mt-3 tracking-tighter uppercase italic text-white">
                LX <span class="text-transparent" style="-webkit-text-stroke: 1px rgba(255, 255, 255, 0.6); opacity: 0.6;">ROSTER</span>
            </h2>
        </div>

        <!-- Dynamic Grid (6 columns base) -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-x-8 gap-y-12">
            @php
                $total = count($players);
            @endphp

            @foreach ($players as $i => $player)
                @php
                    $spanClasses = 'col-span-1 md:col-span-3 lg:col-span-2';
                    if ($total % 2 !== 0 && $i === $total - 1) {
                        $spanClasses = str_replace('md:col-span-3', 'md:col-span-6', $spanClasses);
                    }
                    $rem = $total % 3;
                    if ($rem === 1 && $i === $total - 1) {
                        $spanClasses = str_replace('lg:col-span-2', 'lg:col-span-6', $spanClasses);
                    } elseif ($rem === 2 && $i >= $total - 2) {
                        $spanClasses = str_replace('lg:col-span-2', 'lg:col-span-3', $spanClasses);
                    }
                @endphp

                <div class="flex justify-center w-full {{ $spanClasses }}">
                    <!-- Card Wrapper -->
                    <div class="w-full max-w-md transition-all duration-500">
                        <div class="group relative bg-white/5 border border-white/10 rounded-[2rem] overflow-hidden transition-all duration-500 hover:border-cyan-400/50 hover:shadow-[0_0_40px_rgba(6,182,212,0.18)]">
                            <!-- Hover Gradient Back-glow -->
                            <div class="absolute -inset-px bg-gradient-to-br from-cyan-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"></div>

                            <div class="relative z-10">
                                <!-- Image Area -->
                                <div class="relative overflow-hidden aspect-[4/5] bg-zinc-900">
                                    <img
                                        src="{{ asset($player['image']) }}"
                                        alt="{{ $player['nickname'] }}"
                                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000 ease-out"
                                        loading="lazy"
                                    />

                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent opacity-90"></div>

                                    <!-- Status Pill -->
                                    <div class="absolute top-6 right-6">
                                        <span class="{{ strtolower($player['status']) === 'active' ? 'bg-cyan-500 shadow-[0_0_15px_rgba(6,182,212,0.5)]' : 'bg-yellow-500 shadow-[0_0_15px_rgba(234,179,8,0.5)]' }} text-black text-[10px] px-4 py-1.5 rounded-full uppercase tracking-[0.2em] font-black italic transition-transform duration-500 group-hover:scale-110">
                                            {{ $player['status'] }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Details -->
                                <div class="p-8 relative">
                                    <div class="absolute top-0 left-8 w-12 h-[2px] bg-cyan-500 transition-all duration-500 group-hover:w-24"></div>

                                    <p class="text-cyan-400 uppercase text-[11px] tracking-[0.4em] font-medium mb-1">
                                        {{ $player['role'] }}
                                    </p>

                                    <h3 class="text-3xl md:text-4xl font-black text-white tracking-tighter italic uppercase group-hover:text-cyan-400 transition-colors duration-300">
                                        {{ $player['nickname'] }}
                                    </h3>

                                    <div class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-cyan-500 w-0 group-hover:w-full transition-all duration-700 delay-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- FEATURED HAVOC WARFARE PLATOON (TACTICAL DIVISION) -->
    @if($featuredSquad)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="p-6 sm:p-8 rounded-3xl bg-[#070b19]/90 border border-white/10 relative overflow-hidden">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8 border-b border-white/10 pb-6">
                <div>
                    <div class="inline-flex items-center space-x-2 text-gold-400 text-xs font-mono tracking-widest uppercase mb-1">
                        <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
                        <span>FEATURED BRIGADE SPECIFICATION</span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight uppercase">
                        {{ $featuredSquad->squad_name }}
                    </h3>
                    <p class="text-zinc-400 text-sm mt-1 max-w-xl">
                        {{ $featuredSquad->description }}
                    </p>
                </div>

                <div class="flex items-center space-x-3 bg-white/5 px-5 py-3 rounded-xl border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-gold-500/20 text-gold-400 flex items-center justify-center font-black font-mono">
                        CMD
                    </div>
                    <div>
                        <div class="text-[10px] font-mono text-zinc-400 uppercase">PLATOON COMMANDER</div>
                        <div class="text-sm font-bold text-white">{{ $featuredSquad->captain ? $featuredSquad->captain->ign : 'iRzell`LX' }}</div>
                    </div>
                </div>
            </div>

            <!-- Sub-teams Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                @forelse($featuredSquad->subTeams as $team)
                <div class="p-4 rounded-xl bg-white/5 border border-white/5 hover:border-cyan-400/30 transition-colors">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-mono font-bold text-gold-400">TEAM {{ $team->team_number }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    </div>
                    <div class="text-xs font-bold text-white truncate">{{ $team->squad_name }}</div>
                    <div class="text-[10px] font-mono text-zinc-400 mt-1 truncate">
                        Lead: {{ $team->captain ? $team->captain->ign : 'Open' }}
                    </div>
                </div>
                @empty
                <div class="col-span-5 text-center text-xs text-zinc-500 font-mono py-4">
                    Sub-teams deployed under active rotation.
                </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

</div>
@endsection
