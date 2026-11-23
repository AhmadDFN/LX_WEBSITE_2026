@extends('layouts.app')

@section('title', 'Join Squad - Delta Force Recruitment')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <!-- HEADER -->
    <div class="border-b border-gold-500/20 pb-6 text-center">
        <div class="inline-flex items-center space-x-2 text-xs font-mono text-gold-400 uppercase tracking-widest mb-2">
            <span class="w-2 h-2 rounded-full bg-gold-400 animate-pulse"></span>
            <span>RECRUITMENT PROTOCOL INITIATED</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-white uppercase tracking-tight">
            JOIN <span class="text-gold-500">LUXURY ELITE</span>
        </h1>
        <p class="text-zinc-400 text-sm max-w-xl mx-auto mt-2 font-light">
            Submit your military credentials for the Delta Force division. Applications undergo rigorous statistical screening by Clan Command.
        </p>
    </div>

    <!-- ERROR LIST -->
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

    <!-- FORM -->
    <form action="{{ route('join.squad.store') }}" method="POST" enctype="multipart/form-data" class="rounded-xl bg-obsidian-900/90 hud-border p-6 sm:p-10 space-y-8">
        @csrf

        <!-- SECTION 1: IDENTITY -->
        <div>
            <div class="text-xs font-mono text-gold-400 uppercase tracking-wider mb-4 flex items-center space-x-2">
                <span class="w-1.5 h-1.5 bg-gold-400"></span>
                <span>OPERATOR IDENTIFICATION</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Full Legal / Real Name <span class="text-red-400">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required 
                           class="w-full bg-obsidian-950 border border-zinc-700/80 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-sans"
                           placeholder="e.g. John Doe">
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Delta Force IGN <span class="text-red-400">*</span></label>
                    <input type="text" name="ign" value="{{ old('ign') }}" required 
                           class="w-full bg-obsidian-950 border border-zinc-700/80 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-sans"
                           placeholder="e.g. VORTEX`LX">
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">In-Game Official UID <span class="text-red-400">*</span></label>
                    <input type="text" name="delta_force_uid" value="{{ old('delta_force_uid') }}" required 
                           class="w-full bg-obsidian-950 border border-zinc-700/80 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-mono"
                           placeholder="e.g. DF-8947291">
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Discord Tag / Username <span class="text-red-400">*</span></label>
                    <input type="text" name="discord_tag" value="{{ old('discord_tag') }}" required 
                           class="w-full bg-obsidian-950 border border-zinc-700/80 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-mono"
                           placeholder="e.g. vortex_delta">
                </div>
            </div>
        </div>

        <!-- SECTION 2: COMBAT ROLE & SPECIALIZATION -->
        <div class="border-t border-zinc-800 pt-6">
            <div class="text-xs font-mono text-gold-400 uppercase tracking-wider mb-4 flex items-center space-x-2">
                <span class="w-1.5 h-1.5 bg-gold-400"></span>
                <span>TACTICAL ROLE & PREFERRED DIVISION</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Target Game Mode <span class="text-red-400">*</span></label>
                    <select name="target_game_mode_id" required 
                            class="w-full bg-obsidian-950 border border-zinc-700/80 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-sans">
                        @foreach($gameModes as $mode)
                            <option value="{{ $mode->id }}" {{ old('target_game_mode_id') == $mode->id ? 'selected' : '' }}>
                                {{ $mode->name }} ({{ $mode->team_size }}v{{ $mode->team_size }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Preferred Operator Class <span class="text-red-400">*</span></label>
                    <select name="preferred_class" required 
                            class="w-full bg-obsidian-950 border border-zinc-700/80 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-sans">
                        <option value="assault" {{ old('preferred_class') == 'assault' ? 'selected' : '' }}>Assault (Breacher / Spearhead)</option>
                        <option value="engineer" {{ old('preferred_class') == 'engineer' ? 'selected' : '' }}>Engineer (Armor & Heavy Ordnance)</option>
                        <option value="support" {{ old('preferred_class') == 'support' ? 'selected' : '' }}>Support (Combat Medic / Ammo Supply)</option>
                        <option value="recon" {{ old('preferred_class') == 'recon' ? 'selected' : '' }}>Recon (Precision Marksman / Drone Recon)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Current Competitive Rank <span class="text-red-400">*</span></label>
                    <input type="text" name="rank_tier" value="{{ old('rank_tier') }}" required 
                           class="w-full bg-obsidian-950 border border-zinc-700/80 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-sans"
                           placeholder="e.g. Master IV or Pinnacle">
                </div>
            </div>
        </div>

        <!-- SECTION 3: SCREENSHOT PROOF UPLOAD -->
        <div class="border-t border-zinc-800 pt-6">
            <div class="text-xs font-mono text-gold-400 uppercase tracking-wider mb-2 flex items-center space-x-2">
                <span class="w-1.5 h-1.5 bg-gold-400"></span>
                <span>IN-GAME STATISTICAL PROOF (OPTIONAL)</span>
            </div>
            <p class="text-xs text-zinc-400 mb-3">Upload a clean screenshot of your profile KD ratio, Win rate, and Rank tier (Max 4MB: PNG, JPG, WEBP).</p>

            <div class="border-2 border-dashed border-zinc-700 hover:border-gold-500/60 rounded-lg p-6 text-center bg-obsidian-950/60 transition-colors">
                <input type="file" name="proof_screenshot" accept="image/*" class="w-full text-xs text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-mono file:font-bold file:bg-carbon-800 file:text-gold-400 hover:file:bg-carbon-700">
            </div>
        </div>

        <!-- SUBMIT BUTTON -->
        <div class="pt-4 flex justify-end">
            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded text-sm font-black uppercase tracking-wider text-black bg-gradient-to-r from-gold-400 via-gold-500 to-amber-600 hover:from-gold-300 hover:to-gold-400 transition-all shadow-lg shadow-gold-500/25 active:scale-95">
                TRANSMIT RECRUITMENT APPLICATION
            </button>
        </div>
    </form>

</div>
@endsection
