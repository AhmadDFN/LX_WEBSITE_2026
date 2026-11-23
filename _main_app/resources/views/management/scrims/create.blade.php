@extends('layouts.app')

@section('title', 'Schedule Scrim - Management Console')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <!-- HEADER -->
    <div class="border-b border-gold-500/20 pb-4 flex justify-between items-center">
        <div>
            <div class="text-xs font-mono text-gold-400 uppercase tracking-widest mb-1">COMMAND CONSOLE</div>
            <h1 class="text-3xl font-black text-white uppercase">SCHEDULE NEW SCRIM</h1>
        </div>
        <a href="{{ route('matches') }}" class="text-xs font-mono text-zinc-400 hover:text-gold-400 uppercase">&larr; Back to Matches</a>
    </div>

    @if ($errors->any())
    <div class="p-4 rounded-lg bg-red-950/40 border border-red-500/40 text-red-300 font-mono text-xs">
        <div class="font-bold uppercase tracking-wider mb-1">[INPUT VALIDATION FAILED]</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('management.scrims.store') }}" method="POST" class="rounded-xl bg-obsidian-900/90 hud-border p-6 sm:p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Opponent Clan Name <span class="text-red-400">*</span></label>
                <input type="text" name="opponent_name" value="{{ old('opponent_name') }}" required 
                       class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500"
                       placeholder="e.g. Apex Predators Esports">
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Game Mode <span class="text-red-400">*</span></label>
                <select name="game_mode_id" required class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500">
                    @foreach($gameModes as $mode)
                        <option value="{{ $mode->id }}">{{ $mode->name }} ({{ $mode->team_size }}v{{ $mode->team_size }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Squad Formation</label>
                <select name="squad_id" class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500">
                    <option value="">Auto-Assign / Main Roster</option>
                    @foreach($squads as $sq)
                        <option value="{{ $sq->id }}">{{ $sq->squad_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Match Type <span class="text-red-400">*</span></label>
                <select name="match_type" required class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500">
                    <option value="scrim">Clan Scrim (Practice)</option>
                    <option value="tournament">Official Tournament</option>
                    <option value="exhibition">Exhibition Showcase</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Match Date <span class="text-red-400">*</span></label>
                <input type="date" name="match_date" value="{{ old('match_date', now()->addDay()->toDateString()) }}" required 
                       class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500">
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Match Time (WIB) <span class="text-red-400">*</span></label>
                <input type="time" name="match_time" value="{{ old('match_time', '20:00') }}" required 
                       class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500">
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Format <span class="text-red-400">*</span></label>
                <select name="format" required class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500">
                    <option value="BO1">Best of 1 (BO1)</option>
                    <option value="BO3" selected>Best of 3 (BO3)</option>
                    <option value="BO5">Best of 5 (BO5)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Custom Room ID (Optional)</label>
                <input type="text" name="room_id" value="{{ old('room_id') }}" 
                       class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 font-mono"
                       placeholder="e.g. ASIA-LX-991">
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Room Password (Optional)</label>
                <input type="text" name="room_password" value="{{ old('room_password') }}" 
                       class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 font-mono"
                       placeholder="e.g. lx2026">
            </div>
        </div>

        <div>
            <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Briefing / Tactical Notes</label>
            <textarea name="notes" rows="3" class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500" placeholder="Map veto rules, special server settings..."></textarea>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-8 py-3 rounded text-sm font-bold uppercase tracking-wider text-black bg-gradient-to-r from-gold-400 to-gold-500 hover:from-gold-300 hover:to-gold-400 shadow-md shadow-gold-500/20">
                SCHEDULE SCRIM FIXTURE
            </button>
        </div>
    </form>

</div>
@endsection
