@extends('layouts.app')

@section('title', $tournament->name . ' - Bracket & Fixtures')
@section('page_title', 'Tournament Bracket & Match Operations')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8" x-data="{
    addMatchOpen: false,
    scoreMatchOpen: false,
    editTourOpen: false,
    selectedMatch: null,
    openScore(match) {
        this.selectedMatch = match;
        this.scoreMatchOpen = true;
    }
}">
    @include('management.partials.nav')

    <!-- TOURNAMENT HERO BANNER -->
    <div class="p-6 sm:p-8 rounded-2xl bg-[#090b10] border border-white/5 space-y-6 relative overflow-hidden">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider bg-yellow-500/10 text-yellow-400 border border-yellow-500/30">
                        {{ strtoupper(str_replace('_', ' ', $tournament->tournament_format)) }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider
                        @if($tournament->status === 'ongoing') bg-amber-500/20 text-amber-400 border border-amber-500/30
                        @elseif($tournament->status === 'completed') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @else bg-blue-500/20 text-blue-400 border border-blue-500/30
                        @endif">
                        {{ $tournament->status }}
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white font-sans">{{ $tournament->name }}</h1>
                <div class="text-xs font-mono text-zinc-400 flex flex-wrap gap-x-5 gap-y-1">
                    @if($tournament->organizer)
                    <span>Organizer: <strong class="text-zinc-200">{{ $tournament->organizer }}</strong></span>
                    @endif
                    <span>Squad: <strong class="text-zinc-200">{{ $tournament->squad->squad_name ?? 'Main Roster' }}</strong></span>
                    <span>Game Mode: <strong class="text-zinc-200">{{ $tournament->gameMode->name ?? 'Delta Force' }}</strong></span>
                    @if($tournament->start_date)
                    <span>Date: <strong class="text-zinc-200">{{ $tournament->start_date?->format('d M Y') }}</strong></span>
                    @endif
                </div>
            </div>

            <!-- PRIZE & PLACEMENT BADGES -->
            <div class="flex items-center gap-4 flex-wrap">
                <div class="p-3.5 rounded-xl bg-carbon-900 border border-zinc-800 text-center font-mono">
                    <div class="text-[10px] text-zinc-500 uppercase">PRIZE POOL</div>
                    <div class="text-lg font-black text-yellow-400">{{ $tournament->prize_pool ?: '-' }}</div>
                </div>

                <div class="p-3.5 rounded-xl bg-carbon-900 border border-zinc-800 text-center font-mono">
                    <div class="text-[10px] text-zinc-500 uppercase">OFFICIAL PLACEMENT</div>
                    <div class="text-lg font-black {{ $tournament->placement ? 'text-emerald-400' : 'text-zinc-500' }}">
                        {{ $tournament->placement ?: 'In Progress' }}
                    </div>
                </div>

                <button @click="editTourOpen = true" class="px-3.5 py-3 rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-mono text-xs transition">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </button>
            </div>
        </div>
    </div>

    <!-- BRACKET / FIXTURES SECTION -->
    <div class="space-y-6">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-sitemap text-yellow-400"></i>
                <h2 class="text-sm font-bold uppercase tracking-wider text-white">Match Fixtures &amp; Tournament Bracket</h2>
            </div>
            <button @click="addMatchOpen = true" class="px-3.5 py-1.5 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider text-xs font-mono transition flex items-center gap-1.5">
                <i class="fa-solid fa-plus"></i> Add Match Fixture
            </button>
        </div>

        <!-- FIXTURE CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($tournament->matches as $match)
            <div class="p-5 rounded-2xl bg-[#090b10] border border-white/5 hover:border-zinc-700 transition space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-[11px] font-mono text-zinc-400 border-b border-zinc-800/80 pb-2">
                        <span class="font-bold text-yellow-400">#{{ $match->match_order }} &bull; {{ $match->round_name }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                            @if($match->status === 'won') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                            @elseif($match->status === 'lost') bg-red-500/20 text-red-400 border border-red-500/30
                            @elseif($match->status === 'ongoing') bg-amber-500/20 text-amber-400 border border-amber-500/30
                            @else bg-zinc-800 text-zinc-400
                            @endif">
                            {{ $match->status }}
                        </span>
                    </div>

                    <!-- TEAMS & SCORES BATTLE -->
                    <div class="space-y-2 py-1">
                        <!-- Luxury Elite -->
                        <div class="flex items-center justify-between font-mono">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                                <span class="font-bold text-sm text-white">Luxury Elite</span>
                            </div>
                            <span class="text-lg font-black text-white px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800">{{ $match->our_score }}</span>
                        </div>

                        <!-- Opponent -->
                        <div class="flex items-center justify-between font-mono">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                <span class="font-bold text-sm text-zinc-300">{{ $match->opponent_name }}</span>
                            </div>
                            <span class="text-lg font-black text-zinc-300 px-2 py-0.5 rounded bg-zinc-900 border border-zinc-800">{{ $match->opponent_score }}</span>
                        </div>
                    </div>

                    @if($match->notes)
                    <div class="text-[11px] font-mono text-zinc-500 italic">
                        {{ $match->notes }}
                    </div>
                    @endif
                </div>

                <div class="pt-3 border-t border-zinc-800/80 flex items-center justify-between">
                    @if($match->stream_url)
                    <a href="{{ $match->stream_url }}" target="_blank" class="text-xs text-red-400 hover:text-red-300 font-mono flex items-center gap-1">
                        <i class="fa-solid fa-video"></i> Live Stream
                    </a>
                    @else
                    <span class="text-[11px] font-mono text-zinc-600">No stream link</span>
                    @endif

                    <button @click="openScore({{ json_encode($match) }})" class="px-3 py-1 rounded bg-zinc-800 hover:bg-yellow-500 hover:text-black text-zinc-300 font-bold transition text-xs font-mono">
                        Update Score
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full p-12 text-center rounded-2xl bg-[#090b10] border border-white/5 space-y-3 font-mono">
                <div class="text-zinc-500 text-sm">Belum ada bagan match yang ditambahkan untuk turnamen ini.</div>
                <button @click="addMatchOpen = true" class="px-4 py-2 rounded-lg bg-yellow-500 text-black font-bold text-xs uppercase">
                    Add First Round Fixture
                </button>
            </div>
            @endforelse
        </div>
    </div>

    <!-- MODAL 1: ADD FIXTURE -->
    <div x-show="addMatchOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-md w-full p-6 space-y-5 shadow-2xl" @click.away="addMatchOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-plus text-yellow-400"></i> Add Match Fixture
                </h3>
                <button @click="addMatchOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <form action="{{ route('management.tournaments.matches.store', $tournament->id) }}" method="POST" class="space-y-4 text-xs font-mono">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">NAMA RONDE <span class="text-yellow-400">*</span></label>
                        <input type="text" name="round_name" required placeholder="e.g. Quarter Finals"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">URUTAN MATCH <span class="text-yellow-400">*</span></label>
                        <input type="number" name="match_order" value="{{ $tournament->matches->count() + 1 }}" min="1" required
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                </div>

                <div>
                    <label class="block text-zinc-400 mb-1">NAMA CLAN / TIM LAWAN <span class="text-yellow-400">*</span></label>
                    <input type="text" name="opponent_name" required placeholder="Contoh: Rex Regum Qeon / Fnatic"
                        class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">STATUS</label>
                        <select name="status" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="scheduled">Scheduled</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="won">Won (Menang)</option>
                            <option value="lost">Lost (Gugur)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">JADWAL TANDING</label>
                        <input type="datetime-local" name="scheduled_at"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                </div>

                <div>
                    <label class="block text-zinc-400 mb-1">STREAM URL (OPTIONAL)</label>
                    <input type="url" name="stream_url" placeholder="https://youtube.com/live/..."
                        class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                </div>

                <div>
                    <label class="block text-zinc-400 mb-1">CATATAN MATCH</label>
                    <textarea name="notes" rows="2" placeholder="Map pick atau aturan match..."
                        class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                    <button type="button" @click="addMatchOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider transition">
                        Add to Bracket
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: UPDATE MATCH SCORE -->
    <div x-show="scoreMatchOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-md w-full p-6 space-y-5 shadow-2xl" @click.away="scoreMatchOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-flag-checkered text-yellow-400"></i> Update Match Score
                </h3>
                <button @click="scoreMatchOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <template x-if="selectedMatch">
                <form :action="'{{ url('/management/tournaments/matches') }}/' + selectedMatch.id + '/update'" method="POST" class="space-y-4 text-xs font-mono">
                    @csrf
                    <div>
                        <div class="text-zinc-400">ROUND &amp; OPPONENT</div>
                        <div class="text-white text-sm font-bold mt-0.5" x-text="selectedMatch.round_name + ' vs ' + selectedMatch.opponent_name"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-zinc-400 mb-1">SKOR LUXURY ELITE</label>
                            <input type="number" name="our_score" :value="selectedMatch.our_score" min="0" required
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-zinc-400 mb-1">SKOR LAWAN</label>
                            <input type="number" name="opponent_score" :value="selectedMatch.opponent_score" min="0" required
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">HASIL PERTANDINGAN</label>
                        <select name="status" :value="selectedMatch.status" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="won">WON (Menang &amp; Lanjut Babak Berikutnya)</option>
                            <option value="lost">LOST (Kalah / Gugur)</option>
                            <option value="ongoing">ONGOING (Sedang Berjalan)</option>
                            <option value="scheduled">SCHEDULED</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">STREAM / VOD URL</label>
                        <input type="url" name="stream_url" :value="selectedMatch.stream_url" placeholder="https://..."
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">CATATAN HASIL</label>
                        <textarea name="notes" rows="2" :value="selectedMatch.notes"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                        <button type="button" @click="scoreMatchOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-black font-bold uppercase tracking-wider transition">
                            Save Score
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- MODAL 3: EDIT TOURNAMENT OVERVIEW & PLACEMENT -->
    <div x-show="editTourOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-md w-full p-6 space-y-5 shadow-2xl" @click.away="editTourOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-trophy text-yellow-400"></i> Edit Tournament Standing
                </h3>
                <button @click="editTourOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <form action="{{ route('management.tournaments.update', $tournament->id) }}" method="POST" class="space-y-4 text-xs font-mono">
                @csrf
                <div>
                    <label class="block text-zinc-400 mb-1">NAMA TURNAMEN</label>
                    <input type="text" name="name" value="{{ $tournament->name }}" required
                        class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">ORGANIZER</label>
                        <input type="text" name="organizer" value="{{ $tournament->organizer }}"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">PRIZE POOL</label>
                        <input type="text" name="prize_pool" value="{{ $tournament->prize_pool }}"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-zinc-400 mb-1">STATUS TURNAMEN</label>
                        <select name="status" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="upcoming" {{ $tournament->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            <option value="ongoing" {{ $tournament->status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ $tournament->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-zinc-400 mb-1">PLACEMENT (GELAR)</label>
                        <input type="text" name="placement" value="{{ $tournament->placement }}" placeholder="e.g. Champion 1st"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>
                </div>

                <div>
                    <label class="block text-zinc-400 mb-1">CATATAN AKHIR</label>
                    <textarea name="notes" rows="2" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">{{ $tournament->notes }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                    <button type="button" @click="editTourOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider transition">
                        Update Tournament
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
