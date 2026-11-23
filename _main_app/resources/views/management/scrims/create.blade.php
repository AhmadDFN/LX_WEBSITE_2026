@extends('layouts.app')

@section('title', 'Schedule Scrim - Management Console')
@section('page_title', 'Schedule New Scrim')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    @include('management.partials.nav')

    @if ($errors->any())
    <div class="p-4 rounded-xl bg-red-950/40 border border-red-500/40 text-red-300 font-mono text-xs">
        <div class="font-bold uppercase tracking-wider mb-1">[INPUT VALIDATION FAILED]</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('management.scrims.store') }}" method="POST" class="rounded-2xl bg-[#090b10] border border-white/5 p-6 sm:p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Opponent Clan Name <span class="text-yellow-400">*</span></label>
                <input type="text" name="opponent_name" value="{{ old('opponent_name') }}" required 
                       class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400"
                       placeholder="e.g. Apex Predators Esports">
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Game Mode <span class="text-yellow-400">*</span></label>
                <select name="game_mode_id" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400">
                    @foreach($gameModes as $mode)
                        <option value="{{ $mode->id }}">{{ $mode->name }} ({{ $mode->team_size }}v{{ $mode->team_size }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Squad Formation</label>
                <select name="squad_id" class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400">
                    <option value="">Auto-Assign / Main Roster</option>
                    @foreach($squads as $sq)
                        <option value="{{ $sq->id }}">{{ $sq->squad_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Match Type <span class="text-yellow-400">*</span></label>
                <select name="match_type" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400">
                    <option value="scrim">Sparring / Scrim</option>
                    <option value="tournament">Official Tournament Match</option>
                    <option value="exhibition">Exhibition / Showmatch</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Match Date <span class="text-yellow-400">*</span></label>
                <input type="date" name="match_date" value="{{ old('match_date') }}" required 
                       class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400">
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Time (WIB) <span class="text-yellow-400">*</span></label>
                <input type="time" name="match_time" value="{{ old('match_time') }}" required 
                       class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400">
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Format <span class="text-yellow-400">*</span></label>
                <select name="format" required class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400">
                    <option value="BO1">Best of 1 (BO1)</option>
                    <option value="BO3" selected>Best of 3 (BO3)</option>
                    <option value="BO5">Best of 5 (BO5)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Custom Room ID</label>
                <input type="text" name="room_id" value="{{ old('room_id') }}" 
                       class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400"
                       placeholder="e.g. DELTA-9821">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Custom Room Password</label>
                <input type="text" name="room_password" value="{{ old('room_password') }}" 
                       class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400"
                       placeholder="e.g. lx2026">
            </div>
        </div>

        <div>
            <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Tactical Briefing / Notes</label>
            <textarea name="notes" rows="3" 
                      class="w-full bg-zinc-900 border border-zinc-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:outline-none focus:border-yellow-400"
                      placeholder="Briefing strategi, map pick, atau kontak manager lawan...">{{ old('notes') }}</textarea>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-zinc-800">
            <a href="{{ route('management.scrims.index') }}" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 text-xs font-mono transition">
                &larr; Batal &amp; Kembali
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider text-xs font-mono transition">
                Register &amp; Deploy Scrim
            </button>
        </div>
    </form>
</div>
@endsection
