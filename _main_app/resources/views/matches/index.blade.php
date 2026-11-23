@extends('layouts.app')

@section('title', 'Scrim Schedule & Match Center')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

    <!-- PAGE HEADER -->
    <div class="border-b border-gold-500/20 pb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-mono text-gold-400 uppercase tracking-widest mb-1">
                <span class="w-2 h-2 rounded-full bg-gold-400"></span>
                <span>COMPETITIVE TELEMETRY & FIXTURES</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white uppercase tracking-tight">
                MATCH <span class="text-gold-500">CENTER</span>
            </h1>
        </div>

        <div class="flex items-center space-x-3 text-xs font-mono">
            <span class="px-3 py-1.5 rounded bg-obsidian-900 border border-zinc-800 text-zinc-300">
                TIMEZONE: <strong class="text-gold-400">WESTERN INDONESIAN TIME (WIB)</strong>
            </span>
        </div>
    </div>

    <!-- 1. UPCOMING SCRIMS & TOURNAMENTS -->
    <section class="space-y-6">
        <div class="flex items-center justify-between border-b border-gold-500/10 pb-3">
            <div class="flex items-center space-x-3">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                <h2 class="text-2xl font-black text-white uppercase">UPCOMING SCHEDULED ENGAGEMENTS</h2>
            </div>
            <span class="text-xs font-mono text-zinc-400">FIXTURES: {{ $upcomingMatches->count() }}</span>
        </div>

        <div class="space-y-4">
            @forelse($upcomingMatches as $match)
            <div class="rounded-xl bg-obsidian-900/90 hud-border p-5 md:p-6 hover:border-gold-500/50 transition-all flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Left: Mode & Time -->
                <div class="flex items-center space-x-5 min-w-[240px]">
                    <div class="p-3 rounded-lg bg-carbon-800 border border-gold-500/30 text-center">
                        <span class="text-[10px] font-mono text-gold-400 uppercase block font-bold">{{ $match->format }}</span>
                        <span class="text-xs font-mono font-black text-white block mt-0.5">{{ \Carbon\Carbon::parse($match->match_date)->format('M d') }}</span>
                        <span class="text-[10px] font-mono text-zinc-400 block">{{ \Carbon\Carbon::parse($match->match_time)->format('H:i') }} WIB</span>
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                            @if($match->gameMode->slug === 'havoc-warfare') bg-purple-500/20 text-purple-400 border border-purple-500/30
                            @elseif($match->gameMode->slug === 'detonation') bg-blue-500/20 text-blue-400 border border-blue-500/30
                            @else bg-amber-500/20 text-amber-400 border border-amber-500/30
                            @endif">
                            {{ $match->gameMode->name }}
                        </span>
                        <div class="text-xs font-mono text-zinc-400 mt-1">
                            Division: {{ $match->squad ? $match->squad->squad_name : 'Main Battalion' }}
                        </div>
                    </div>
                </div>

                <!-- Middle: Versus Clashing -->
                <div class="flex-1 flex items-center justify-center space-x-6 text-center">
                    <div class="text-right">
                        <div class="text-base font-black text-white">LUXURY ELITE</div>
                        <div class="text-[11px] font-mono text-gold-400">HOST / HOME</div>
                    </div>
                    <div class="px-3 py-1 rounded bg-carbon-800 border border-zinc-700 text-xs font-mono font-black text-zinc-300">
                        VS
                    </div>
                    <div class="text-left">
                        <div class="text-base font-black text-zinc-200">{{ $match->opponent_name }}</div>
                        <div class="text-[11px] font-mono text-zinc-500">CHALLENGER</div>
                    </div>
                </div>

                <!-- Right: Room Status / RSVP Telemetry -->
                <div class="flex items-center space-x-3">
                    <div class="text-right hidden sm:block">
                        <div class="text-[10px] font-mono text-zinc-400 uppercase">SERVER REGION</div>
                        <div class="text-xs font-mono text-white font-bold">ASIA / SOUTHEAST</div>
                    </div>
                    <a href="{{ route('matches.show', $match->id) }}" class="px-4 py-2 rounded bg-gold-500/10 hover:bg-gold-500/20 border border-gold-500/40 text-gold-400 text-xs font-mono font-bold uppercase tracking-wider transition-all">
                        INSPECT / RSVP &rarr;
                    </a>
                </div>
            </div>
            @empty
            <div class="rounded-xl bg-obsidian-900/60 border border-zinc-800/80 p-10 text-center space-y-3">
                <div class="w-10 h-10 mx-auto rounded-full bg-zinc-800 text-gold-400 flex items-center justify-center font-mono font-bold">
                    !
                </div>
                <div class="text-sm font-bold text-white uppercase">NO IMMINENT SCRIMS SCHEDULED</div>
                <p class="text-xs text-zinc-400 max-w-md mx-auto">
                    The management team is actively coordinating upcoming tournament qualifiers and Havoc Warfare scrim fixtures.
                </p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- 2. RECENT MATCH HISTORY & VODS -->
    <section class="space-y-6">
        <div class="flex items-center justify-between border-b border-gold-500/10 pb-3">
            <div class="flex items-center space-x-3">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                <h2 class="text-2xl font-black text-white uppercase">RECENT COMBAT ARCHIVES & RESULTS</h2>
            </div>
            <span class="text-xs font-mono text-zinc-400">HISTORICAL LOGS</span>
        </div>

        <div class="space-y-4">
            @forelse($completedMatches as $history)
            <div class="rounded-xl bg-obsidian-900/90 hud-border p-5 md:p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <!-- Match Mode & Format -->
                <div class="min-w-[220px]">
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-zinc-800 text-zinc-300">
                        {{ $history->scrimMatch->gameMode->name ?? 'Detonation' }}
                    </span>
                    <div class="text-xs font-mono text-zinc-400 mt-1">
                        {{ \Carbon\Carbon::parse($history->scrimMatch->match_date ?? now())->format('d F Y') }}
                    </div>
                </div>

                <!-- Opponent & Score -->
                <div class="flex-1 flex items-center justify-center space-x-6">
                    <div class="text-right">
                        <div class="text-base font-black text-white">LUXURY ELITE</div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-mono font-black {{ $history->result === 'win' ? 'text-emerald-400' : 'text-red-400' }}">
                            {{ $history->our_score }} - {{ $history->opponent_score }}
                        </span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-black uppercase
                            {{ $history->result === 'win' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                            {{ strtoupper($history->result) }}
                        </span>
                    </div>
                    <div class="text-left">
                        <div class="text-base font-black text-zinc-300">{{ $history->scrimMatch->opponent_name ?? 'Opponent Clan' }}</div>
                    </div>
                </div>

                <!-- MVP & Details -->
                <div class="flex items-center space-x-4">
                    @if($history->mvpPlayer)
                    <div class="text-right">
                        <span class="text-[9px] font-mono text-gold-400 uppercase font-bold block">MATCH MVP</span>
                        <span class="text-xs font-bold text-white block">{{ $history->mvpPlayer->ign }}</span>
                    </div>
                    @endif

                    @if($history->vod_url)
                    <a href="{{ $history->vod_url }}" target="_blank" class="px-3 py-1.5 rounded bg-carbon-800 hover:bg-carbon-700 border border-gold-500/20 text-xs font-mono text-gold-400 font-bold uppercase transition-colors">
                        WATCH VOD
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="rounded-xl bg-obsidian-900/40 border border-zinc-800/80 p-8 text-center text-xs font-mono text-zinc-500">
                Official competitive match archives will appear here following completed tournaments and scrim sessions.
            </div>
            @endforelse
        </div>
    </section>

</div>
@endsection
