@extends('layouts.app')

@section('title', 'Luxury Elite - Official Website')

@section('content')
<div class="min-h-screen bg-[#020612] text-white font-sans overflow-x-hidden">

    <!-- HERO SECTION (EXACT SVELTE LAYOUT & SPACING) -->
    <section class="relative min-h-screen flex items-center pt-20 px-6 md:px-12">
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 left-[-5%] w-[55%] h-full bg-gradient-to-br from-blue-950/40 to-transparent transform skew-x-[-12deg] border-r border-blue-500/10"
            ></div>
            <div
                class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-cyan-600/10 rounded-full blur-[120px] animate-pulse"
            ></div>
        </div>

        <div class="container mx-auto flex flex-col md:flex-row items-center relative z-10 w-full">
            <div class="w-full md:w-1/2 flex justify-center items-center relative h-[50vh] md:h-[80vh]">
                <img
                    src="{{ asset('images/logo-lx.png') }}"
                    alt="LX Logo Background"
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[90%] opacity-10 blur-[8px] z-0 pointer-events-none select-none"
                />
                <div class="float-anim z-10">
                    <img
                        src="{{ asset('images/logo-lx.png') }}"
                        alt="LX Main Visual"
                        class="max-h-[500px] md:max-h-[600px] object-contain drop-shadow-[0_0_50px_rgba(6,182,212,0.3)] transition-transform duration-500 hover:scale-105"
                    />
                </div>
            </div>

            <div class="w-full md:w-1/2 flex flex-col items-start space-y-6 mt-10 md:mt-0">
                <div>
                    <h2 class="text-cyan-400 font-mono tracking-[0.5em] text-sm md:text-base mb-2 uppercase">
                        // Tactical Delta Force
                    </h2>
                    <h1 class="text-4xl sm:text-5xl md:text-5xl lg:text-6xl xl:text-8xl font-black leading-none tracking-tighter break-words text-white">
                        WELCOME TO <br />
                        <span class="gold-shimmer italic">LUXURY ELITE</span>
                    </h1>
                </div>

                <p class="text-base md:text-lg xl:text-xl text-gray-400 font-light max-w-xl leading-relaxed border-l-2 border-cyan-500 pl-4 sm:pl-6">
                    Uniting <span class="text-white font-medium">Ultimate Skill</span>, Precision Strategy, and
                    <span class="text-white font-medium">Pure Elegance</span>. Dominate the battlefield with the elite.
                </p>

                <div class="flex flex-wrap gap-6 pt-4">
                    <a
                        href="#roster"
                        class="group relative px-10 py-4 overflow-hidden rounded-sm bg-cyan-600 font-bold uppercase tracking-[0.2em] text-sm text-black transition-all inline-block shadow-lg shadow-cyan-600/30"
                    >
                        <span class="relative z-10">Meet The Team</span>
                        <div class="absolute inset-0 bg-white translate-y-[100%] group-hover:translate-y-0 transition-transform duration-300"></div>
                    </a>

                    <a
                        href="{{ route('join.squad') }}"
                        class="px-10 py-4 border border-yellow-500/50 text-yellow-500 font-bold uppercase tracking-[0.2em] text-sm rounded-sm hover:bg-yellow-500/10 transition-all duration-300 flex items-center gap-2"
                    >
                        Join Squad
                        <span class="text-xs">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ROSTER SECTION (EXACT SVELTE LAYOUT, SPACING & CARDS) -->
    <section id="roster" class="max-w-7xl mx-auto px-6 py-32 relative scroll-mt-12">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-cyan-500/5 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

        <div class="mb-20 text-center md:text-left">
            <p class="text-cyan-400 uppercase tracking-[0.6em] text-sm font-bold animate-pulse">
                Luxury Elite Members
            </p>
            <h2 class="text-7xl font-black mt-4 tracking-tighter uppercase italic text-white">
                LX <span class="text-transparent" style="-webkit-text-stroke: 1px white; opacity: 0.5;">ROSTER</span>
            </h2>
        </div>

        <!-- 
          Base grid diubah menjadi 6 kolom untuk menampung fraksi matematika yang fleksibel. 
          grid-cols-1 (Mobile), md:grid-cols-6 (Tablet/Desktop)
        -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-x-8 gap-y-12 mb-20">
            @php
                $total = count($players);
            @endphp

            @foreach ($players as $i => $player)
                @php
                    $spanClasses = 'col-span-1 md:col-span-3 lg:col-span-2';
                    if ($total % 2 !== 0 && $i === $total - 1) {
                        $spanClasses = str_replace('md:col-span-3', 'md:col-span-6', $spanClasses);
                    }
                    $rem = $total % 3;
                    if ($rem === 1 && $i === $total - 1) {
                        $spanClasses = str_replace('lg:col-span-2', 'lg:col-span-6', $spanClasses);
                    } elseif ($rem === 2 && $i >= $total - 2) {
                        $spanClasses = str_replace('lg:col-span-2', 'lg:col-span-3', $spanClasses);
                    }
                @endphp

                <div
                    class="opacity-0 animate-[fadeInUp_0.5s_ease_forwards] flex justify-center w-full {{ $spanClasses }}"
                    style="animation-delay: {{ 0.1 + $i * 0.15 }}s;"
                >
                    <!-- Wrapper max-w-md untuk menjaga aspect ratio gambar agar tidak menjadi raksasa saat span 1 halaman penuh -->
                    <div class="w-full max-w-md transition-all duration-500">
                        <div class="group relative bg-white/5 border border-white/10 rounded-[2rem] overflow-hidden transition-all duration-500 hover:border-cyan-400/50 hover:shadow-[0_0_40px_rgba(6,182,212,0.15)]">
                            <div class="absolute -inset-px bg-gradient-to-br from-cyan-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-0"></div>

                            <div class="relative z-10">
                                <div class="relative overflow-hidden aspect-[4/5]">
                                    <img
                                        src="{{ asset($player['image']) }}"
                                        alt="{{ $player['nickname'] }}"
                                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000 ease-out"
                                    />

                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0a] via-transparent to-transparent opacity-90"></div>

                                    <div class="absolute top-6 right-6">
                                        <span class="{{ strtolower($player['status']) === 'active' ? 'bg-cyan-500 shadow-[0_0_15px_rgba(6,182,212,0.5)]' : 'bg-yellow-500 shadow-[0_0_15px_rgba(234,179,8,0.5)]' }} text-black text-[10px] px-4 py-1.5 rounded-full uppercase tracking-[0.2em] font-black italic transition-transform duration-500 group-hover:scale-110">
                                            {{ $player['status'] }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-8 relative">
                                    <div class="absolute top-0 left-8 w-12 h-[2px] bg-cyan-500 transition-all duration-500 group-hover:w-24"></div>

                                    <p class="text-cyan-400 uppercase text-[11px] tracking-[0.4em] font-medium mb-1">
                                        {{ $player['role'] }}
                                    </p>

                                    <h2 class="text-4xl font-black text-white tracking-tighter italic uppercase group-hover:text-cyan-400 transition-colors duration-300">
                                        {{ $player['nickname'] }}
                                    </h2>

                                    <div class="mt-4 h-1 w-full bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full bg-cyan-500 w-0 group-hover:w-full transition-all duration-700 delay-100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
