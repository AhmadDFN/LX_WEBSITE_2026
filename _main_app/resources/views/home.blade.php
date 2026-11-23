@extends('layouts.app')

@section('title', 'Tactical HQ')

@section('content')
<div class="space-y-16 pb-16">

    <!-- HERO SECTION -->
    <section class="relative overflow-hidden pt-12 md:pt-20 pb-16 border-b border-gold-500/10">
        <!-- Background Ambient Glow -->
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-b from-gold-500/10 via-amber-600/5 to-transparent blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col items-center text-center max-w-3xl mx-auto space-y-6">
                <!-- Badge -->
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-gold-500/10 border border-gold-500/30 text-gold-400 text-xs font-mono uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
                    <span>DELTA FORCE COMPETITIVE BATTALION</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white uppercase">
                    SUPREMACY THROUGH <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-300 via-gold-400 to-amber-600 gold-glow">
                        TACTICAL PRECISION
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-zinc-300 text-sm sm:text-base leading-relaxed max-w-2xl font-light">
                    The official digital command post for <strong>Luxury Elite</strong>. Dominating <em>Havoc Warfare (20v20)</em>, <em>Detonation (5v5)</em>, and high-risk <em>Hazard Operations (3v3)</em>.
                </p>

                <!-- CTA Group -->
                <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                    <a href="{{ route('roster') }}" class="px-6 py-3 rounded text-sm font-bold uppercase tracking-wider text-black bg-gradient-to-r from-gold-400 to-gold-500 hover:from-gold-300 hover:to-gold-400 transition-all shadow-lg shadow-gold-500/20 active:scale-95">
                        EXPLORE WARFARE ROSTER
                    </a>
                    <a href="{{ route('matches') }}" class="px-6 py-3 rounded text-sm font-bold uppercase tracking-wider text-zinc-200 bg-carbon-800/80 hover:bg-carbon-700 border border-gold-500/20 hover:border-gold-500/40 transition-all active:scale-95">
                        VIEW SCRIM SCHEDULE
                    </a>
                </div>
            </div>

            <!-- TELEMETRY STATS DOCK -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-16 max-w-5xl mx-auto">
                <div class="p-5 rounded-lg bg-obsidian-900/80 hud-border text-center">
                    <span class="text-xs font-mono text-zinc-400 uppercase tracking-wider">ACTIVE OPERATORS</span>
                    <div class="text-3xl font-black text-white font-mono mt-1 text-gold-400">{{ $activePlayersCount }}</div>
                    <span class="text-[10px] font-mono text-zinc-500">ROSTER VERIFIED</span>
                </div>

                <div class="p-5 rounded-lg bg-obsidian-900/80 hud-border text-center">
                    <span class="text-xs font-mono text-zinc-400 uppercase tracking-wider">WARFARE PLATOON</span>
                    <div class="text-3xl font-black text-white font-mono mt-1 text-white">20v20</div>
                    <span class="text-[10px] font-mono text-zinc-500">5 SUB-TEAMS + RESERVES</span>
                </div>

                <div class="p-5 rounded-lg bg-obsidian-900/80 hud-border text-center">
                    <span class="text-xs font-mono text-zinc-400 uppercase tracking-wider">WIN RATE TELEMETRY</span>
                    <div class="text-3xl font-black text-emerald-400 font-mono mt-1">{{ $winRate }}%</div>
                    <span class="text-[10px] font-mono text-zinc-500">DETONATION & WARFARE</span>
                </div>

                <div class="p-5 rounded-lg bg-obsidian-900/80 hud-border text-center">
                    <span class="text-xs font-mono text-zinc-400 uppercase tracking-wider">SCHEDULED SCRIMS</span>
                    <div class="text-3xl font-black text-amber-400 font-mono mt-1">{{ $upcomingMatchesCount }}</div>
                    <span class="text-[10px] font-mono text-zinc-500">UPCOMING ENGAGEMENTS</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED HAVOC WARFARE SQUAD -->
    @if($featuredSquad)
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6 border-b border-gold-500/10 pb-3">
            <div>
                <span class="text-xs font-mono text-gold-400 tracking-widest uppercase">FLAGSHIP FORMATION</span>
                <h2 class="text-2xl font-black text-white uppercase">{{ $featuredSquad->squad_name }}</h2>
            </div>
            <a href="{{ route('roster', ['mode' => 'warfare']) }}" class="text-xs font-mono text-gold-400 hover:text-gold-300 tracking-wider uppercase flex items-center space-x-1">
                <span>FULL 20v20 ROSTER</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 md:p-8 relative overflow-hidden">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-6 border-b border-zinc-800">
                <div>
                    <span class="px-2.5 py-0.5 rounded text-[11px] font-mono font-bold bg-gold-500/20 text-gold-400 border border-gold-500/30 uppercase">
                        {{ $featuredSquad->gameMode->name }} ({{ $featuredSquad->gameMode->team_size }}v{{ $featuredSquad->gameMode->team_size }})
                    </span>
                    <p class="text-zinc-300 text-sm mt-2 max-w-xl">
                        {{ $featuredSquad->description }}
                    </p>
                </div>
                <div class="flex items-center space-x-3 bg-carbon-800/60 px-4 py-2.5 rounded border border-zinc-700/60">
                    <div class="w-9 h-9 rounded bg-gold-500/20 text-gold-400 flex items-center justify-center font-black font-mono">
                        CMD
                    </div>
                    <div>
                        <div class="text-[10px] font-mono text-zinc-400 uppercase">PLATOON COMMANDER</div>
                        <div class="text-sm font-bold text-white">{{ $featuredSquad->captain ? $featuredSquad->captain->ign : 'TBA' }}</div>
                    </div>
                </div>
            </div>

            <!-- 5 Sub-Teams Preview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                @forelse($featuredSquad->subTeams as $team)
                <div class="p-3.5 rounded bg-carbon-900/90 border border-zinc-800/80 hover:border-gold-500/40 transition-colors">
                    <div class="flex items-center justify-between mb-1">
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
                    Sub-teams initialized and awaiting deployment.
                </div>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    <!-- FEATURED OPERATORS SHOWCASE -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6 border-b border-gold-500/10 pb-3">
            <div>
                <span class="text-xs font-mono text-gold-400 tracking-widest uppercase">COMBAT HIGHLIGHTS</span>
                <h2 class="text-2xl font-black text-white uppercase">FEATURED CORE OPERATORS</h2>
            </div>
            <a href="{{ route('roster') }}" class="text-xs font-mono text-gold-400 hover:text-gold-300 tracking-wider uppercase flex items-center space-x-1">
                <span>VIEW ALL OPERATORS</span>
                <span>&rarr;</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($highlightPlayers as $player)
            <div class="p-5 rounded-lg bg-obsidian-900/90 hud-border hover:border-gold-500/50 transition-all group">
                <div class="flex items-start justify-between mb-3">
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono uppercase font-bold
                        @if($player->preferred_class === 'assault') bg-red-500/20 text-red-400 border border-red-500/30
                        @elseif($player->preferred_class === 'engineer') bg-amber-500/20 text-amber-400 border border-amber-500/30
                        @elseif($player->preferred_class === 'support') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @elseif($player->preferred_class === 'recon') bg-cyan-500/20 text-cyan-400 border border-cyan-500/30
                        @endif">
                        {{ $player->preferred_class }}
                    </span>
                    <span class="text-[10px] font-mono text-gold-400 font-bold">{{ $player->rank_tier }}</span>
                </div>

                <div class="text-lg font-black text-white group-hover:text-gold-400 transition-colors">
                    {{ $player->ign }}
                </div>
                <div class="text-xs font-mono text-zinc-500 mt-0.5">
                    UID: {{ $player->delta_force_uid ?? 'CLASSIFIED' }}
                </div>

                <div class="mt-4 pt-3 border-t border-zinc-800 flex justify-between items-center text-[11px] font-mono">
                    <span class="text-zinc-400">DISCORD:</span>
                    <span class="text-zinc-300 font-semibold">{{ $player->discord_tag ?? 'N/A' }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
