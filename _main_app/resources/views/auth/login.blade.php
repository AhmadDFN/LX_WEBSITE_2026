@extends('layouts.app')

@section('title', 'Terminal Authorization - Login')

@section('content')
<div class="max-w-md mx-auto px-4 py-16 space-y-8">

    <!-- HEADER -->
    <div class="text-center space-y-2">
        <div class="w-14 h-14 mx-auto rounded-md bg-gradient-to-br from-gold-400 via-gold-500 to-amber-700 flex items-center justify-center font-black text-black text-2xl shadow-xl shadow-gold-500/20">
            LX
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight">
            TERMINAL <span class="text-gold-500">AUTHENTICATION</span>
        </h1>
        <p class="text-xs font-mono text-zinc-400 uppercase tracking-widest">
            RESTRICTED MILITARY CLEARANCE SECTOR
        </p>
    </div>

    <!-- ERROR ALERT -->
    @if ($errors->any())
    <div class="p-4 rounded-lg bg-red-950/40 border border-red-500/40 text-red-300 font-mono text-xs">
        <div class="font-bold uppercase tracking-wider mb-1">[AUTHENTICATION REJECTED]</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- LOGIN FORM -->
    <form action="{{ route('login.perform') }}" method="POST" class="rounded-xl bg-obsidian-900/90 hud-border p-6 sm:p-8 space-y-6">
        @csrf

        <div>
            <label class="block text-xs font-mono text-zinc-300 uppercase mb-1">Operator Identifier (Email) <span class="text-red-400">*</span></label>
            <input type="email" name="email" id="email_input" value="{{ old('email') }}" required autofocus
                   class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-mono"
                   placeholder="operator@luxuryelite.web.id">
        </div>

        <div>
            <div class="flex justify-between items-center mb-1">
                <label class="block text-xs font-mono text-zinc-300 uppercase">Access Passkey / Password <span class="text-red-400">*</span></label>
            </div>
            <input type="password" name="password" id="password_input" required 
                   class="w-full bg-obsidian-950 border border-zinc-700 rounded px-3.5 py-2.5 text-sm text-white focus:border-gold-500 focus:outline-none font-mono"
                   placeholder="••••••••••••">
        </div>

        <div class="flex items-center justify-between text-xs font-mono">
            <label class="flex items-center space-x-2 text-zinc-400 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded bg-obsidian-950 border-zinc-700 text-gold-500 focus:ring-0">
                <span>MAINTAIN LINK (REMEMBER)</span>
            </label>
        </div>

        <button type="submit" class="w-full py-3 rounded text-sm font-black uppercase tracking-wider text-black bg-gradient-to-r from-gold-400 via-gold-500 to-amber-600 hover:from-gold-300 hover:to-gold-400 shadow-lg shadow-gold-500/20 active:scale-95 transition-all">
            AUTHORIZE OPERATOR ACCESS
        </button>
    </form>

    <!-- DEMO CREDENTIAL SHORTCUTS WIDGET -->
    <div class="p-4 rounded-lg bg-carbon-900/80 border border-zinc-800 text-xs font-mono space-y-3" x-data>
        <div class="text-[11px] text-gold-400 font-bold uppercase tracking-wider flex items-center justify-between">
            <span>TACTICAL DEMO CREDENTIALS:</span>
            <span class="text-zinc-500">1-CLICK FILL</span>
        </div>

        <div class="grid grid-cols-1 gap-2">
            <button type="button" 
                    @click="document.getElementById('email_input').value = 'admin@luxuryelite.web.id'; document.getElementById('password_input').value = 'password123';"
                    class="p-2 rounded bg-obsidian-950 hover:bg-zinc-800 border border-zinc-700 text-left flex justify-between items-center transition-colors">
                <div>
                    <span class="text-white font-bold block">admin@luxuryelite.web.id</span>
                    <span class="text-[10px] text-zinc-400 block">Password: password123</span>
                </div>
                <span class="px-1.5 py-0.5 rounded text-[9px] bg-red-500/20 text-red-400 font-bold uppercase">SUPERADMIN</span>
            </button>

            <button type="button" 
                    @click="document.getElementById('email_input').value = 'coach@luxuryelite.web.id'; document.getElementById('password_input').value = 'password123';"
                    class="p-2 rounded bg-obsidian-950 hover:bg-zinc-800 border border-zinc-700 text-left flex justify-between items-center transition-colors">
                <div>
                    <span class="text-white font-bold block">coach@luxuryelite.web.id</span>
                    <span class="text-[10px] text-zinc-400 block">Password: password123</span>
                </div>
                <span class="px-1.5 py-0.5 rounded text-[9px] bg-amber-500/20 text-amber-400 font-bold uppercase">COACH</span>
            </button>

            <button type="button" 
                    @click="document.getElementById('email_input').value = 'irzell@luxuryelite.web.id'; document.getElementById('password_input').value = 'password123';"
                    class="p-2 rounded bg-obsidian-950 hover:bg-zinc-800 border border-zinc-700 text-left flex justify-between items-center transition-colors">
                <div>
                    <span class="text-white font-bold block">irzell@luxuryelite.web.id</span>
                    <span class="text-[10px] text-zinc-400 block">Password: password123</span>
                </div>
                <span class="px-1.5 py-0.5 rounded text-[9px] bg-emerald-500/20 text-emerald-400 font-bold uppercase">PLAYER (CAPTAIN)</span>
            </button>
        </div>
    </div>

</div>
@endsection
