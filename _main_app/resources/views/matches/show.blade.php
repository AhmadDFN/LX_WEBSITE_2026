@extends('layouts.app')

@section('title', 'Scrim Inspection #' . $match->id)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <!-- BREADCRUMB & STATUS -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-gold-500/20 pb-4">
        <div class="flex items-center space-x-3 text-xs font-mono">
            <a href="{{ route('matches') }}" class="text-zinc-400 hover:text-gold-400 transition-colors">&larr; BACK TO MATCH CENTER</a>
            <span class="text-zinc-600">/</span>
            <span class="text-gold-400 font-bold uppercase">FIXTURE #{{ $match->id }}</span>
        </div>
        <div class="flex items-center space-x-2 font-mono text-xs">
            <span class="px-2.5 py-1 rounded bg-amber-500/20 text-amber-400 border border-amber-500/30 uppercase font-bold">
                STATUS: {{ strtoupper($match->status) }}
            </span>
            <span class="px-2.5 py-1 rounded bg-carbon-800 text-zinc-300 border border-zinc-700 uppercase">
                {{ $match->format }}
            </span>
        </div>
    </div>

    <!-- TACTICAL RESERVE ALERT (FLASHING WARNING IF A STARTER IS ABSENT) -->
    @if($missingStarters->count() > 0)
    <div class="p-5 rounded-xl bg-red-950/40 border-2 border-red-500/70 shadow-lg shadow-red-500/10 space-y-3">
        <div class="flex items-center space-x-3">
            <span class="w-3 h-3 rounded-full bg-red-500 animate-ping"></span>
            <span class="text-sm font-black text-red-400 uppercase font-mono tracking-wider">
                [ALERT: RESERVE OPERATOR REQUIRED IMMEDIATELY]
            </span>
        </div>
        <p class="text-xs text-zinc-300 font-mono leading-relaxed">
            One or more core starters have submitted an <strong>ABSENT</strong> status for this scheduled operation:
        </p>
        <div class="flex flex-wrap gap-2 pt-1">
            @foreach($missingStarters as $starter)
            <span class="px-2.5 py-1 rounded bg-red-500/20 border border-red-500/40 text-red-300 text-xs font-mono font-bold">
                {{ $starter->playerProfile->ign }} ({{ $starter->role_specialization ?? 'Starter' }})
            </span>
            @endforeach
        </div>

        @if($availableReserves->count() > 0)
        <div class="pt-2 border-t border-red-500/30 text-xs font-mono text-zinc-400">
            <span class="text-gold-400 font-bold">AVAILABLE REPLACEMENTS FROM RESERVE POOL:</span>
            <div class="flex flex-wrap gap-2 mt-1.5">
                @foreach($availableReserves as $reserve)
                <span class="px-2 py-0.5 rounded bg-amber-500/20 border border-amber-500/30 text-amber-300 text-[11px] font-bold">
                    {{ $reserve->playerProfile->ign }} [{{ $reserve->playerProfile->preferred_class }}]
                </span>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- MATCH SHOWCASE HUD -->
    <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center text-center">
            <!-- Home Team -->
            <div class="space-y-1">
                <span class="text-[10px] font-mono text-gold-400 uppercase font-bold tracking-widest">SQUAD REPRESENTATIVE</span>
                <div class="text-2xl sm:text-3xl font-black text-white uppercase">LUXURY ELITE</div>
                <div class="text-xs font-mono text-zinc-400">
                    {{ $match->squad ? $match->squad->squad_name : 'Warfare Battalion' }}
                </div>
            </div>

            <!-- VS & Timing Telemetry -->
            <div class="p-4 rounded-lg bg-carbon-800/80 border border-zinc-700/80 space-y-2">
                <div class="text-xs font-mono font-black text-gold-400 uppercase tracking-widest">
                    {{ $match->gameMode->name }} ({{ $match->gameMode->team_size }}v{{ $match->gameMode->team_size }})
                </div>
                <div class="text-xl sm:text-2xl font-black font-mono text-white">
                    {{ \Carbon\Carbon::parse($match->match_date)->format('M d, Y') }}
                </div>
                <div class="text-sm font-mono text-emerald-400 font-bold">
                    {{ \Carbon\Carbon::parse($match->match_time)->format('H:i') }} WIB
                </div>
                <div class="text-[11px] font-mono text-zinc-400">
                    MATCH FORMAT: {{ $match->format }}
                </div>
            </div>

            <!-- Opponent -->
            <div class="space-y-1">
                <span class="text-[10px] font-mono text-zinc-500 uppercase font-bold tracking-widest">CHALLENGING FACTION</span>
                <div class="text-2xl sm:text-3xl font-black text-zinc-200 uppercase">
                    {{ $match->opponent_name }}
                </div>
                <div class="text-xs font-mono text-zinc-400">CUSTOM SCRIM MATCH</div>
            </div>
        </div>

        <!-- ROOM CREDENTIALS (COLLAPSIBLE / HUD) -->
        <div class="mt-8 pt-6 border-t border-zinc-800 grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ showPass: false }">
            <div class="p-3.5 rounded bg-carbon-900 border border-zinc-800 flex justify-between items-center text-xs font-mono">
                <span class="text-zinc-400 uppercase">SERVER ROOM ID:</span>
                <span class="text-white font-bold">{{ $match->room_id ?? 'PENDING LOBBY CREATION' }}</span>
            </div>

            <div class="p-3.5 rounded bg-carbon-900 border border-zinc-800 flex justify-between items-center text-xs font-mono">
                <span class="text-zinc-400 uppercase">ROOM PASSWORD:</span>
                <div class="flex items-center space-x-2">
                    <span class="text-white font-bold" x-text="showPass ? '{{ $match->room_password ?? 'N/A' }}' : '••••••••'">••••••••</span>
                    <button type="button" @click="showPass = !showPass" class="text-gold-400 hover:text-gold-300 text-[10px] uppercase font-bold">
                        <span x-text="showPass ? 'HIDE' : 'REVEAL'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- RSVP INTERACTIVE ACTION WIDGET -->
    <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-zinc-800 pb-4">
            <div>
                <span class="text-xs font-mono text-gold-400 uppercase tracking-widest">TACTICAL TELEMETRY</span>
                <h3 class="text-lg font-black text-white uppercase">SUBMIT PLAYER ATTENDANCE (RSVP)</h3>
            </div>
            <span class="text-xs font-mono text-zinc-400">1-CLICK ROSTER TELEMETRY</span>
        </div>

        <form action="{{ route('matches.rsvp', $match->id) }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Select Your Operator Profile</label>
                    <select name="player_profile_id" required class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3 py-2 text-sm text-white focus:border-gold-500 font-sans">
                        @foreach($allPlayers as $p)
                            <option value="{{ $p->id }}">{{ $p->ign }} ({{ $p->preferred_class }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Status Commitment</label>
                    <select name="status" required class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3 py-2 text-sm text-white focus:border-gold-500 font-sans">
                        <option value="attending">CONFIRMED ATTENDING (Ready)</option>
                        <option value="tentative">TENTATIVE (Requires Confirmation)</option>
                        <option value="absent">ABSENT (Emergency / Conflict)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Excuse / Tactical Reason (If Absent)</label>
                    <input type="text" name="reason" placeholder="e.g. Work commitment / Device issue" 
                           class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3 py-2 text-sm text-white focus:border-gold-500 font-sans">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 rounded text-xs font-black uppercase tracking-wider text-black bg-gradient-to-r from-gold-400 to-gold-500 hover:from-gold-300 hover:to-gold-400 transition-all shadow-md shadow-gold-500/20 active:scale-95">
                    TRANSMIT RSVP STATUS
                </button>
            </div>
        </form>
    </div>

    <!-- ATTENDANCE BREAKDOWN MATRIX -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Confirmed Attending -->
        <div class="rounded-lg bg-obsidian-900/80 border border-emerald-500/30 p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-zinc-800">
                <span class="text-xs font-mono font-bold text-emerald-400 uppercase flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>ATTENDING ({{ $attending->count() }})</span>
                </span>
                <span class="text-[10px] font-mono text-zinc-400">COMBAT READY</span>
            </div>

            <div class="space-y-2">
                @forelse($attending as $item)
                <div class="p-2.5 rounded bg-carbon-900/80 border border-zinc-800 flex justify-between items-center text-xs font-mono">
                    <span class="font-bold text-white">{{ $item->playerProfile->ign }}</span>
                    <span class="text-[10px] text-zinc-400 uppercase">{{ $item->playerProfile->preferred_class }}</span>
                </div>
                @empty
                <div class="text-xs font-mono text-zinc-500 py-3 text-center">No confirmations yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Tentative -->
        <div class="rounded-lg bg-obsidian-900/80 border border-amber-500/30 p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-zinc-800">
                <span class="text-xs font-mono font-bold text-amber-400 uppercase flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span>TENTATIVE ({{ $tentative->count() }})</span>
                </span>
                <span class="text-[10px] font-mono text-zinc-400">STANDBY</span>
            </div>

            <div class="space-y-2">
                @forelse($tentative as $item)
                <div class="p-2.5 rounded bg-carbon-900/80 border border-zinc-800 space-y-1 text-xs font-mono">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-white">{{ $item->playerProfile->ign }}</span>
                        <span class="text-[10px] text-amber-400">UNCERTAIN</span>
                    </div>
                    @if($item->reason)
                    <div class="text-[10px] text-zinc-500 italic">"{{ $item->reason }}"</div>
                    @endif
                </div>
                @empty
                <div class="text-xs font-mono text-zinc-500 py-3 text-center">No tentative reports.</div>
                @endforelse
            </div>
        </div>

        <!-- Absent -->
        <div class="rounded-lg bg-obsidian-900/80 border border-red-500/30 p-5 space-y-4">
            <div class="flex items-center justify-between pb-2 border-b border-zinc-800">
                <span class="text-xs font-mono font-bold text-red-400 uppercase flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-red-400"></span>
                    <span>ABSENT ({{ $absent->count() }})</span>
                </span>
                <span class="text-[10px] font-mono text-zinc-400">UNAVAILABLE</span>
            </div>

            <div class="space-y-2">
                @forelse($absent as $item)
                <div class="p-2.5 rounded bg-carbon-900/80 border border-zinc-800 space-y-1 text-xs font-mono">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-white">{{ $item->playerProfile->ign }}</span>
                        <span class="text-[10px] text-red-400">STAND-DOWN</span>
                    </div>
                    @if($item->reason)
                    <div class="text-[10px] text-zinc-500 italic">"{{ $item->reason }}"</div>
                    @endif
                </div>
                @empty
                <div class="text-xs font-mono text-zinc-500 py-3 text-center">No reported absences.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
