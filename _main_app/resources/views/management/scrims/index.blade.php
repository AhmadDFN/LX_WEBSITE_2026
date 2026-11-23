@extends('layouts.app')

@section('title', 'Scrim Management - Luxury Elite')
@section('page_title', '2. Management Scrim & Sparring')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8" x-data="{
    resultModalOpen: false,
    selectedScrim: null,
    openResult(scrim) {
        this.selectedScrim = scrim;
        this.resultModalOpen = true;
    }
}">
    @include('management.partials.nav')

    <!-- TOP CONTROLS & SCHEDULE BUTTON -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 p-4 rounded-xl bg-[#090b10] border border-white/5">
        <div class="text-xs font-mono text-zinc-400">
            TOTAL FIXTURES: <strong class="text-white">{{ $scrims->count() }}</strong>
            <span class="text-zinc-600 mx-2">|</span>
            SCHEDULED: <strong class="text-cyan-400">{{ $scrims->where('status', 'scheduled')->count() }}</strong>
            <span class="text-zinc-600 mx-2">|</span>
            COMPLETED: <strong class="text-emerald-400">{{ $scrims->where('status', 'completed')->count() }}</strong>
        </div>

        <a href="{{ route('management.scrims.create') }}" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider text-xs font-mono transition flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus"></i> Schedule New Scrim
        </a>
    </div>

    <!-- SCRIM LIST -->
    <div class="space-y-4">
        @forelse($scrims as $scrim)
        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 hover:border-yellow-500/20 transition flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6" x-data="{ revealSecret: false }">
            <!-- Left Info -->
            <div class="space-y-3 w-full lg:w-auto">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider bg-yellow-500/10 text-yellow-400 border border-yellow-500/30">
                        {{ $scrim->format }}
                    </span>
                    <span class="text-lg font-black text-white font-sans">vs {{ $scrim->opponent_name }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                        @if($scrim->status === 'scheduled') bg-blue-500/20 text-blue-400 border border-blue-500/30
                        @elseif($scrim->status === 'completed') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @elseif($scrim->status === 'ongoing') bg-amber-500/20 text-amber-400 border border-amber-500/30
                        @else bg-zinc-800 text-zinc-400
                        @endif">
                        {{ $scrim->status }}
                    </span>
                    <span class="text-xs font-mono text-zinc-400">({{ ucfirst($scrim->match_type) }})</span>
                </div>

                <div class="text-xs font-mono text-zinc-400 flex flex-wrap gap-x-5 gap-y-1">
                    <span><i class="fa-regular fa-calendar text-yellow-500"></i> {{ $scrim->match_date?->format('d M Y') }}</span>
                    <span><i class="fa-regular fa-clock text-yellow-500"></i> {{ substr($scrim->match_time, 0, 5) }} WIB</span>
                    <span><i class="fa-solid fa-gamepad text-yellow-500"></i> {{ $scrim->gameMode->name ?? 'Delta Force' }}</span>
                    <span><i class="fa-solid fa-shield text-yellow-500"></i> {{ $scrim->squad->squad_name ?? 'Main Roster' }}</span>
                </div>

                <!-- ROOM CREDENTIALS (TACTICAL VAULT) -->
                <div class="flex items-center gap-2 text-xs font-mono bg-zinc-900/90 border border-zinc-800 rounded-lg px-3 py-1.5 w-fit">
                    <span class="text-zinc-500">TACTICAL ROOM:</span>
                    <template x-if="revealSecret">
                        <span class="text-yellow-400 font-bold">
                            ID: {{ $scrim->room_id ?: 'TBD' }} | PW: {{ $scrim->room_password ?: 'TBD' }}
                        </span>
                    </template>
                    <template x-if="!revealSecret">
                        <span class="text-zinc-600 font-bold">••••••••••••••</span>
                    </template>
                    <button @click="revealSecret = !revealSecret" class="ml-2 text-zinc-400 hover:text-white transition text-[11px]">
                        <i :class="revealSecret ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'"></i>
                    </button>
                </div>

                @if($scrim->notes)
                <div class="text-xs font-mono text-zinc-400 italic">
                    Briefing: "{{ $scrim->notes }}"
                </div>
                @endif
            </div>

            <!-- Right Actions & Score -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto justify-end border-t lg:border-t-0 border-zinc-800 pt-4 lg:pt-0">
                @if($scrim->status === 'completed' && $scrim->result)
                    <div class="p-3 rounded-xl bg-carbon-900 border border-zinc-800 text-center font-mono">
                        <div class="text-[10px] text-zinc-500 uppercase">FINAL SCORE</div>
                        <div class="text-xl font-black {{ $scrim->result->result === 'victory' ? 'text-emerald-400' : 'text-red-400' }}">
                            {{ $scrim->result->our_score }} - {{ $scrim->result->opponent_score }}
                            <span class="text-xs uppercase font-bold">({{ $scrim->result->result }})</span>
                        </div>
                    </div>
                @endif

                <div class="flex items-center gap-2 flex-wrap">
                    @if($scrim->status !== 'completed')
                        <button @click="openResult({{ json_encode($scrim) }})" class="px-3.5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-black font-bold uppercase tracking-wider text-xs font-mono transition flex items-center gap-1.5">
                            <i class="fa-solid fa-flag-checkered"></i> Log Result &amp; Skor
                        </button>
                    @endif

                    <a href="{{ route('management.scrims.edit', $scrim->id) }}" class="px-3 py-2 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-zinc-300 font-bold uppercase tracking-wider text-xs font-mono transition">
                        Edit
                    </a>

                    <a href="{{ route('matches.show', $scrim->id) }}" target="_blank" class="px-3 py-2 rounded-lg bg-carbon-900 hover:bg-zinc-800 border border-zinc-800 text-zinc-400 hover:text-white text-xs font-mono transition" title="Lihat Halaman Publik">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center rounded-2xl bg-[#090b10] border border-white/5 space-y-3 font-mono">
            <div class="text-zinc-500 text-sm">Belum ada pertandingan scrim terdaftar.</div>
            <a href="{{ route('management.scrims.create') }}" class="inline-block px-4 py-2 rounded-lg bg-yellow-500 text-black font-bold text-xs uppercase">
                Schedule First Scrim
            </a>
        </div>
        @endforelse
    </div>

    <!-- MODAL: LOG MATCH RESULT & COACH REVIEW -->
    <div x-show="resultModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-lg w-full p-6 space-y-5 shadow-2xl overflow-y-auto max-h-[90vh]" @click.away="resultModalOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-trophy text-yellow-400"></i> Log Scrim Result &amp; Evaluasi
                </h3>
                <button @click="resultModalOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <template x-if="selectedScrim">
                <form :action="'{{ url('/management/scrims') }}/' + selectedScrim.id + '/result'" method="POST" class="space-y-4 text-xs font-mono">
                    @csrf
                    <div>
                        <div class="text-zinc-400">FIXTURE</div>
                        <div class="text-white text-sm font-bold mt-0.5" x-text="'vs ' + selectedScrim.opponent_name + ' (' + selectedScrim.format + ')'"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-zinc-400 mb-1">SKOR LUXURY ELITE <span class="text-yellow-400">*</span></label>
                            <input type="number" name="our_score" min="0" required placeholder="Contoh: 2"
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-zinc-400 mb-1">SKOR LAWAN <span class="text-yellow-400">*</span></label>
                            <input type="number" name="opponent_score" min="0" required placeholder="Contoh: 1"
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">OUTCOME RESULT <span class="text-yellow-400">*</span></label>
                        <select name="result" required class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="victory">VICTORY (Kemenangan)</option>
                            <option value="defeat">DEFEAT (Kekalahan)</option>
                            <option value="draw">DRAW (Imbang)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">RINGKASAN MAP PLAYED</label>
                        <textarea name="maps_played" rows="2" placeholder="Map 1: Zero Dam (11-7 Win), Map 2: Brakkesh (9-11 Loss), Map 3: Ascension (11-5 Win)"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-zinc-400 mb-1">LINK VOD / REKAMAN</label>
                            <input type="url" name="vod_url" placeholder="https://youtube.com/..."
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-zinc-400 mb-1">URL SCREENSHOT SCOREBOARD</label>
                            <input type="text" name="screenshot_url" placeholder="URL bukti screenshot"
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">EVALUASI PELATIH / COACH REVIEW</label>
                        <textarea name="coach_notes" rows="3" placeholder="Catatan taktik untuk pemain (misal: rotasi timing, utility usage, adaptasi defense)..."
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                        <button type="button" @click="resultModalOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-black font-bold uppercase tracking-wider transition">
                            Save &amp; Complete Scrim
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>
@endsection
