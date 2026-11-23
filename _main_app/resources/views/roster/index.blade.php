@extends('layouts.app')

@section('title', 'Tactical Roster & Squads')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">

    <!-- PAGE HEADER -->
    <div class="border-b border-gold-500/20 pb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-mono text-gold-400 uppercase tracking-widest mb-1">
                <span class="w-2 h-2 rounded-full bg-gold-400"></span>
                <span>OPERATIONAL LINEUP & ROSTER</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-white uppercase tracking-tight">
                LUXURY ELITE <span class="text-gold-500">BATTALION</span>
            </h1>
        </div>

        <!-- MODE SWITCHER TABS -->
        <div class="flex flex-wrap gap-1.5 p-1 rounded-lg bg-obsidian-900 border border-zinc-800 text-xs font-mono">
            <a href="{{ route('roster', ['mode' => 'all']) }}" 
               class="px-3.5 py-2 rounded font-semibold uppercase transition-all {{ $selectedMode === 'all' ? 'bg-gold-500 text-black font-bold shadow-md shadow-gold-500/20' : 'text-zinc-400 hover:text-white hover:bg-zinc-800' }}">
                ALL ROSTER
            </a>
            <a href="{{ route('roster', ['mode' => 'warfare']) }}" 
               class="px-3.5 py-2 rounded font-semibold uppercase transition-all {{ $selectedMode === 'warfare' ? 'bg-gold-500 text-black font-bold shadow-md shadow-gold-500/20' : 'text-zinc-400 hover:text-white hover:bg-zinc-800' }}">
                WARFARE 20v20
            </a>
            <a href="{{ route('roster', ['mode' => 'detonation']) }}" 
               class="px-3.5 py-2 rounded font-semibold uppercase transition-all {{ $selectedMode === 'detonation' ? 'bg-gold-500 text-black font-bold shadow-md shadow-gold-500/20' : 'text-zinc-400 hover:text-white hover:bg-zinc-800' }}">
                DETONATION 5v5
            </a>
            <a href="{{ route('roster', ['mode' => 'hazard']) }}" 
               class="px-3.5 py-2 rounded font-semibold uppercase transition-all {{ $selectedMode === 'hazard' ? 'bg-gold-500 text-black font-bold shadow-md shadow-gold-500/20' : 'text-zinc-400 hover:text-white hover:bg-zinc-800' }}">
                HAZARD OPS 3v3
            </a>
            <a href="{{ route('roster', ['mode' => 'casual']) }}" 
               class="px-3.5 py-2 rounded font-semibold uppercase transition-all {{ $selectedMode === 'casual' ? 'bg-gold-500 text-black font-bold shadow-md shadow-gold-500/20' : 'text-zinc-400 hover:text-white hover:bg-zinc-800' }}">
                CASUAL MEMBERS
            </a>
        </div>
    </div>

    <!-- 1. HAVOC WARFARE SECTION (20v20 HIERARCHY) -->
    @if(in_array($selectedMode, ['all', 'warfare']) && $warfarePlatoon)
    <section class="space-y-8">
        <!-- PLATOON HEADER -->
        <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 pb-6 border-b border-zinc-800">
                <div>
                    <div class="inline-flex items-center space-x-2 text-xs font-mono text-gold-400 uppercase font-bold tracking-widest">
                        <span>PRIMARY WARFARE FORMATION</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-white uppercase mt-1">
                        {{ $warfarePlatoon->squad_name }}
                    </h2>
                    <p class="text-zinc-300 text-sm mt-1 max-w-2xl font-light">
                        {{ $warfarePlatoon->description }}
                    </p>
                </div>

                <div class="flex items-center space-x-4 bg-carbon-800/80 px-4 py-3 rounded-lg border border-gold-500/20">
                    <div class="w-10 h-10 rounded bg-gold-500/20 text-gold-400 flex items-center justify-center font-black font-mono">
                        CMD
                    </div>
                    <div>
                        <div class="text-[10px] font-mono text-zinc-400 uppercase">PLATOON COMMANDER</div>
                        <div class="text-base font-bold text-white">{{ $warfarePlatoon->captain ? $warfarePlatoon->captain->ign : 'TBA' }}</div>
                        <div class="text-[10px] font-mono text-gold-400">DELTA FORCE 20v20</div>
                    </div>
                </div>
            </div>

            <!-- SUB-TEAMS GRID (TEAM 1 TO TEAM 5) -->
            <div class="mt-8">
                <div class="text-xs font-mono text-zinc-400 uppercase tracking-wider mb-4 flex items-center space-x-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-sm"></span>
                    <span>ACTIVE COMBAT TEAMS (STARTER SLOTS: TEAMS 1–5)</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @forelse($warfarePlatoon->subTeams as $team)
                    <div class="rounded-lg bg-carbon-900/90 border border-zinc-800 p-4 hover:border-gold-500/40 transition-all flex flex-col justify-between">
                        <div>
                            <!-- Header -->
                            <div class="flex items-center justify-between pb-2 border-b border-zinc-800/80">
                                <span class="text-xs font-mono font-black text-gold-400">TEAM {{ $team->team_number }}</span>
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-mono bg-emerald-500/20 text-emerald-400 font-bold">READY</span>
                            </div>

                            <div class="text-sm font-bold text-white mt-2">{{ $team->squad_name }}</div>
                            <div class="text-[11px] text-zinc-400 mt-1 leading-tight">{{ $team->description }}</div>

                            <!-- Starter Member -->
                            <div class="mt-4 pt-3 border-t border-zinc-800/60">
                                <div class="text-[10px] font-mono text-zinc-500 uppercase">SQUAD LEADER / STARTER:</div>
                                @php
                                    $teamStarter = $team->squadMembers->where('slot_type', 'starter')->first();
                                @endphp
                                @if($teamStarter && $teamStarter->playerProfile)
                                <div class="mt-1 flex items-center justify-between">
                                    <span class="text-xs font-bold text-white">{{ $teamStarter->playerProfile->ign }}</span>
                                    <span class="text-[10px] font-mono px-1.5 py-0.2 rounded 
                                        @if($teamStarter->playerProfile->preferred_class === 'assault') bg-red-500/20 text-red-400
                                        @elseif($teamStarter->playerProfile->preferred_class === 'engineer') bg-amber-500/20 text-amber-400
                                        @elseif($teamStarter->playerProfile->preferred_class === 'support') bg-emerald-500/20 text-emerald-400
                                        @elseif($teamStarter->playerProfile->preferred_class === 'recon') bg-cyan-500/20 text-cyan-400
                                        @endif uppercase font-semibold">
                                        {{ $teamStarter->playerProfile->preferred_class }}
                                    </span>
                                </div>
                                <div class="text-[10px] font-mono text-gold-400/90 mt-0.5">
                                    {{ $teamStarter->role_specialization ?? 'Squad Operator' }}
                                </div>
                                @else
                                <div class="text-xs text-zinc-500 italic mt-1">Open slot</div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 pt-2 border-t border-zinc-800/40 text-[10px] font-mono text-zinc-500 flex justify-between">
                            <span>RANK: {{ $team->captain ? $team->captain->rank_tier : 'Pinnacle' }}</span>
                            <span class="text-gold-500 font-bold">SLOT: 1/4</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-5 text-center text-xs text-zinc-500 font-mono py-6">
                        No sub-teams assigned yet.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- DEDICATED SUBSTITUTES & RESERVES POOL (UNLIMITED) -->
            <div class="mt-10 pt-8 border-t border-zinc-800">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-xs font-mono text-zinc-400 uppercase tracking-wider flex items-center space-x-2">
                        <span class="w-2 h-2 bg-amber-500 rounded-sm"></span>
                        <span>UNLIMITED SUBSTITUTES & TACTICAL RESERVES POOL</span>
                    </div>
                    <span class="text-[11px] font-mono text-gold-400 font-bold">
                        ACTIVE RESERVES: {{ $warfarePlatoon->squadMembers->whereIn('slot_type', ['substitute', 'reserve'])->count() }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @forelse($warfarePlatoon->squadMembers->whereIn('slot_type', ['substitute', 'reserve']) as $member)
                    <div class="p-3 rounded-lg bg-carbon-900/80 border border-zinc-800/90 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded bg-zinc-800 flex items-center justify-center font-mono font-bold text-xs text-amber-400 border border-zinc-700">
                                RES
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white">{{ $member->playerProfile->ign }}</div>
                                <div class="text-[10px] font-mono text-zinc-400">
                                    {{ $member->role_specialization ?? 'Combat Reserve' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-1.5 py-0.5 rounded text-[9px] font-mono uppercase font-bold
                                @if($member->playerProfile->preferred_class === 'assault') bg-red-500/20 text-red-400
                                @elseif($member->playerProfile->preferred_class === 'recon') bg-cyan-500/20 text-cyan-400
                                @else bg-zinc-700 text-zinc-300
                                @endif">
                                {{ $member->playerProfile->preferred_class }}
                            </span>
                            <div class="text-[9px] font-mono text-amber-400 uppercase mt-1">
                                {{ $member->slot_type }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-4 text-xs font-mono text-zinc-500 text-center py-4 bg-carbon-900/40 rounded">
                        No players currently listed in the reserve pool.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- 2. DETONATION SECTION (5v5) -->
    @if(in_array($selectedMode, ['all', 'detonation']))
    <section class="space-y-6">
        <div class="border-b border-gold-500/10 pb-3 flex items-center justify-between">
            <div>
                <span class="text-xs font-mono text-gold-400 uppercase tracking-widest">SEARCH & DESTROY COMPETITIVE</span>
                <h2 class="text-2xl font-black text-white uppercase">DETONATION 5v5 SQUAD</h2>
            </div>
            <span class="px-2.5 py-1 rounded text-xs font-mono bg-gold-500/10 border border-gold-500/20 text-gold-400 uppercase">
                5 ATTACK / DEFENSE SLOTS
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @php
                $detonationPlayers = $allPlayers->where('player_type', 'competitive')->take(5);
            @endphp
            @forelse($detonationPlayers as $player)
            <div class="p-4 rounded-lg bg-obsidian-900/90 hud-border">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-mono text-gold-400 font-bold uppercase">{{ $player->rank_tier }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                </div>
                <div class="text-base font-black text-white">{{ $player->ign }}</div>
                <div class="text-[11px] font-mono text-zinc-400 mt-1 uppercase">{{ $player->preferred_class }} OPERATOR</div>
                <div class="mt-3 pt-2 border-t border-zinc-800 text-[10px] font-mono text-zinc-500">
                    UID: {{ $player->delta_force_uid ?? 'LX-CLASS' }}
                </div>
            </div>
            @empty
            <div class="col-span-5 text-center text-xs text-zinc-500 font-mono py-6">
                Detonation roster lineup pending.
            </div>
            @endforelse
        </div>
    </section>
    @endif

    <!-- 3. HAZARD OPERATIONS SECTION (3v3) -->
    @if(in_array($selectedMode, ['all', 'hazard']))
    <section class="space-y-6">
        <div class="border-b border-gold-500/10 pb-3 flex items-center justify-between">
            <div>
                <span class="text-xs font-mono text-gold-400 uppercase tracking-widest">TACTICAL EXTRACTION RAID</span>
                <h2 class="text-2xl font-black text-white uppercase">HAZARD OPERATIONS TRIO</h2>
            </div>
            <span class="px-2.5 py-1 rounded text-xs font-mono bg-amber-500/10 border border-amber-500/20 text-amber-400 uppercase">
                3v3 TRIO SQUAD
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-4xl">
            @php
                $hazardPlayers = $allPlayers->where('player_type', 'competitive')->slice(2, 3);
            @endphp
            @forelse($hazardPlayers as $player)
            <div class="p-5 rounded-lg bg-obsidian-900/90 hud-border">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-mono text-amber-400 font-bold uppercase">EXTRACTION SQUAD</span>
                    <span class="text-[10px] font-mono text-gold-400 font-bold">{{ $player->rank_tier }}</span>
                </div>
                <div class="text-lg font-black text-white">{{ $player->ign }}</div>
                <div class="text-xs font-mono text-zinc-400 mt-1 uppercase">{{ $player->preferred_class }} SPECIALIST</div>
                <div class="mt-4 pt-3 border-t border-zinc-800 text-[10px] font-mono text-zinc-500 flex justify-between">
                    <span>MANDELBRICK READY</span>
                    <span class="text-emerald-400">ACTIVE</span>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-xs text-zinc-500 font-mono py-6">
                Hazard Operations trio pending.
            </div>
            @endforelse
        </div>
    </section>
    @endif

    <!-- 4. CASUAL / COMMUNITY MEMBERS SECTION -->
    @if(in_array($selectedMode, ['all', 'casual']) && ($casualPlayers->count() > 0 || $selectedMode === 'casual'))
    <section class="space-y-6">
        <div class="border-b border-gold-500/10 pb-3 flex items-center justify-between">
            <div>
                <span class="text-xs font-mono text-zinc-400 uppercase tracking-widest">CLAN COMMUNITY & TRIALS</span>
                <h2 class="text-2xl font-black text-white uppercase">CASUAL & ACADEMY ROSTER</h2>
            </div>
            <span class="px-2.5 py-1 rounded text-xs font-mono bg-zinc-800 text-zinc-400 uppercase">
                RESERVES & COMMUNITY
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $displayCasual = $selectedMode === 'casual' ? $casualPlayers : $allPlayers->where('player_type', 'casual');
            @endphp
            @forelse($displayCasual as $player)
            <div class="p-4 rounded-lg bg-obsidian-900/60 border border-zinc-800">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-mono text-zinc-400 font-semibold uppercase">{{ $player->player_type }}</span>
                    <span class="text-[10px] font-mono text-zinc-400">{{ $player->rank_tier }}</span>
                </div>
                <div class="text-base font-bold text-white">{{ $player->ign }}</div>
                <div class="text-[11px] font-mono text-zinc-500 mt-0.5 uppercase">{{ $player->preferred_class }}</div>
                <div class="mt-3 pt-2 border-t border-zinc-800/60 text-[10px] font-mono text-zinc-500">
                    Discord: {{ $player->discord_tag ?? 'N/A' }}
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-xs text-zinc-500 font-mono py-6">
                No casual members registered.
            </div>
            @endforelse
        </div>
    </section>
    @endif

</div>
@endsection
