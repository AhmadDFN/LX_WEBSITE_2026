@extends('layouts.app')

@section('title', 'Recruitment Triage - Management Console')
@section('page_title', 'Recruitment Application Triage')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    @include('management.partials.nav')

    <!-- HEADER STATS -->
    <div class="flex justify-between items-center p-4 rounded-xl bg-[#090b10] border border-white/5">
        <div class="text-xs font-mono text-zinc-400">
            TOTAL APPLICANTS: <strong class="text-white">{{ $applications->count() }}</strong>
            <span class="text-zinc-600 mx-2">|</span>
            PENDING TRIAGE: <strong class="text-amber-400">{{ $applications->where('status', 'pending')->count() }}</strong>
            <span class="text-zinc-600 mx-2">|</span>
            ACCEPTED TRIAL: <strong class="text-emerald-400">{{ $applications->where('status', 'accepted_trial')->count() }}</strong>
        </div>
    </div>

    <!-- APPLICATIONS TABLE / CARDS -->
    <div class="space-y-4">
        @forelse($applications as $app)
        <div class="rounded-xl bg-obsidian-900/90 hud-border p-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <!-- Left Info -->
            <div class="space-y-2">
                <div class="flex items-center space-x-3">
                    <span class="text-lg font-black text-white">{{ $app->ign }}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                        @if($app->status === 'pending') bg-amber-500/20 text-amber-400 border border-amber-500/30
                        @elseif($app->status === 'accepted_trial') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @else bg-red-500/20 text-red-400 border border-red-500/30
                        @endif">
                        {{ strtoupper(str_replace('_', ' ', $app->status)) }}
                    </span>
                    <span class="text-xs font-mono text-gold-400 font-bold">{{ $app->rank_tier }}</span>
                </div>

                <div class="text-xs font-mono text-zinc-400 flex flex-wrap gap-x-4 gap-y-1">
                    <span>NAME: <strong class="text-zinc-200">{{ $app->full_name }}</strong></span>
                    <span>UID: <strong class="text-zinc-200">{{ $app->delta_force_uid }}</strong></span>
                    <span>DISCORD: <strong class="text-zinc-200">{{ $app->discord_tag }}</strong></span>
                    <span>TARGET MODE: <strong class="text-zinc-200">{{ $app->targetGameMode->name ?? 'All' }}</strong></span>
                    <span>CLASS: <strong class="text-zinc-200 uppercase">{{ $app->preferred_class }}</strong></span>
                </div>

                @if($app->reviewer_notes)
                <div class="text-xs font-mono text-zinc-500 italic mt-1">
                    Notes: "{{ $app->reviewer_notes }}"
                </div>
                @endif
            </div>

            <!-- Right Actions -->
            <div class="flex items-center space-x-3 w-full md:w-auto justify-end">
                @if($app->proof_screenshot)
                <a href="{{ asset('storage/' . $app->proof_screenshot) }}" target="_blank" class="px-3 py-1.5 rounded bg-carbon-800 hover:bg-carbon-700 border border-zinc-700 text-xs font-mono text-zinc-300 transition-colors">
                    VIEW PROOF
                </a>
                @endif

                @if($app->status === 'pending')
                <form action="{{ route('management.applications.process', $app->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="action" value="approve_trial">
                    <button type="submit" class="px-3.5 py-1.5 rounded bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/40 text-emerald-400 text-xs font-mono font-bold uppercase transition-colors">
                        APPROVE TRIAL
                    </button>
                </form>

                <form action="{{ route('management.applications.process', $app->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="action" value="reject">
                    <button type="submit" class="px-3 py-1.5 rounded bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 text-red-400 text-xs font-mono font-bold uppercase transition-colors">
                        REJECT
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="p-10 rounded-xl bg-obsidian-900/60 border border-zinc-800 text-center font-mono text-xs text-zinc-500">
            No recruitment applications submitted in the system.
        </div>
        @endforelse
    </div>

</div>
@endsection
