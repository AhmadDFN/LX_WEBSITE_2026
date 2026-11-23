@extends('layouts.app')

@section('title', 'Tactical Command Center')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <!-- OPERATOR DOSSIER BANNER -->
    <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 sm:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="flex items-center space-x-5">
            <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-gold-400 to-amber-700 flex items-center justify-center text-black font-black text-2xl font-mono shadow-lg shadow-gold-500/20">
                {{ substr($playerProfile->ign ?? $user->name, 0, 2) }}
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl sm:text-3xl font-black text-white uppercase">
                        {{ $playerProfile->ign ?? $user->name }}
                    </h1>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                        @if($user->role === 'superadmin') bg-red-500/20 text-red-400 border border-red-500/30
                        @elseif(in_array($user->role, ['manager', 'coach'])) bg-amber-500/20 text-amber-400 border border-amber-500/30
                        @else bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @endif">
                        ROLE: {{ strtoupper($user->role) }}
                    </span>
                </div>
                <div class="text-xs font-mono text-zinc-400 flex flex-wrap gap-x-4 gap-y-1 mt-1">
                    <span>UID: <strong class="text-zinc-200">{{ $playerProfile->delta_force_uid ?? 'LX-STAFF' }}</strong></span>
                    <span>RANK: <strong class="text-gold-400">{{ $playerProfile->rank_tier ?? 'HQ Command' }}</strong></span>
                    <span>CLASS: <strong class="text-zinc-200 uppercase">{{ $playerProfile->preferred_class ?? 'Command' }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Quick Log Actions -->
        <div class="flex items-center space-x-3">
            @if($isStaff)
            <a href="{{ route('management.applications.index') }}" class="px-4 py-2 rounded bg-amber-500/20 hover:bg-amber-500/30 border border-amber-500/40 text-amber-300 text-xs font-mono font-bold uppercase tracking-wider transition-colors">
                RECRUITS TRIAGE
            </a>
            <a href="{{ route('management.scrims.create') }}" class="px-4 py-2 rounded bg-gold-500/20 hover:bg-gold-500/30 border border-gold-500/40 text-gold-300 text-xs font-mono font-bold uppercase tracking-wider transition-colors">
                + SCHEDULE SCRIM
            </a>
            @endif
        </div>
    </div>

    <!-- STAFF COMMAND METRICS DOCK (IF STAFF) -->
    @if($isStaff)
    <section class="space-y-4">
        <div class="text-xs font-mono text-gold-400 uppercase tracking-widest flex items-center space-x-2">
            <span class="w-2 h-2 bg-gold-400"></span>
            <span>CLAN READINESS & TELEMETRY SUMMARY</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-5 rounded-lg bg-obsidian-900 hud-border text-center">
                <span class="text-[10px] font-mono text-zinc-400 uppercase">TOTAL OPERATORS</span>
                <div class="text-3xl font-black text-white font-mono mt-1">{{ $metrics['total_members'] ?? 0 }}</div>
                <span class="text-[10px] font-mono text-zinc-500">ACTIVE ROSTER</span>
            </div>

            <div class="p-5 rounded-lg bg-obsidian-900 hud-border text-center">
                <span class="text-[10px] font-mono text-zinc-400 uppercase">PENDING APPLICANTS</span>
                <div class="text-3xl font-black text-amber-400 font-mono mt-1">{{ $metrics['pending_recruits'] ?? 0 }}</div>
                <a href="{{ route('management.applications.index') }}" class="text-[10px] font-mono text-gold-400 hover:underline block mt-0.5">REVIEW DOSSIERS &rarr;</a>
            </div>

            <div class="p-5 rounded-lg bg-obsidian-900 hud-border text-center">
                <span class="text-[10px] font-mono text-zinc-400 uppercase">UPCOMING SCRIMS</span>
                <div class="text-3xl font-black text-emerald-400 font-mono mt-1">{{ $metrics['scheduled_scrims'] ?? 0 }}</div>
                <a href="{{ route('matches') }}" class="text-[10px] font-mono text-zinc-400 hover:underline block mt-0.5">VIEW FIXTURES &rarr;</a>
            </div>

            <div class="p-5 rounded-lg bg-obsidian-900 hud-border text-center">
                <span class="text-[10px] font-mono text-zinc-400 uppercase">TACTICAL FORMATIONS</span>
                <div class="text-3xl font-black text-purple-400 font-mono mt-1">{{ $metrics['active_squads'] ?? 0 }}</div>
                <span class="text-[10px] font-mono text-zinc-500">PLATOONS & SUB-TEAMS</span>
            </div>
        </div>
    </section>
    @endif

    <!-- PLAYER SQUAD ASSIGNMENTS & RSVP TELEMETRY -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- SQUAD DEPLOYMENTS -->
        <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <div class="text-xs font-mono text-gold-400 uppercase tracking-widest">ASSIGNED SQUAD FORMATION</div>
                <span class="text-xs font-mono text-zinc-400">ACTIVE DEPLOYMENT</span>
            </div>

            @forelse($activeSquads as $squad)
            <div class="p-4 rounded-lg bg-carbon-900 border border-zinc-800 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-black text-white">{{ $squad->squad_name }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-gold-500/20 text-gold-400 uppercase">
                        {{ $squad->gameMode->name }}
                    </span>
                </div>
                <div class="text-xs text-zinc-400">{{ $squad->description }}</div>
                <div class="text-[11px] font-mono text-zinc-500 pt-2 border-t border-zinc-800/60 flex justify-between">
                    <span>CAPTAIN: {{ $squad->captain ? $squad->captain->ign : 'HQ Command' }}</span>
                    <span class="text-emerald-400 font-bold uppercase">DEPLOYED</span>
                </div>
            </div>
            @empty
            <div class="p-6 rounded bg-carbon-900/40 border border-zinc-800 text-center text-xs font-mono text-zinc-500">
                You are currently placed in the General Reserve Pool.
            </div>
            @endforelse
        </div>

        <!-- UPCOMING ENGAGEMENTS WITH 1-CLICK RSVP -->
        <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <div class="text-xs font-mono text-gold-400 uppercase tracking-widest">SCHEDULED SCRIMS & FIXTURES</div>
                <a href="{{ route('matches') }}" class="text-xs font-mono text-zinc-400 hover:text-gold-400">VIEW ALL &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($upcomingScrims as $scrim)
                <div class="p-4 rounded-lg bg-carbon-900 border border-zinc-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="text-xs font-mono text-gold-400 uppercase font-bold">{{ $scrim->format }} | {{ $scrim->gameMode->name }}</div>
                        <div class="text-sm font-bold text-white mt-0.5">VS {{ $scrim->opponent_name }}</div>
                        <div class="text-[11px] font-mono text-zinc-400 mt-1">
                            {{ \Carbon\Carbon::parse($scrim->match_date)->format('M d') }} @ {{ \Carbon\Carbon::parse($scrim->match_time)->format('H:i') }} WIB
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        @if($playerProfile)
                        <form action="{{ route('matches.rsvp', $scrim->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="player_profile_id" value="{{ $playerProfile->id }}">
                            <input type="hidden" name="status" value="attending">
                            <button type="submit" class="px-2.5 py-1.5 rounded bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/40 text-emerald-400 text-xs font-mono font-bold uppercase transition-colors">
                                CONFIRM
                            </button>
                        </form>

                        <form action="{{ route('matches.rsvp', $scrim->id) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="player_profile_id" value="{{ $playerProfile->id }}">
                            <input type="hidden" name="status" value="absent">
                            <input type="hidden" name="reason" value="Unavailable from Dashboard toggle">
                            <button type="submit" class="px-2.5 py-1.5 rounded bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 text-red-400 text-xs font-mono font-bold uppercase transition-colors">
                                ABSENT
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('matches.show', $scrim->id) }}" class="px-2.5 py-1.5 rounded bg-carbon-800 hover:bg-zinc-700 text-xs font-mono text-zinc-300 transition-colors">
                            DETAILS
                        </a>
                    </div>
                </div>
                @empty
                <div class="p-6 rounded bg-carbon-900/40 border border-zinc-800 text-center text-xs font-mono text-zinc-500">
                    No active scrims scheduled.
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
