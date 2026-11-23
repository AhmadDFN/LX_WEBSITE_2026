@extends('layouts.app')

@section('title', 'Tactical Command Ops - Luxury Elite')
@section('page_title', 'Management Command Console')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    @include('management.partials.nav')

    <!-- TELEMETRY STATS GRID -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Card 1: Active Players -->
        <div class="p-5 rounded-2xl bg-[#090b10] border border-white/5 relative overflow-hidden group hover:border-yellow-500/30 transition-all">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-yellow-500/5 rounded-full blur-xl group-hover:bg-yellow-500/10 transition"></div>
            <div class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">ROSTER STATUS</div>
            <div class="text-3xl font-black text-white mt-1">{{ $activePlayers }} <span class="text-xs font-normal text-zinc-500 font-mono">/ {{ $totalPlayers }} Total</span></div>
            <div class="text-xs text-yellow-400/90 font-mono mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active Operators
            </div>
        </div>

        <!-- Card 2: Upcoming Scrims -->
        <div class="p-5 rounded-2xl bg-[#090b10] border border-white/5 relative overflow-hidden group hover:border-yellow-500/30 transition-all">
            <div class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">SCHEDULED SCRIMS</div>
            <div class="text-3xl font-black text-white mt-1">{{ $upcomingScrimsCount }}</div>
            <div class="text-xs text-cyan-400 font-mono mt-1">Upcoming Fixtures</div>
        </div>

        <!-- Card 3: Active Tournaments -->
        <div class="p-5 rounded-2xl bg-[#090b10] border border-white/5 relative overflow-hidden group hover:border-yellow-500/30 transition-all">
            <div class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">TOURNAMENTS</div>
            <div class="text-3xl font-black text-white mt-1">{{ $tournamentsCount }}</div>
            <div class="text-xs text-amber-400 font-mono mt-1">Active Campaigns</div>
        </div>

        <!-- Card 4: Recruitment Applications -->
        <div class="p-5 rounded-2xl bg-[#090b10] border border-white/5 relative overflow-hidden group hover:border-yellow-500/30 transition-all">
            <div class="text-[10px] font-mono text-zinc-400 uppercase tracking-widest">RECRUITMENT TRIAGE</div>
            <div class="text-3xl font-black text-white mt-1">{{ $pendingApplications }}</div>
            <div class="text-xs text-purple-400 font-mono mt-1">Pending Tryout Dossiers</div>
        </div>
    </div>

    <!-- QUICK ACTIONS LAUNCHPAD -->
    <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 space-y-4">
        <div class="text-xs font-mono text-zinc-400 uppercase tracking-widest">COMMAND QUICK ACTIONS</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('management.scrims.create') }}" class="p-4 rounded-xl bg-carbon-900 border border-zinc-800 hover:border-yellow-500/50 hover:bg-carbon-800 transition flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-lg bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-white uppercase tracking-wider">Schedule Scrim</div>
                    <div class="text-[11px] text-zinc-400">Atur lawan & format BO</div>
                </div>
            </a>

            <a href="{{ route('management.tournaments.index') }}" class="p-4 rounded-xl bg-carbon-900 border border-zinc-800 hover:border-yellow-500/50 hover:bg-carbon-800 transition flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-lg bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-white uppercase tracking-wider">Tournament Ops</div>
                    <div class="text-[11px] text-zinc-400">Bagan turnamen & prize</div>
                </div>
            </a>

            <a href="{{ route('management.players.index') }}" class="p-4 rounded-xl bg-carbon-900 border border-zinc-800 hover:border-yellow-500/50 hover:bg-carbon-800 transition flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-lg bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-white uppercase tracking-wider">Manage Roster</div>
                    <div class="text-[11px] text-zinc-400">Starter, sub, & role staf</div>
                </div>
            </a>

            <a href="{{ route('management.applications.index') }}" class="p-4 rounded-xl bg-carbon-900 border border-zinc-800 hover:border-yellow-500/50 hover:bg-carbon-800 transition flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-lg bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 flex items-center justify-center font-bold text-lg group-hover:scale-105 transition">
                    <i class="fa-solid fa-address-card"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-white uppercase tracking-wider">Recruitment</div>
                    <div class="text-[11px] text-zinc-400">Review pendaftaran tryout</div>
                </div>
            </a>
        </div>
    </div>

    <!-- MAIN TWO-COLUMN FEED -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- RECENT / UPCOMING SCRIMS -->
        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 space-y-4">
            <div class="flex items-center justify-between border-b border-zinc-800/80 pb-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-crosshairs text-yellow-400"></i>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-white">Recent &amp; Upcoming Scrims</h2>
                </div>
                <a href="{{ route('management.scrims.index') }}" class="text-xs text-yellow-400 hover:underline font-mono">View All &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($recentScrims as $scrim)
                <div class="p-4 rounded-xl bg-carbon-900/80 border border-zinc-800 hover:border-zinc-700 transition flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-mono font-bold text-yellow-400">{{ $scrim->format }}</span>
                            <span class="text-sm font-bold text-white">vs {{ $scrim->opponent_name }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                                @if($scrim->status === 'scheduled') bg-blue-500/20 text-blue-400 border border-blue-500/30
                                @elseif($scrim->status === 'completed') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                @elseif($scrim->status === 'ongoing') bg-amber-500/20 text-amber-400 border border-amber-500/30
                                @else bg-zinc-800 text-zinc-400
                                @endif">
                                {{ $scrim->status }}
                            </span>
                        </div>
                        <div class="text-xs font-mono text-zinc-400 flex items-center gap-3">
                            <span><i class="fa-regular fa-calendar"></i> {{ $scrim->match_date?->format('d M Y') }}</span>
                            <span><i class="fa-regular fa-clock"></i> {{ substr($scrim->match_time, 0, 5) }} WIB</span>
                            <span>{{ $scrim->gameMode->name ?? 'Delta Force' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @if($scrim->status === 'completed' && $scrim->result)
                            <div class="text-right">
                                <span class="text-xs font-mono font-bold px-2 py-0.5 rounded {{ $scrim->result->result === 'victory' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $scrim->result->our_score }} - {{ $scrim->result->opponent_score }}
                                </span>
                            </div>
                        @else
                            <a href="{{ route('management.scrims.edit', $scrim->id) }}" class="px-3 py-1.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-xs font-mono text-zinc-300 transition">
                                Manage
                            </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-xs font-mono text-zinc-500">
                    Belum ada jadwal scrim. Klik "Schedule Scrim" untuk membuat sparring baru.
                </div>
                @endforelse
            </div>
        </div>

        <!-- ACTIVE TOURNAMENTS -->
        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 space-y-4">
            <div class="flex items-center justify-between border-b border-zinc-800/80 pb-3">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-trophy text-yellow-400"></i>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-white">Tournament Campaigns</h2>
                </div>
                <a href="{{ route('management.tournaments.index') }}" class="text-xs text-yellow-400 hover:underline font-mono">View All &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($recentTournaments as $tour)
                <div class="p-4 rounded-xl bg-carbon-900/80 border border-zinc-800 hover:border-zinc-700 transition flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-white">{{ $tour->name }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                                @if($tour->status === 'ongoing') bg-amber-500/20 text-amber-400 border border-amber-500/30
                                @elseif($tour->status === 'completed') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                @else bg-blue-500/20 text-blue-400 border border-blue-500/30
                                @endif">
                                {{ $tour->status }}
                            </span>
                        </div>
                        <div class="text-xs font-mono text-zinc-400 flex flex-wrap gap-x-3 gap-y-1">
                            @if($tour->prize_pool)
                            <span class="text-yellow-400 font-bold"><i class="fa-solid fa-coins"></i> {{ $tour->prize_pool }}</span>
                            @endif
                            <span>{{ strtoupper(str_replace('_', ' ', $tour->tournament_format)) }}</span>
                            @if($tour->placement)
                            <span class="text-emerald-400 font-bold"><i class="fa-solid fa-medal"></i> {{ $tour->placement }}</span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('management.tournaments.show', $tour->id) }}" class="px-3 py-1.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-xs font-mono text-zinc-300 transition">
                        Bagan &amp; Skor
                    </a>
                </div>
                @empty
                <div class="text-center py-8 text-xs font-mono text-zinc-500">
                    Belum ada turnamen terdaftar. Klik "Tournament Ops" untuk mendaftarkan event baru.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
