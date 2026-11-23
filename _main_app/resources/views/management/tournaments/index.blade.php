@extends('layouts.app')

@section('title', 'Tournament Management - Luxury Elite')
@section('page_title', '3. Management Tour (Tournaments & Brackets)')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8" x-data="{ createModalOpen: false }">
    @include('management.partials.nav')

    <!-- TOP CONTROLS & NEW TOURNAMENT BUTTON -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 p-4 rounded-xl bg-[#090b10] border border-white/5">
        <div class="text-xs font-mono text-zinc-400">
            TOTAL CAMPAIGNS: <strong class="text-white">{{ $tournaments->count() }}</strong>
            <span class="text-zinc-600 mx-2">|</span>
            ONGOING: <strong class="text-amber-400">{{ $tournaments->where('status', 'ongoing')->count() }}</strong>
            <span class="text-zinc-600 mx-2">|</span>
            COMPLETED: <strong class="text-emerald-400">{{ $tournaments->where('status', 'completed')->count() }}</strong>
        </div>

        <button @click="createModalOpen = true" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider text-xs font-mono transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-trophy"></i> Register New Tournament
        </button>
    </div>

    <!-- TOURNAMENTS LIST -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($tournaments as $tour)
        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 hover:border-yellow-500/30 transition flex flex-col justify-between space-y-5 group">
            <div class="space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider bg-yellow-500/10 text-yellow-400 border border-yellow-500/30">
                            {{ strtoupper(str_replace('_', ' ', $tour->tournament_format)) }}
                        </span>
                        <h2 class="text-xl font-black text-white font-sans mt-2 group-hover:text-yellow-400 transition">
                            {{ $tour->name }}
                        </h2>
                        @if($tour->organizer)
                        <div class="text-xs font-mono text-zinc-400">
                            Organizer: <span class="text-zinc-300 font-bold">{{ $tour->organizer }}</span>
                        </div>
                        @endif
                    </div>

                    <span class="px-2.5 py-1 rounded text-[10px] font-mono font-bold uppercase tracking-wider shrink-0
                        @if($tour->status === 'ongoing') bg-amber-500/20 text-amber-400 border border-amber-500/30
                        @elseif($tour->status === 'completed') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @elseif($tour->status === 'upcoming') bg-blue-500/20 text-blue-400 border border-blue-500/30
                        @else bg-zinc-800 text-zinc-400
                        @endif">
                        {{ $tour->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs font-mono pt-3 border-t border-zinc-800/80">
                    <div>
                        <div class="text-zinc-500 text-[10px] uppercase">PRIZE POOL</div>
                        <div class="text-yellow-400 font-bold text-sm">{{ $tour->prize_pool ?: 'Non-Cash / Prestige' }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-500 text-[10px] uppercase">SQUAD DEPLOYED</div>
                        <div class="text-white font-bold">{{ $tour->squad->squad_name ?? 'Luxury Elite Alpha' }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-500 text-[10px] uppercase">GAME MODE</div>
                        <div class="text-zinc-300">{{ $tour->gameMode->name ?? 'Delta Force Detonation' }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-500 text-[10px] uppercase">ACHIEVEMENT / PLACEMENT</div>
                        <div class="text-emerald-400 font-bold">
                            @if($tour->placement)
                                <i class="fa-solid fa-medal"></i> {{ $tour->placement }}
                            @else
                                <span class="text-zinc-600 font-normal">Belum Berakhir</span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($tour->notes)
                <div class="text-xs font-mono text-zinc-400 italic">
                    Catatan: "{{ $tour->notes }}"
                </div>
                @endif
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-zinc-800/80">
                <span class="text-[11px] font-mono text-zinc-500">
                    <i class="fa-solid fa-sitemap text-yellow-500/70 mr-1"></i> {{ $tour->matches->count() }} Match Fixtures
                </span>
                <a href="{{ route('management.tournaments.show', $tour->id) }}" class="px-4 py-2 rounded-lg bg-zinc-800 hover:bg-yellow-500 hover:text-black text-zinc-200 font-bold uppercase tracking-wider text-xs font-mono transition flex items-center gap-2">
                    <span>Buka Bagan &amp; Fixtures</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-2 p-12 text-center rounded-2xl bg-[#090b10] border border-white/5 space-y-3 font-mono">
            <div class="text-zinc-500 text-sm">Belum ada turnamen terdaftar.</div>
            <button @click="createModalOpen = true" class="px-4 py-2 rounded-lg bg-yellow-500 text-black font-bold text-xs uppercase">
                Register First Tournament
            </button>
        </div>
        @endforelse
    </div>

    <!-- MODAL: REGISTER TOURNAMENT -->
    <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-lg w-full p-6 space-y-5 shadow-2xl overflow-y-auto max-h-[90vh]" @click.away="createModalOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-trophy text-yellow-400"></i> Register New Tournament
                </h3>
                <button @click="createModalOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <form action="{{ route('management.tournaments.store') }}" method="POST" class="space-y-4 text-xs font-mono">
                @csrf
                <div>
                    <label class="block text-zinc-400 mb-1">NAMA TURNAMEN <span class="text-yellow-400">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Delta Force Invitational Championship 2026"
                        class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">ORGANIZER / PENYELENGGARA</label>
                        <input type="text" name="organizer" placeholder="Contoh: TiMi Studios / ESL"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">PRIZE POOL</label>
                        <input type="text" name="prize_pool" placeholder="Contoh: Rp 25.000.000"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">FORMAT BAGAN <span class="text-yellow-400">*</span></label>
                        <select name="tournament_format" required class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="single_elimination">Single Elimination (Sistem Gugur)</option>
                            <option value="double_elimination">Double Elimination (Upper &amp; Lower)</option>
                            <option value="group_stage">Group Stage + Playoff</option>
                            <option value="round_robin">Round Robin (Klasemen Poin)</option>
                            <option value="custom">Custom Format</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">STATUS TURNAMEN <span class="text-yellow-400">*</span></label>
                        <select name="status" required class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="upcoming">Upcoming (Akan Datang)</option>
                            <option value="ongoing">Ongoing (Sedang Berjalan)</option>
                            <option value="completed">Completed (Selesai)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">GAME MODE</label>
                        <select name="game_mode_id" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            @foreach($gameModes as $mode)
                                <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">SQUAD DEPLOYED</label>
                        <select name="squad_id" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="">Main Roster / All Stars</option>
                            @foreach($squads as $sq)
                                <option value="{{ $sq->id }}">{{ $sq->squad_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">TANGGAL MULAI</label>
                        <input type="date" name="start_date"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">TANGGAL SELESAI</label>
                        <input type="date" name="end_date"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                </div>

                <div>
                    <label class="block text-zinc-400 mb-1">CATATAN &amp; STRATEGI KHUSUS</label>
                    <textarea name="notes" rows="2" placeholder="Informasi peraturan turnamen, link bracket eksternal, atau roster cadangan..."
                        class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider transition">
                        Register Tournament
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
