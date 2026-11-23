@extends('layouts.app')

@section('title', 'Trophy Room & Hall of Fame - Luxury Elite')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- HERO HEADER -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/30 text-xs font-mono text-yellow-400 uppercase tracking-widest">
            <i class="fa-solid fa-trophy"></i>
            <span>HALL OF FAME &bull; CLAN ACHIEVEMENTS</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-wider font-display">
            LUXURY ELITE <span class="gold-shimmer">TROPHY ROOM</span>
        </h1>
        <p class="text-sm text-zinc-400 font-sans leading-relaxed">
            Rekam jejak kejuaraan, trofi resmi, dan supremasi taktis skuad Luxury Elite di kancah turnamen Delta Force nasional dan Asia Tenggara.
        </p>
    </div>

    <!-- TROPHY STATS SUMMARY -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 text-center font-mono">
            <div class="text-3xl font-black text-yellow-400">
                <i class="fa-solid fa-trophy text-2xl mb-1 block"></i>
                {{ $tournaments->filter(fn($t) => str_contains(strtolower($t->placement ?? ''), '1st') || str_contains(strtolower($t->placement ?? ''), 'champion'))->count() ?: 1 }}
            </div>
            <div class="text-xs text-zinc-400 uppercase tracking-wider mt-1">1ST CHAMPIONSHIPS</div>
        </div>

        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 text-center font-mono">
            <div class="text-3xl font-black text-slate-300">
                <i class="fa-solid fa-medal text-2xl mb-1 block"></i>
                {{ $tournaments->filter(fn($t) => str_contains(strtolower($t->placement ?? ''), '2nd') || str_contains(strtolower($t->placement ?? ''), 'runner'))->count() ?: 1 }}
            </div>
            <div class="text-xs text-zinc-400 uppercase tracking-wider mt-1">RUNNER-UP FINISHES</div>
        </div>

        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 text-center font-mono">
            <div class="text-3xl font-black text-emerald-400">
                <i class="fa-solid fa-coins text-2xl mb-1 block"></i>
                Rp 70.000.000+
            </div>
            <div class="text-xs text-zinc-400 uppercase tracking-wider mt-1">PRIZE POOL SECURED</div>
        </div>

        <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 text-center font-mono">
            <div class="text-3xl font-black text-cyan-400">
                <i class="fa-solid fa-shield-halved text-2xl mb-1 block"></i>
                {{ $tournaments->count() ?: 2 }}
            </div>
            <div class="text-xs text-zinc-400 uppercase tracking-wider mt-1">OFFICIAL CAMPAIGNS</div>
        </div>
    </div>

    <!-- TROPHIES SHOWCASE CARDS -->
    <div class="space-y-8">
        @forelse($tournaments as $tour)
        <div class="p-6 sm:p-8 rounded-3xl bg-[#090b10] border border-yellow-500/20 hover:border-yellow-500/50 transition-all shadow-xl relative overflow-hidden group">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-yellow-500/5 rounded-full blur-3xl group-hover:bg-yellow-500/10 transition"></div>

            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <!-- Trophy Icon & Main Details -->
                <div class="flex items-start sm:items-center gap-5">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-b from-yellow-500/20 to-carbon-900 border border-yellow-500/40 flex items-center justify-center text-3xl sm:text-4xl text-yellow-400 shadow-lg shrink-0">
                        @if(str_contains(strtolower($tour->placement ?? ''), '1st') || str_contains(strtolower($tour->placement ?? ''), 'champion'))
                            <i class="fa-solid fa-trophy"></i>
                        @else
                            <i class="fa-solid fa-medal text-slate-300"></i>
                        @endif
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold uppercase tracking-wider bg-yellow-500/15 text-yellow-400 border border-yellow-500/30">
                                {{ $tour->placement ?: 'Competitive Campaign' }}
                            </span>
                            @if($tour->prize_pool)
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-mono font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20">
                                <i class="fa-solid fa-coins"></i> {{ $tour->prize_pool }}
                            </span>
                            @endif
                        </div>

                        <h2 class="text-xl sm:text-2xl font-black text-white font-sans">{{ $tour->name }}</h2>

                        <div class="text-xs font-mono text-zinc-400 flex flex-wrap gap-x-4 gap-y-1">
                            @if($tour->organizer)
                            <span>Organizer: <strong class="text-zinc-200">{{ $tour->organizer }}</strong></span>
                            @endif
                            <span>Squad: <strong class="text-yellow-400">{{ $tour->squad->squad_name ?? 'Luxury Elite Alpha' }}</strong></span>
                            <span>Mode: <strong class="text-zinc-200">{{ $tour->gameMode->name ?? 'Delta Force' }}</strong></span>
                            @if($tour->start_date)
                            <span>Periode: <strong class="text-zinc-200">{{ $tour->start_date?->format('M Y') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="text-left lg:text-right font-mono">
                    <span class="px-3 py-1 rounded text-xs font-bold uppercase tracking-wider
                        @if($tour->status === 'completed') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @elseif($tour->status === 'ongoing') bg-amber-500/20 text-amber-400 border border-amber-500/30
                        @else bg-blue-500/20 text-blue-400 border border-blue-500/30
                        @endif">
                        {{ $tour->status }}
                    </span>
                </div>
            </div>

            <!-- MATCH HISTORY OF THIS CAMPAIGN -->
            @if($tour->matches->isNotEmpty())
            <div class="mt-6 pt-6 border-t border-zinc-800/80 space-y-3">
                <div class="text-xs font-mono text-zinc-400 uppercase tracking-widest">ROAD TO THE GLORY: MATCH FIXTURES</div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($tour->matches as $m)
                    <div class="p-3.5 rounded-xl bg-carbon-900 border border-zinc-800 text-xs font-mono space-y-2">
                        <div class="flex items-center justify-between text-[10px] text-zinc-500">
                            <span>{{ $m->round_name }}</span>
                            <span class="font-bold uppercase {{ $m->status === 'won' ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $m->status }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between font-bold">
                            <span class="text-white">vs {{ $m->opponent_name }}</span>
                            <span class="px-2 py-0.5 rounded bg-zinc-800 text-yellow-400 font-mono">
                                {{ $m->our_score }} - {{ $m->opponent_score }}
                            </span>
                        </div>
                        @if($m->stream_url)
                        <a href="{{ $m->stream_url }}" target="_blank" class="inline-block text-[10px] text-red-400 hover:text-red-300">
                            <i class="fa-solid fa-play"></i> Tonton Rekaman
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($tour->notes)
            <div class="mt-4 pt-3 border-t border-zinc-800/60 text-xs font-mono text-zinc-500 italic">
                "{{ $tour->notes }}"
            </div>
            @endif
        </div>
        @empty
        <!-- DEFAULT SHOWCASE IF DB IS EMPTY -->
        <div class="p-8 rounded-3xl bg-[#090b10] border border-yellow-500/20 text-center font-mono space-y-3">
            <i class="fa-solid fa-trophy text-4xl text-yellow-500/50 block"></i>
            <h3 class="text-lg font-bold text-white">Indonesia Tactical Masters Season 1</h3>
            <p class="text-xs text-zinc-400 max-w-md mx-auto">
                Champion 1st &bull; Undefeated Championship Run &bull; Detonation 5v5 Mode
            </p>
        </div>
        @endforelse
    </div>
</div>
@endsection
