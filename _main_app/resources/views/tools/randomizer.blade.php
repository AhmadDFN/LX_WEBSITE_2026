<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUXURY ELITE — Delta Force 20v20 Draft & Randomizer</title>

    <!-- Web Favicon & App Icons from LX Official Logo -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Rajdhani (Combat Esports), Plus Jakarta Sans (Modern UI), Teko (Bold Display) & JetBrains Mono (Tactical Telemetry) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Rajdhani:wght@500;600;700;800&family=Teko:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SheetJS (Export & Import Excel/CSV) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- html2canvas (Export High-Res PNG) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Tone.js (Sound Effects for Wheel & Winner) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tone/14.8.49/Tone.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
                        display: ['Rajdhani', '"Plus Jakarta Sans"', 'sans-serif'],
                        combat: ['Teko', 'Rajdhani', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        obsidian: '#07090e',
                        panel: '#0e1320',
                        card: '#131929',
                        gold: {
                            300: '#fef08a',
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                        },
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom scrollbar for sleek esports aesthetic */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #07090e;
        }
        ::-webkit-scrollbar-thumb {
            background: #222c40;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #eab308;
        }

        body {
            background-color: #07090e;
            background-image:
                radial-gradient(circle at 15% 10%, rgba(234, 179, 8, 0.09), transparent 38%),
                radial-gradient(circle at 85% 20%, rgba(6, 182, 212, 0.08), transparent 38%),
                radial-gradient(circle at 50% 90%, rgba(244, 63, 94, 0.06), transparent 42%);
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'Plus Jakarta Sans', Inter, sans-serif;
        }

        .tactical-grid {
            background-size: 32px 32px;
            background-image: linear-gradient(to right, rgba(255,255,255,0.025) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.025) 1px, transparent 1px);
        }

        .glow-gold {
            box-shadow: 0 0 24px rgba(234, 179, 8, 0.25);
        }

        /* Gold Shimmer effect (identical to Luxury Elite Landing Page) */
        .gold-shimmer {
            background: linear-gradient(
                to right,
                #fde047 20%,
                #ca8a04 40%,
                #fde047 60%,
                #ca8a04 80%
            );
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: goldShine 5s linear infinite;
        }

        @keyframes goldShine {
            to {
                background-position: 200% center;
            }
        }

        .wheel-pointer {
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.8));
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 12px rgba(250, 204, 21, 0.35); }
            50% { box-shadow: 0 0 28px rgba(250, 204, 21, 0.8); }
        }
        .animate-winner {
            animation: pulseGlow 1.5s infinite;
        }

        /* Tactical Crate / Case Opening Animation Styles */
        .crate-viewport {
            mask-image: linear-gradient(to right, transparent 0%, black 12%, black 88%, transparent 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 12%, black 88%, transparent 100%);
        }

        /* Cyber Radar Spin Animation */
        @keyframes radarSweep {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .radar-sweep {
            background: conic-gradient(from 0deg, rgba(250, 204, 21, 0.42) 0deg, rgba(250, 204, 21, 0.08) 55deg, transparent 90deg);
            animation: radarSweep 2.2s linear infinite;
        }
        .radar-sweep-fast {
            animation: radarSweep 0.65s linear infinite;
        }

        /* Tactical Board Card Drop-In Animation */
        @keyframes cardDropIn {
            0% {
                opacity: 0;
                transform: translateY(-16px) scale(0.95);
                box-shadow: 0 0 0 rgba(250, 204, 21, 0);
            }
            60% {
                opacity: 1;
                transform: translateY(2px) scale(1.01);
                box-shadow: 0 0 22px rgba(250, 204, 21, 0.35);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            }
        }
        .animate-card-drop {
            animation: cardDropIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
        }
    </style>
</head>
<body class="text-slate-100 font-sans tactical-grid antialiased selection:bg-yellow-500/30 selection:text-yellow-200">

    <!-- ==================== HEADER / NAVBAR ==================== -->
    <header class="sticky top-0 z-40 border-b border-slate-800/80 bg-obsidian/95 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex flex-wrap items-center justify-between gap-4">
            <!-- Brand with Official LX Logo from Landing Page -->
            <a href="{{ route('home') }}" class="group flex items-center gap-3.5 transition-all">
                <div class="relative py-0.5 flex items-center justify-center shrink-0">
                    <img src="{{ asset('images/logo-lx.png') }}"
                         alt="Luxury Elite Logo"
                         class="h-11 sm:h-13 w-auto object-contain drop-shadow-[0_0_20px_rgba(234,179,8,0.4)] transition-transform duration-300 group-hover:scale-105">
                </div>
                <div class="border-l border-slate-700/80 pl-3.5">
                    <div class="flex items-center gap-2">
                        <h1 class="font-display font-extrabold text-xl sm:text-2xl tracking-wider uppercase leading-none">
                            <span class="text-white">LUXURY</span> <span class="gold-shimmer">ELITE</span>
                        </h1>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-mono font-bold tracking-widest uppercase rounded bg-yellow-500/15 text-yellow-400 border border-yellow-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                            Delta Force
                        </span>
                    </div>
                    <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">
                        Tactical 20v20 Draft &amp; Balancing • <span class="text-yellow-400/90 font-mono font-semibold">Credit: iRzell</span>
                    </p>
                </div>
            </a>

            <!-- Live Quick Stats & Controls -->
            <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                <div class="flex items-center gap-2.5 sm:gap-3 px-3.5 py-1.5 rounded-xl bg-panel/90 border border-slate-800 text-xs font-mono shadow-inner">
                    <span class="text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-users text-slate-500 text-[11px]"></i>
                        <span class="hidden sm:inline text-slate-400 font-sans text-xs">Total:</span>
                        <strong id="stat-total-players" class="text-white font-mono font-bold text-sm">0</strong>
                    </span>
                    <span class="text-slate-700">|</span>
                    <span class="text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-star text-yellow-400 text-[11px]"></i>
                        <span class="hidden sm:inline text-slate-400 font-sans text-xs">Pro:</span>
                        <strong id="stat-pro-players" class="text-yellow-400 font-mono font-bold text-sm">0</strong>
                    </span>
                    <span class="text-slate-700">|</span>
                    <span class="text-slate-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-emerald-400 text-[11px]"></i>
                        <span class="hidden sm:inline text-slate-400 font-sans text-xs">Slot:</span>
                        <strong id="stat-slots" class="text-emerald-400 font-mono font-bold text-sm">0/0</strong>
                    </span>
                </div>

                <!-- Return to Main Site -->
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl bg-panel hover:bg-yellow-500/10 border border-slate-800 hover:border-yellow-500/40 text-xs text-yellow-400 hover:text-yellow-300 font-bold flex items-center gap-2 transition duration-200">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span class="hidden sm:inline font-display tracking-wider uppercase">Kembali ke HQ</span>
                </a>

                <!-- Sound Toggle -->
                <button id="btn-sound" onclick="toggleSound()" title="Toggle Sound Effects"
                    class="p-2.5 rounded-xl bg-panel hover:bg-slate-800 border border-slate-800 hover:border-yellow-500/40 text-yellow-400 transition">
                    <i id="icon-sound" class="fa-solid fa-volume-high"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <nav class="flex gap-2 overflow-x-auto pb-1" aria-label="Tabs">
                <button onclick="switchTab('setup')" id="tab-setup"
                    class="tab-btn px-4 py-2.5 text-xs sm:text-sm font-display font-bold tracking-wider uppercase border-b-2 border-yellow-400 text-yellow-400 whitespace-nowrap flex items-center gap-2.5 transition">
                    <span class="w-5 h-5 rounded-md bg-yellow-500/20 text-yellow-400 text-[10px] font-mono flex items-center justify-center font-bold">01</span>
                    <i class="fa-solid fa-users-gear text-xs"></i> Roster &amp; Custom Tim
                </button>
                <button onclick="switchTab('wheel')" id="tab-wheel"
                    class="tab-btn px-4 py-2.5 text-xs sm:text-sm font-display font-bold tracking-wider uppercase border-b-2 border-transparent text-slate-400 hover:text-white whitespace-nowrap flex items-center gap-2.5 transition">
                    <span class="w-5 h-5 rounded-md bg-slate-800 text-slate-400 text-[10px] font-mono flex items-center justify-center font-bold">02</span>
                    <i class="fa-solid fa-dharmachakra text-xs"></i> Arena Draft &amp; Animasi
                </button>
                <button onclick="switchTab('board')" id="tab-board"
                    class="tab-btn px-4 py-2.5 text-xs sm:text-sm font-display font-bold tracking-wider uppercase border-b-2 border-transparent text-slate-400 hover:text-white whitespace-nowrap flex items-center gap-2.5 transition">
                    <span class="w-5 h-5 rounded-md bg-slate-800 text-slate-400 text-[10px] font-mono flex items-center justify-center font-bold">03</span>
                    <i class="fa-solid fa-trophy text-xs"></i> Hasil, Leader &amp; Export
                </button>
            </nav>
        </div>
    </header>

    <!-- ==================== MAIN CONTAINER ==================== -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

        <!-- ======================================================== -->
        <!-- TAB 1: ROSTER & CUSTOM TEAM SETUP                        -->
        <!-- ======================================================== -->
        <section id="view-setup" class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT: Player Input & Import (7 cols) -->
                <div class="lg:col-span-7 space-y-5">
                    <div class="bg-panel border border-slate-800 rounded-2xl p-5 shadow-xl">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                            <div>
                                <h2 class="font-display font-bold text-xl text-white flex items-center gap-2">
                                    <i class="fa-solid fa-user-plus text-yellow-400"></i> Input &amp; Import Player
                                </h2>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Format skill opsional: <code class="text-yellow-300 bg-slate-800/80 px-1.5 py-0.5 rounded">Nama, Pro</code> atau <code class="text-slate-300 bg-slate-800/80 px-1.5 py-0.5 rounded">Nama</code> (otomatis Normal)
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <button onclick="loadDemoPlayers()"
                                    class="px-3 py-1.5 rounded-xl bg-yellow-500/15 hover:bg-yellow-500/25 text-yellow-300 border border-yellow-500/30 text-xs font-semibold transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-wand-magic-sparkles"></i> Muat 40 Demo
                                </button>
                                <label class="cursor-pointer px-3 py-1.5 rounded-xl bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-300 border border-emerald-500/30 text-xs font-semibold transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-file-excel"></i> Import Excel/CSV
                                    <input type="file" id="file-import" accept=".xlsx,.xls,.csv" class="hidden" onchange="handleFileImport(event)">
                                </label>
                            </div>
                        </div>

                        <!-- Bulk Paste Textarea -->
                        <textarea id="bulk-input" rows="5"
                            placeholder="Tempel daftar nama player (1 nama per baris)&#10;Contoh:&#10;ipay, Pro&#10;troxxxy, Pro&#10;Xtreme&#10;Borneo"
                            class="w-full rounded-xl bg-obsidian border border-slate-700/80 focus:border-yellow-400 focus:ring-1 focus:ring-yellow-400 p-3 text-sm text-slate-100 placeholder-slate-500 outline-none transition"></textarea>

                        <div class="flex flex-wrap items-center justify-between gap-2 mt-3">
                            <div class="flex items-center gap-2">
                                <button onclick="addBulkPlayers('normal')"
                                    class="px-4 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-400 text-obsidian font-bold text-xs sm:text-sm transition flex items-center gap-2">
                                    <i class="fa-solid fa-plus"></i> Tambah ke Daftar
                                </button>
                                <button onclick="addBulkPlayers('pro')"
                                    class="px-3 py-2 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/30 font-semibold text-xs sm:text-sm transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-star"></i> Tambah sbg PRO
                                </button>
                            </div>
                            <button onclick="downloadImportTemplate()"
                                class="text-xs text-slate-400 hover:text-yellow-400 underline transition">
                                Download Template Excel
                            </button>
                        </div>
                    </div>

                    <!-- Active Player Roster List -->
                    <div class="bg-panel border border-slate-800 rounded-2xl p-5 shadow-xl">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                            <div class="flex items-center gap-2">
                                <h3 class="font-display font-bold text-lg text-white">Daftar Roster Aktif</h3>
                                <span id="badge-roster-count" class="px-2 py-0.5 rounded-full bg-slate-800 text-yellow-400 text-xs font-bold">0</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text" id="search-player" oninput="renderRosterList()" placeholder="Cari nama..."
                                    class="px-3 py-1.5 rounded-xl bg-obsidian border border-slate-700 text-xs text-white placeholder-slate-500 outline-none focus:border-yellow-400 w-36 sm:w-44">
                                <button onclick="confirmClearAllPlayers()"
                                    class="px-3 py-1.5 rounded-xl bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 border border-rose-500/30 text-xs font-semibold transition">
                                    <i class="fa-solid fa-trash"></i> Hapus Semua
                                </button>
                            </div>
                        </div>

                        <p class="text-xs text-slate-400 mb-3">
                            Klik badge <span class="text-yellow-400 font-semibold">PRO</span> / <span class="text-slate-300 font-semibold">NORMAL</span> pada tiap player untuk mengatur tier balancing.
                        </p>

                        <div id="roster-list" class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-96 overflow-y-auto pr-1">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Custom Factions & Teams Structure (5 cols) -->
                <div class="lg:col-span-5 space-y-5">
                    <div class="bg-panel border border-slate-800 rounded-2xl p-5 shadow-xl">
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <div>
                                <h2 class="font-display font-bold text-xl text-white flex items-center gap-2">
                                    <i class="fa-solid fa-shield-halved text-yellow-400"></i> Custom Fraksi &amp; Tim
                                </h2>
                                <p class="text-xs text-slate-400 mt-0.5">Atur nama fraksi, nama tim, &amp; kuota player per tim</p>
                            </div>
                            <button onclick="addFaction()"
                                class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-semibold transition">
                                <i class="fa-solid fa-plus"></i> Fraksi
                            </button>
                        </div>

                        <!-- Quick Preset Buttons -->
                        <div class="flex flex-wrap gap-2 mb-4 pb-4 border-b border-slate-800">
                            <button onclick="applyPreset20v20()"
                                class="px-3 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 text-xs text-slate-200 border border-slate-700 transition">
                                Reset Default 20v20 (5 Tim x 4)
                            </button>
                            <button onclick="shuffleTeamsAcrossFactions()"
                                class="px-3 py-1.5 rounded-lg bg-indigo-500/15 hover:bg-indigo-500/25 text-xs text-indigo-300 border border-indigo-500/30 transition flex items-center gap-1.5">
                                <i class="fa-solid fa-shuffle"></i> Acak Posisi Tim
                            </button>
                        </div>

                        <!-- Factions Editor Container -->
                        <div id="factions-config-list" class="space-y-4 max-h-[540px] overflow-y-auto pr-1">
                            <!-- Populated by JS -->
                        </div>

                        <div class="mt-5 pt-4 border-t border-slate-800 flex justify-end">
                            <button onclick="switchTab('wheel')"
                                class="w-full sm:w-auto px-6 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-400 hover:to-amber-400 text-obsidian font-display font-black uppercase tracking-wider text-sm shadow-lg glow-gold transition flex items-center justify-center gap-2">
                                Lanjut ke Arena Draft <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- TAB 2: WHEEL OF NAMES & MULTI-ANIMATION ARENA            -->
        <!-- ======================================================== -->
        <section id="view-wheel" class="hidden space-y-6">
            <!-- Control Bar -->
            <div class="bg-panel border border-slate-800 rounded-2xl p-4 shadow-xl flex flex-wrap items-center justify-between gap-4">
                <!-- Mode Selector: Full Random vs Balanced -->
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Mode Acak:</span>
                    <div class="inline-flex rounded-xl bg-obsidian p-1 border border-slate-800">
                        <button id="mode-balanced" onclick="setRandomMode('balanced')"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-yellow-500 text-obsidian">
                            <i class="fa-solid fa-scale-balanced"></i> Balancing (Pro/Normal)
                        </button>
                        <button id="mode-random" onclick="setRandomMode('random')"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white">
                            <i class="fa-solid fa-dice"></i> Full Random
                        </button>
                    </div>
                </div>

                <!-- Target Team Selector & Quick Actions -->
                <div class="flex flex-wrap items-center gap-2">
                    <select id="wheel-target-team" onchange="updateWheelTarget(this.value)"
                        class="px-3 py-2 rounded-xl bg-obsidian border border-slate-700 text-xs font-semibold text-white outline-none focus:border-yellow-400">
                        <option value="auto">Target: Otomatis (Isi Merata)</option>
                    </select>

                    <button onclick="instantRandomizeAll()"
                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition flex items-center gap-1.5 shadow">
                        <i class="fa-solid fa-bolt"></i> Acak Instan Semua
                    </button>

                    <button onclick="resetAllAssignments()"
                        class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs transition flex items-center gap-1.5">
                        <i class="fa-solid fa-rotate-left"></i> Reset Hasil
                    </button>
                </div>
            </div>

            <!-- Main Animation Stage + Live Draft Feed -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- ANIMATION STAGE (7 cols) -->
                <div class="lg:col-span-7 bg-panel border border-slate-800 rounded-2xl p-5 shadow-2xl flex flex-col items-center relative overflow-hidden">
                    <!-- Confetti Particle Overlay -->
                    <canvas id="confetti-canvas" class="pointer-events-none absolute inset-0 w-full h-full z-30"></canvas>

                    <!-- Animation Mode Switcher -->
                    <div class="w-full flex flex-wrap items-center justify-between gap-2 mb-3 pb-3 border-b border-slate-800/80">
                        <div class="inline-flex rounded-xl bg-obsidian p-1 border border-slate-800 gap-1">
                            <button id="anim-btn-wheel" onclick="setAnimStyle('wheel')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-yellow-500 text-obsidian">
                                <i class="fa-solid fa-dharmachakra"></i> Wheel
                            </button>
                            <button id="anim-btn-crate" onclick="setAnimStyle('crate')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white">
                                <i class="fa-solid fa-box-open"></i> Case Drop
                            </button>
                            <button id="anim-btn-decrypt" onclick="setAnimStyle('decrypt')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white">
                                <i class="fa-solid fa-satellite-dish"></i> Cyber Scan
                            </button>
                        </div>

                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-slate-300">Sisa: <strong id="wheel-remaining-count" class="text-yellow-400 text-sm">0</strong></span>
                        </div>
                    </div>

                    <!-- Next Target Status -->
                    <div class="w-full flex items-center justify-between text-xs text-slate-400 mb-3">
                        <span id="anim-mode-desc" class="text-slate-400">Mode Roda Putar Klasik</span>
                        <span>Tujuan: <strong id="wheel-next-target-label" class="text-emerald-400">-</strong></span>
                    </div>

                    <!-- ===== STAGE 1: SPINNING WHEEL ===== -->
                    <div id="stage-wheel" class="w-full flex items-center justify-center">
                        <div id="wheel-container" class="relative w-full max-w-[440px] aspect-square flex items-center justify-center my-2 select-none">
                            <canvas id="wheel-canvas" class="w-full h-full cursor-pointer" onclick="runDraftOnce()"></canvas>

                            <!-- Right Pointer Arrow -->
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 z-20 wheel-pointer pointer-events-none">
                                <svg width="42" height="36" viewBox="0 0 42 36" fill="none">
                                    <path d="M2 18L38 4V32L2 18Z" fill="#facc15" stroke="#090b10" stroke-width="3" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            <!-- Center Hub Button -->
                            <button onclick="runDraftOnce()" id="wheel-center-btn"
                                class="absolute z-20 w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-gradient-to-br from-obsidian via-slate-900 to-slate-800 border-4 border-yellow-400 shadow-2xl flex flex-col items-center justify-center hover:scale-105 active:scale-95 transition">
                                <span class="font-display font-bold text-yellow-400 text-lg leading-none">SPIN</span>
                                <span class="text-[9px] text-slate-400 uppercase tracking-widest mt-0.5">LX Draft</span>
                            </button>
                        </div>
                    </div>

                    <!-- ===== STAGE 2: TACTICAL CASE OPENING (ROULETTE STRIP) ===== -->
                    <div id="stage-crate" class="hidden w-full py-10 sm:py-16 flex flex-col items-center justify-center">
                        <div class="w-full relative rounded-2xl bg-obsidian border border-yellow-500/30 py-8 overflow-hidden shadow-inner">
                            <!-- Top & Bottom Tactical Accent Lines -->
                            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent opacity-70"></div>
                            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent opacity-70"></div>

                            <!-- Center Gold Laser Crosshair -->
                            <div class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-1 bg-yellow-400 z-20 shadow-[0_0_16px_rgba(250,204,21,0.95)] pointer-events-none"></div>
                            <div class="absolute top-1 left-1/2 -translate-x-1/2 z-20 text-yellow-400 text-xs pointer-events-none">
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                            <div class="absolute bottom-1 left-1/2 -translate-x-1/2 z-20 text-yellow-400 text-xs pointer-events-none">
                                <i class="fa-solid fa-caret-up"></i>
                            </div>

                            <!-- Scrolling Strip Viewport -->
                            <div id="crate-viewport" class="crate-viewport w-full overflow-hidden">
                                <div id="crate-track" class="flex items-center will-change-transform" style="gap: 12px;">
                                    <!-- Populated by JS -->
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-4 text-center">
                            <i class="fa-solid fa-crosshairs text-yellow-400 mr-1"></i> Operator yang berhenti tepat di garis laser emas akan masuk ke tim tujuan!
                        </p>
                    </div>

                    <!-- ===== STAGE 3: CYBER RADAR & TACTICAL DECRYPT ===== -->
                    <div id="stage-decrypt" class="hidden w-full py-6 sm:py-10 flex flex-col items-center justify-center">
                        <div class="relative w-full max-w-md rounded-2xl bg-obsidian border border-yellow-500/30 p-6 flex flex-col items-center justify-center overflow-hidden shadow-inner min-h-[320px]">
                            <!-- Radar Circles -->
                            <div class="relative w-44 h-44 rounded-full border border-yellow-500/30 flex items-center justify-center mb-5 overflow-hidden bg-slate-950/80">
                                <div class="absolute inset-4 rounded-full border border-yellow-500/20"></div>
                                <div class="absolute inset-10 rounded-full border border-yellow-500/15"></div>
                                <div class="absolute inset-x-0 top-1/2 h-px bg-yellow-500/20"></div>
                                <div class="absolute inset-y-0 left-1/2 w-px bg-yellow-500/20"></div>
                                <div id="radar-beam" class="absolute inset-0 rounded-full radar-sweep"></div>
                                <div class="relative z-10 flex flex-col items-center">
                                    <span id="decrypt-status-tag" class="px-2 py-0.5 rounded bg-yellow-500/20 border border-yellow-500/40 text-[10px] font-bold tracking-widest text-yellow-400 uppercase">
                                        STANDBY
                                    </span>
                                    <i id="decrypt-icon" class="fa-solid fa-user-secret text-3xl text-slate-300 mt-2"></i>
                                </div>
                            </div>

                            <!-- Scrambling Operator Name Terminal -->
                            <div class="w-full rounded-xl bg-slate-950 border border-slate-800 px-4 py-3 text-center">
                                <div class="text-[10px] font-mono uppercase tracking-widest text-slate-500 mb-1">DELTA FORCE // OPERATOR LOCK-ON</div>
                                <div id="decrypt-display-name" class="font-display font-bold text-2xl sm:text-3xl tracking-wider text-yellow-400 truncate">
                                    READY TO SCAN
                                </div>
                                <div id="decrypt-display-sub" class="text-[11px] font-mono text-emerald-400/90 mt-1">
                                    Menunggu perintah aktivasi...
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stage Action Controls -->
                    <div class="w-full flex flex-wrap items-center justify-center gap-3 mt-4 pt-4 border-t border-slate-800/80">
                        <button id="btn-spin-once" onclick="runDraftOnce()"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-400 hover:to-amber-400 text-obsidian font-display font-black uppercase tracking-wider text-sm shadow-lg glow-gold transition flex items-center gap-2">
                            <i class="fa-solid fa-play"></i> <span id="btn-spin-label">Putar 1x</span>
                        </button>
                        <button id="btn-auto-spin" onclick="toggleAutoSpin()"
                            class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-display font-black uppercase tracking-wider text-sm shadow-lg transition flex items-center gap-2">
                            <i class="fa-solid fa-forward"></i> Auto-Acak Semua
                        </button>
                        <button onclick="shuffleWheelEntries()"
                            class="px-4 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-display font-bold uppercase tracking-wider text-sm transition flex items-center gap-2">
                            <i class="fa-solid fa-shuffle"></i> Kocok Urutan
                        </button>
                    </div>
                </div>

                <!-- LIVE DRAFT BOARD PREVIEW (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    <!-- Latest Winner Banner -->
                    <div id="latest-winner-box" class="bg-gradient-to-r from-yellow-500/15 via-panel to-panel border border-yellow-500/30 rounded-2xl p-4 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-yellow-400">Terpilih Terakhir</p>
                            <h3 id="latest-winner-name" class="font-display font-bold text-2xl text-white mt-0.5">Siap Diputar!</h3>
                            <p id="latest-winner-dest" class="text-xs text-slate-400">Klik tombol SPIN untuk memulai draft</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-yellow-500/15 border border-yellow-500/30 flex items-center justify-center text-yellow-400 text-xl">
                            <i class="fa-solid fa-crosshairs"></i>
                        </div>
                    </div>

                    <!-- Live Compact Teams Progress -->
                    <div class="bg-panel border border-slate-800 rounded-2xl p-4 shadow-xl">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-display font-bold text-base text-white flex items-center gap-2">
                                <i class="fa-solid fa-list-check text-emerald-400"></i> Progress Pengisian Tim
                            </h3>
                            <button onclick="switchTab('board')" class="text-xs text-yellow-400 hover:underline font-semibold">
                                Buka Board Penuh &rarr;
                            </button>
                        </div>
                        <div id="live-compact-teams" class="space-y-3 max-h-[430px] overflow-y-auto pr-1">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ======================================================== -->
        <!-- TAB 3: FULL BRACKET, LEADER SELECTION & EXPORT           -->
        <!-- ======================================================== -->
        <section id="view-board" class="hidden space-y-6">

            <!-- Toolbar: Export & Manual Tools -->
            <div class="bg-panel border border-slate-800 rounded-2xl p-4 shadow-xl flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <button onclick="exportToPNG()"
                        class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-400 hover:to-amber-400 text-obsidian font-display font-black uppercase tracking-wider text-xs sm:text-sm shadow-lg glow-gold transition flex items-center gap-2">
                        <i class="fa-solid fa-image"></i> Download Gambar (PNG)
                    </button>
                    <button onclick="exportToExcel()"
                        class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-display font-black uppercase tracking-wider text-xs sm:text-sm shadow transition flex items-center gap-2">
                        <i class="fa-solid fa-file-excel"></i> Download Excel (.xlsx)
                    </button>
                    <button onclick="copyFormattedText()"
                        class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-display font-bold uppercase tracking-wider text-xs sm:text-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-copy"></i> Copy WA/Discord
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <label class="flex items-center gap-2 text-xs text-slate-300 cursor-pointer select-none">
                        <input type="checkbox" id="toggle-show-tier" checked onchange="renderMainBoard()"
                            class="rounded bg-obsidian border-slate-600 text-yellow-500 focus:ring-yellow-500">
                        Tampilkan Badge PRO
                    </label>
                    <button onclick="openTeamDraftModal()"
                        class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-bold shadow-lg transition flex items-center gap-1.5">
                        <i class="fa-solid fa-wand-magic-sparkles"></i> Acak Tim (Animasi)
                    </button>
                    <button onclick="shuffleTeamsAcrossFactions()"
                        class="px-3 py-2 rounded-xl bg-indigo-500/15 hover:bg-indigo-500/25 text-indigo-300 border border-indigo-500/30 text-xs font-semibold transition flex items-center gap-1.5">
                        <i class="fa-solid fa-shuffle"></i> Acak Instan
                    </button>
                </div>
            </div>

            <!-- Helper Banner for Manual Swap & Leader -->
            <div class="bg-card/80 border border-slate-800 rounded-xl px-4 py-2.5 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-300">
                <div class="flex flex-wrap items-center gap-4">
                    <span><i class="fa-solid fa-crown text-yellow-400 mr-1"></i> Klik ikon <strong>Mahkota</strong> untuk memilih <strong>Leader Tim</strong> (sorotan kuning).</span>
                    <span><i class="fa-solid fa-right-left text-sky-400 mr-1"></i> Klik ikon <strong>Tukar</strong> pada 2 player untuk menukar posisi secara manual.</span>
                </div>
                <div id="swap-status-pill" class="hidden px-3 py-1 rounded-lg bg-sky-500/20 border border-sky-500/40 text-sky-300 font-semibold flex items-center gap-2">
                    <span id="swap-status-text">Memilih player...</span>
                    <button onclick="cancelSwap()" class="text-white hover:text-rose-400"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>

            <!-- ==================== EXPORTABLE BOARD AREA ==================== -->
            <div id="export-board" class="bg-obsidian border border-slate-800 rounded-3xl p-5 sm:p-7 shadow-2xl space-y-6">
                <!-- Export Header Banner -->
                <div class="flex flex-wrap items-center justify-between gap-4 pb-5 border-b border-slate-800/90 relative">
                    <div class="flex items-center gap-4">
                        <div class="relative shrink-0 flex items-center justify-center">
                            <img src="{{ asset('images/logo-lx.png') }}"
                                 alt="Luxury Elite Logo"
                                 crossorigin="anonymous"
                                 class="h-14 sm:h-16 w-auto object-contain drop-shadow-[0_0_24px_rgba(234,179,8,0.5)]">
                        </div>
                        <div class="border-l border-slate-700/80 pl-4">
                            <div class="flex items-center gap-2.5">
                                <h2 class="font-display font-black text-2xl sm:text-3xl tracking-wider uppercase leading-none">
                                    <span class="text-white">LUXURY</span> <span class="gold-shimmer">ELITE</span>
                                </h2>
                                <span class="px-2.5 py-0.5 rounded-md bg-yellow-500/15 border border-yellow-500/40 text-yellow-400 text-[11px] font-mono font-bold tracking-widest uppercase">
                                    DELTA FORCE
                                </span>
                            </div>
                            <p id="export-subtitle" class="text-xs sm:text-sm text-slate-400 mt-1 font-sans">
                                Official Match Roster • 20 vs 20 Tactical Warfare
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div id="export-date" class="text-xs font-semibold text-slate-400"></div>
                        <div class="inline-flex items-center gap-1.5 mt-1 px-2.5 py-1 rounded-lg bg-yellow-400/15 border border-yellow-400/30 text-yellow-300 text-[11px] font-semibold">
                            <i class="fa-solid fa-crown text-yellow-400"></i> Sorotan Kuning = Squad Leader
                        </div>
                    </div>
                </div>

                <!-- Factions & Teams Grid -->
                <div id="board-factions-container" class="space-y-8">
                    <!-- Populated by JS -->
                </div>

                <!-- Export Board Footer with Credit -->
                <div class="pt-4 border-t border-slate-800/80 flex flex-wrap items-center justify-between gap-2 text-[11px] text-slate-500">
                    <span class="font-display tracking-widest uppercase text-slate-400">LX • LUXURY ELITE CLAN — DELTA FORCE</span>
                    <span class="font-semibold text-yellow-400/85">Credit : iRzell</span>
                </div>
            </div>

            <!-- Unassigned / Bench Players Pool -->
            <div class="bg-panel border border-slate-800 rounded-2xl p-5 shadow-xl">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                    <h3 class="font-display font-bold text-lg text-white flex items-center gap-2">
                        <i class="fa-solid fa-chair text-slate-400"></i> Belum Masuk Tim / Cadangan
                        <span id="bench-count" class="px-2 py-0.5 rounded-full bg-slate-800 text-yellow-400 text-xs">0</span>
                    </h3>
                    <span class="text-xs text-slate-400">Klik tombol <strong class="text-emerald-400">+ Isi Manual</strong> di kartu tim mana saja untuk memasukkan player cadangan.</span>
                </div>
                <div id="bench-list" class="flex flex-wrap gap-2">
                    <!-- Populated by JS -->
                </div>
            </div>
        </section>
    </main>

    <!-- ==================== GLOBAL FOOTER ==================== -->
    <footer class="max-w-7xl mx-auto px-4 sm:px-6 py-6 mt-4 border-t border-slate-800/70 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-500">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-lx.png') }}" alt="LX Logo" class="h-6 w-auto object-contain opacity-80">
            <span class="font-display font-bold text-slate-300 tracking-wider">LUXURY <span class="text-yellow-400">ELITE</span></span>
            <span>• Delta Force Tactical Randomizer</span>
        </div>
        <div class="px-3.5 py-1 rounded-full bg-panel border border-slate-800 text-slate-300 font-semibold font-mono">
            Credit: <span class="text-yellow-400">iRzell</span>
        </div>
    </footer>

    <!-- ==================== MODAL: MANUAL ASSIGN PLAYER ==================== -->
    <div id="modal-assign" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/75 backdrop-blur-sm p-4">
        <div class="bg-panel border border-slate-700 rounded-2xl max-w-md w-full p-5 shadow-2xl">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-display font-bold text-xl text-white">
                    Isi Manual ke <span id="modal-assign-team-name" class="text-yellow-400">Tim</span>
                </h3>
                <button onclick="closeAssignModal()" class="text-slate-400 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <input type="text" id="modal-assign-search" oninput="renderAssignModalList()" placeholder="Cari nama player yang tersedia..."
                class="w-full px-3 py-2 rounded-xl bg-obsidian border border-slate-700 text-sm text-white placeholder-slate-500 outline-none focus:border-yellow-400 mb-3">
            <div id="modal-assign-list" class="space-y-1.5 max-h-64 overflow-y-auto pr-1">
                <!-- Populated by JS -->
            </div>
            <div class="mt-4 pt-3 border-t border-slate-800 flex justify-end">
                <button onclick="closeAssignModal()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL: CONFIRMATION DIALOG ==================== -->
    <div id="modal-confirm" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/75 backdrop-blur-sm p-4">
        <div class="bg-panel border border-slate-700 rounded-2xl max-w-sm w-full p-5 shadow-2xl">
            <h3 id="confirm-title" class="font-display font-bold text-xl text-white mb-2">Konfirmasi</h3>
            <p id="confirm-message" class="text-sm text-slate-300 mb-5">Apakah Anda yakin?</p>
            <div class="flex justify-end gap-2">
                <button onclick="closeConfirmModal()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200">
                    Batal
                </button>
                <button id="confirm-ok-btn" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-xs font-bold text-white">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL: ANIMATED TEAM-TO-FACTION DRAFT ==================== -->
    <div id="modal-team-draft" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-md p-3 sm:p-5 overflow-y-auto">
        <div class="bg-panel border border-yellow-500/30 rounded-3xl max-w-5xl w-full p-4 sm:p-6 shadow-2xl my-auto relative overflow-hidden">
            <!-- Confetti Overlay -->
            <canvas id="td-confetti-canvas" class="pointer-events-none absolute inset-0 w-full h-full z-30"></canvas>

            <!-- Modal Header -->
            <div class="flex flex-wrap items-center justify-between gap-3 pb-4 mb-4 border-b border-slate-800">
                <div class="flex items-center gap-3.5">
                    <img src="{{ asset('images/logo-lx.png') }}" alt="LX Logo" class="h-9 w-auto object-contain drop-shadow-[0_0_12px_rgba(234,179,8,0.4)]">
                    <div class="border-l border-slate-700/80 pl-3.5">
                        <h3 class="font-display font-black text-xl sm:text-2xl text-white leading-none uppercase">
                            ARENA ACAK POSISI <span class="gold-shimmer">TIM KE FRAKSI</span>
                        </h3>
                        <p class="text-xs text-slate-400 mt-0.5">Acak penempatan setiap tim ke Fraksi dengan animasi seru!</p>
                    </div>
                </div>
                <button onclick="closeTeamDraftModal()" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

                <!-- LEFT: Animation Stage (7 cols) -->
                <div class="lg:col-span-7 bg-obsidian/90 border border-slate-800 rounded-2xl p-4 flex flex-col items-center">
                    <!-- Animation Style Switcher -->
                    <div class="w-full flex flex-wrap items-center justify-between gap-2 mb-3 pb-3 border-b border-slate-800/80">
                        <div class="inline-flex rounded-xl bg-panel p-1 border border-slate-800 gap-1">
                            <button id="td-anim-btn-wheel" onclick="setTeamDraftAnimStyle('wheel')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-yellow-500 text-obsidian">
                                <i class="fa-solid fa-dharmachakra"></i> Wheel
                            </button>
                            <button id="td-anim-btn-crate" onclick="setTeamDraftAnimStyle('crate')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white">
                                <i class="fa-solid fa-box-open"></i> Case Drop
                            </button>
                            <button id="td-anim-btn-decrypt" onclick="setTeamDraftAnimStyle('decrypt')"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white">
                                <i class="fa-solid fa-satellite-dish"></i> Cyber Scan
                            </button>
                        </div>
                        <div class="text-xs text-slate-300">
                            Sisa Tim: <strong id="td-remaining-count" class="text-yellow-400">0</strong>
                        </div>
                    </div>

                    <!-- Next Faction Target -->
                    <div class="w-full flex items-center justify-between text-xs text-slate-400 mb-2">
                        <span>Target Berikutnya: <strong id="td-next-faction" class="text-emerald-400">-</strong></span>
                        <span id="td-latest-pick" class="text-yellow-400 font-semibold truncate max-w-[55%]">Siap diacak!</span>
                    </div>

                    <!-- STAGE 1: TEAM WHEEL -->
                    <div id="td-stage-wheel" class="w-full flex items-center justify-center">
                        <div id="td-wheel-container" class="relative w-full max-w-[330px] aspect-square flex items-center justify-center my-1 select-none">
                            <canvas id="td-wheel-canvas" class="w-full h-full cursor-pointer" onclick="runTeamDraftOnce()"></canvas>
                            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-2 z-20 wheel-pointer pointer-events-none">
                                <svg width="36" height="30" viewBox="0 0 42 36" fill="none">
                                    <path d="M2 18L38 4V32L2 18Z" fill="#facc15" stroke="#090b10" stroke-width="3" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <button onclick="runTeamDraftOnce()"
                                class="absolute z-20 w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-br from-obsidian via-slate-900 to-slate-800 border-4 border-yellow-400 shadow-2xl flex flex-col items-center justify-center hover:scale-105 active:scale-95 transition">
                                <span class="font-display font-bold text-yellow-400 text-base leading-none">SPIN</span>
                                <span class="text-[8px] text-slate-400 uppercase tracking-widest mt-0.5">TIM</span>
                            </button>
                        </div>
                    </div>

                    <!-- STAGE 2: TEAM CASE DROP -->
                    <div id="td-stage-crate" class="hidden w-full py-10 flex flex-col items-center justify-center">
                        <div class="w-full relative rounded-2xl bg-panel border border-yellow-500/30 py-7 overflow-hidden shadow-inner">
                            <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent opacity-70"></div>
                            <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-yellow-400 to-transparent opacity-70"></div>
                            <div class="absolute inset-y-0 left-1/2 -translate-x-1/2 w-1 bg-yellow-400 z-20 shadow-[0_0_16px_rgba(250,204,21,0.95)] pointer-events-none"></div>
                            <div id="td-crate-viewport" class="crate-viewport w-full overflow-hidden">
                                <div id="td-crate-track" class="flex items-center will-change-transform" style="gap: 12px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- STAGE 3: TEAM CYBER SCAN -->
                    <div id="td-stage-decrypt" class="hidden w-full py-4 flex flex-col items-center justify-center">
                        <div class="relative w-full max-w-sm rounded-2xl bg-panel border border-yellow-500/30 p-5 flex flex-col items-center justify-center min-h-[260px]">
                            <div class="relative w-36 h-36 rounded-full border border-yellow-500/30 flex items-center justify-center mb-4 overflow-hidden bg-slate-950/80">
                                <div class="absolute inset-4 rounded-full border border-yellow-500/20"></div>
                                <div class="absolute inset-x-0 top-1/2 h-px bg-yellow-500/20"></div>
                                <div class="absolute inset-y-0 left-1/2 w-px bg-yellow-500/20"></div>
                                <div id="td-radar-beam" class="absolute inset-0 rounded-full radar-sweep"></div>
                                <div class="relative z-10 flex flex-col items-center">
                                    <span id="td-decrypt-status" class="px-2 py-0.5 rounded bg-yellow-500/20 border border-yellow-500/40 text-[9px] font-bold tracking-widest text-yellow-400 uppercase">STANDBY</span>
                                    <i id="td-decrypt-icon" class="fa-solid fa-shield-halved text-2xl text-slate-300 mt-1.5"></i>
                                </div>
                            </div>
                            <div class="w-full rounded-xl bg-slate-950 border border-slate-800 px-3 py-2.5 text-center">
                                <div class="text-[9px] font-mono uppercase tracking-widest text-slate-500">SQUAD DEPLOYMENT LOCK</div>
                                <div id="td-decrypt-name" class="font-display font-bold text-2xl tracking-wider text-yellow-400 truncate">READY TO SCAN</div>
                                <div id="td-decrypt-sub" class="text-[11px] font-mono text-emerald-400/90 mt-0.5">Menunggu perintah...</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stage Action Controls -->
                    <div class="w-full flex flex-wrap items-center justify-center gap-2 mt-4 pt-3 border-t border-slate-800/80">
                        <button onclick="runTeamDraftOnce()"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-400 hover:to-amber-400 text-obsidian font-bold text-xs sm:text-sm shadow-lg transition flex items-center gap-2">
                            <i class="fa-solid fa-play"></i> <span id="td-btn-spin-label">Acak 1 Tim</span>
                        </button>
                        <button id="td-btn-auto" onclick="toggleTeamAutoDraft()"
                            class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm shadow transition flex items-center gap-2">
                            <i class="fa-solid fa-forward"></i> Auto-Acak Semua
                        </button>
                        <button onclick="instantTeamDraftAll()"
                            class="px-3.5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition flex items-center gap-1.5">
                            <i class="fa-solid fa-bolt"></i> Instan
                        </button>
                        <button onclick="resetTeamDraftPool()"
                            class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 font-semibold text-xs transition">
                            <i class="fa-solid fa-rotate-left"></i>
                        </button>
                    </div>
                </div>

                <!-- RIGHT: Live Factions Result Preview (5 cols) -->
                <div class="lg:col-span-5 flex flex-col justify-between space-y-4">
                    <div id="td-factions-preview" class="space-y-3 max-h-[380px] overflow-y-auto pr-1">
                        <!-- Populated by JS -->
                    </div>

                    <div class="pt-3 border-t border-slate-800 flex items-center justify-end gap-2">
                        <button onclick="closeTeamDraftModal()"
                            class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 transition">
                            Tutup
                        </button>
                        <button id="td-btn-apply" onclick="applyAndCloseTeamDraft()"
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-obsidian font-bold text-xs sm:text-sm shadow-lg transition flex items-center gap-2">
                            <i class="fa-solid fa-check"></i> Terapkan ke Board
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== TOAST NOTIFICATION ==================== -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- ==================== JAVASCRIPT APPLICATION LOGIC ==================== -->
    <script>
        /* =======================================================================
           1. APPLICATION STATE & STORAGE
        ======================================================================= */
        const STORAGE_KEY = 'luxury_elite_df_state_v2';

        const DEMO_PLAYERS_40 = [
            { name: 'ipay', tier: 'pro' },
            { name: 'troxxxy', tier: 'pro' },
            { name: 'Kaito Lninja', tier: 'pro' },
            { name: 'Nperma', tier: 'pro' },
            { name: 'Law', tier: 'pro' },
            { name: 'ZORA', tier: 'pro' },
            { name: 'usopp', tier: 'pro' },
            { name: 'Awong', tier: 'pro' },
            { name: 'Abil atau Billy aka (CapTikus)', tier: 'pro' },
            { name: 'Jee', tier: 'pro' },
            { name: 'Xtreme', tier: 'normal' },
            { name: 'Borneo', tier: 'normal' },
            { name: 'Rakens', tier: 'normal' },
            { name: 'Art', tier: 'normal' },
            { name: 'Cytaaa', tier: 'normal' },
            { name: 'Babamgaming', tier: 'normal' },
            { name: 'BTR | FYNNN', tier: 'normal' },
            { name: 'Pisces Greenflag', tier: 'normal' },
            { name: 'MbahMenir', tier: 'normal' },
            { name: 'Fard Legend', tier: 'normal' },
            { name: 'Son', tier: 'normal' },
            { name: 'Dillan', tier: 'normal' },
            { name: 'Xcaa pengen baku pica', tier: 'normal' },
            { name: 'Vero', tier: 'normal' },
            { name: 'haxz', tier: 'normal' },
            { name: 'HiroNgen', tier: 'normal' },
            { name: 'Celo', tier: 'normal' },
            { name: 'BNTO', tier: 'normal' },
            { name: 'JURARimuruuu', tier: 'normal' },
            { name: 'Neko', tier: 'normal' },
            { name: 'Bee', tier: 'normal' },
            { name: 'iamWANTED', tier: 'normal' },
            { name: 'RIMURUSCP', tier: 'normal' },
            { name: 'enpi', tier: 'normal' },
            { name: 'Kumar', tier: 'normal' },
            { name: 'Kakam', tier: 'normal' },
            { name: 'Xalva', tier: 'normal' },
            { name: 'apizz', tier: 'normal' },
            { name: 'Hutaoo', tier: 'normal' },
            { name: 'yaepemboylovers', tier: 'normal' }
        ];

        const FACTION_ACCENTS = ['emerald', 'rose', 'sky', 'amber'];

        let state = {
            players: [],     // { id, name, tier: 'pro'|'normal', teamId: string|null, isLeader: boolean }
            factions: [],    // { id, name, accent: 'emerald'|'rose'|'sky'|'amber', teams: [{ id, name, capacity }] }
            randomMode: 'balanced', // 'balanced' | 'random'
            animStyle: 'wheel',     // 'wheel' | 'crate' | 'decrypt'
            soundEnabled: true,
            wheelTarget: 'auto'     // 'auto' or teamId
        };

        // Runtime UI variables
        let currentTab = 'setup';
        let wheelAngle = 0;
        let isSpinning = false;
        let isAutoSpinning = false;
        let lastSliceIndex = -1;
        let swapSourcePlayerId = null;
        let assignModalTeamId = null;
        let confirmCallback = null;
        let shouldAnimateBoardCards = false;

        // Team-to-Faction Draft Modal Runtime State
        let tdPool = [];
        let tdAssigned = [];
        let tdAnimStyle = 'wheel';
        let tdWheelAngle = 0;
        let tdIsSpinning = false;
        let tdIsAutoSpinning = false;
        let tdLastSliceIndex = -1;

        // Audio synths (Tone.js)
        let audioReady = false;
        let tickSynth = null;
        let winSynth = null;

        /* =======================================================================
           2. UTILITY HELPERS
        ======================================================================= */
        function uid(prefix = 'id') {
            return `${prefix}_${Date.now().toString(36)}_${Math.random().toString(36).slice(2, 7)}`;
        }

        function escapeHtml(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function shuffleArray(arr) {
            const copy = [...arr];
            for (let i = copy.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [copy[i], copy[j]] = [copy[j], copy[i]];
            }
            return copy;
        }

        function getAllTeamsFlat() {
            const list = [];
            state.factions.forEach(f => {
                f.teams.forEach(t => {
                    list.push({ ...t, factionId: f.id, factionName: f.name, accent: f.accent });
                });
            });
            return list;
        }

        function getTeamById(teamId) {
            for (const f of state.factions) {
                for (const t of f.teams) {
                    if (t.id === teamId) {
                        return { ...t, factionId: f.id, factionName: f.name, accent: f.accent };
                    }
                }
            }
            return null;
        }

        function getTeamMembers(teamId) {
            const members = state.players.filter(p => p.teamId === teamId);
            // Leader always appears first at the top
            return members.sort((a, b) => (b.isLeader ? 1 : 0) - (a.isLeader ? 1 : 0));
        }

        function getUnassignedPlayers() {
            return state.players.filter(p => !p.teamId);
        }

        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const colors = {
                success: 'bg-emerald-950/95 border-emerald-500/50 text-emerald-200',
                error: 'bg-rose-950/95 border-rose-500/50 text-rose-200',
                info: 'bg-slate-900/95 border-yellow-500/40 text-slate-100'
            };
            const icons = {
                success: 'fa-circle-check text-emerald-400',
                error: 'fa-circle-exclamation text-rose-400',
                info: 'fa-circle-info text-yellow-400'
            };

            const toast = document.createElement('div');
            toast.className = `pointer-events-auto px-4 py-3 rounded-xl border shadow-2xl text-xs sm:text-sm font-medium flex items-center gap-2.5 backdrop-blur-md transition-all duration-300 ${colors[type] || colors.info}`;
            toast.innerHTML = `<i class="fa-solid ${icons[type] || icons.info}"></i><span>${escapeHtml(message)}</span>`;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(8px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        /* =======================================================================
           3. AUDIO ENGINE (TONE.JS)
        ======================================================================= */
        function initAudio() {
            if (audioReady || !state.soundEnabled) return;
            try {
                if (typeof Tone !== 'undefined') {
                    Tone.start();
                    tickSynth = new Tone.MembraneSynth({
                        pitchDecay: 0.015,
                        octaves: 3,
                        envelope: { attack: 0.001, decay: 0.05, sustain: 0, release: 0.02 }
                    }).toDestination();
                    tickSynth.volume.value = -14;

                    winSynth = new Tone.PolySynth(Tone.Synth, {
                        oscillator: { type: 'triangle' },
                        envelope: { attack: 0.02, decay: 0.25, sustain: 0.1, release: 0.6 }
                    }).toDestination();
                    winSynth.volume.value = -10;
                    audioReady = true;
                }
            } catch (e) {
                console.warn('Audio init skipped:', e);
            }
        }

        function playTickSound() {
            if (!state.soundEnabled || !tickSynth) return;
            try {
                tickSynth.triggerAttackRelease('C5', '32n');
            } catch (e) {}
        }

        function playWinSound() {
            if (!state.soundEnabled || !winSynth) return;
            try {
                winSynth.triggerAttackRelease(['C5', 'E5', 'G5', 'C6'], '8n');
            } catch (e) {}
        }

        function toggleSound() {
            state.soundEnabled = !state.soundEnabled;
            const icon = document.getElementById('icon-sound');
            if (state.soundEnabled) {
                icon.className = 'fa-solid fa-volume-high';
                initAudio();
                showToast('Efek suara diaktifkan.', 'info');
            } else {
                icon.className = 'fa-solid fa-volume-xmark text-slate-500';
                showToast('Efek suara dimatikan.', 'info');
            }
            saveState();
        }

        /* =======================================================================
           4. PERSISTENCE & PRESETS
        ======================================================================= */
        function buildDefaultFactions20v20() {
            return [
                {
                    id: uid('fac'),
                    name: 'FRAKSI 1',
                    accent: 'emerald',
                    teams: [
                        { id: uid('tm'), name: 'Tim G', capacity: 4 },
                        { id: uid('tm'), name: 'Tim A', capacity: 4 },
                        { id: uid('tm'), name: 'Tim E', capacity: 4 },
                        { id: uid('tm'), name: 'Tim H', capacity: 4 },
                        { id: uid('tm'), name: 'Tim B', capacity: 4 }
                    ]
                },
                {
                    id: uid('fac'),
                    name: 'FRAKSI 2',
                    accent: 'rose',
                    teams: [
                        { id: uid('tm'), name: 'Tim I', capacity: 4 },
                        { id: uid('tm'), name: 'Tim J', capacity: 4 },
                        { id: uid('tm'), name: 'Tim D', capacity: 4 },
                        { id: uid('tm'), name: 'Tim C', capacity: 4 },
                        { id: uid('tm'), name: 'Tim F', capacity: 4 }
                    ]
                }
            ];
        }

        function saveState() {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
            } catch (e) {
                console.warn('LocalStorage save failed:', e);
            }
        }

        function loadState() {
            try {
                const raw = localStorage.getItem(STORAGE_KEY);
                if (raw) {
                    const parsed = JSON.parse(raw);
                    if (parsed && Array.isArray(parsed.factions) && parsed.factions.length > 0) {
                        state = {
                            players: Array.isArray(parsed.players) ? parsed.players : [],
                            factions: parsed.factions,
                            randomMode: parsed.randomMode || 'balanced',
                            animStyle: parsed.animStyle || 'wheel',
                            soundEnabled: parsed.soundEnabled !== undefined ? parsed.soundEnabled : true,
                            wheelTarget: parsed.wheelTarget || 'auto'
                        };
                        return;
                    }
                }
            } catch (e) {
                console.warn('LocalStorage load failed, using default:', e);
            }
            state.factions = buildDefaultFactions20v20();
            state.players = [];
        }

        /* =======================================================================
           5. TAB NAVIGATION
        ======================================================================= */
        function switchTab(tabName) {
            if (isSpinning && tabName !== 'wheel') {
                showToast('Tunggu animasi selesai terlebih dahulu.', 'info');
                return;
            }
            currentTab = tabName;
            const tabs = ['setup', 'wheel', 'board'];
            tabs.forEach(t => {
                const btn = document.getElementById(`tab-${t}`);
                const view = document.getElementById(`view-${t}`);
                if (!btn || !view) return;
                const badge = btn.querySelector('span');
                if (t === tabName) {
                    btn.className = 'tab-btn px-4 py-2.5 text-xs sm:text-sm font-display font-bold tracking-wider uppercase border-b-2 border-yellow-400 text-yellow-400 whitespace-nowrap flex items-center gap-2.5 transition';
                    if (badge) badge.className = 'w-5 h-5 rounded-md bg-yellow-500/20 text-yellow-400 text-[10px] font-mono flex items-center justify-center font-bold';
                    view.classList.remove('hidden');
                } else {
                    btn.className = 'tab-btn px-4 py-2.5 text-xs sm:text-sm font-display font-bold tracking-wider uppercase border-b-2 border-transparent text-slate-400 hover:text-white whitespace-nowrap flex items-center gap-2.5 transition';
                    if (badge) badge.className = 'w-5 h-5 rounded-md bg-slate-800 text-slate-400 text-[10px] font-mono flex items-center justify-center font-bold';
                    view.classList.add('hidden');
                }
            });

            if (tabName === 'wheel') {
                setTimeout(() => {
                    resizeWheelCanvas();
                    drawWheel();
                    if (state.animStyle === 'crate') renderIdleCrateTrack();
                }, 40);
            }
            renderAll();
        }

        /* =======================================================================
           6. PLAYER MANAGEMENT (INPUT, IMPORT, DEMO, TIER)
        ======================================================================= */
        function parsePlayerLine(line, defaultTier = 'normal') {
            const clean = line.trim();
            if (!clean) return null;

            let name = clean;
            let tier = defaultTier;

            // Support formats: "Nama, Pro" | "Nama; Pro" | "Nama | Pro" | "Nama [Pro]"
            const sepMatch = clean.match(/^(.+?)[,;\t]\s*(pro|normal)\s*$/i);
            const bracketMatch = clean.match(/^(.+?)\s*\[(pro|normal)\]\s*$/i);

            if (sepMatch) {
                name = sepMatch[1].trim();
                tier = sepMatch[2].toLowerCase() === 'pro' ? 'pro' : 'normal';
            } else if (bracketMatch) {
                name = bracketMatch[1].trim();
                tier = bracketMatch[2].toLowerCase() === 'pro' ? 'pro' : 'normal';
            }

            if (!name) return null;
            return {
                id: uid('pl'),
                name,
                tier,
                teamId: null,
                isLeader: false
            };
        }

        function addBulkPlayers(defaultTier = 'normal') {
            const textarea = document.getElementById('bulk-input');
            const lines = textarea.value.split(/\r?\n/);
            let added = 0;

            lines.forEach(line => {
                const p = parsePlayerLine(line, defaultTier);
                if (p) {
                    state.players.push(p);
                    added++;
                }
            });

            if (added === 0) {
                showToast('Masukkan minimal 1 nama player terlebih dahulu.', 'error');
                return;
            }

            textarea.value = '';
            saveState();
            renderAll();
            showToast(`${added} player berhasil ditambahkan ke roster!`, 'success');
        }

        function loadDemoPlayers() {
            state.players = DEMO_PLAYERS_40.map(d => ({
                id: uid('pl'),
                name: d.name,
                tier: d.tier,
                teamId: null,
                isLeader: false
            }));
            saveState();
            renderAll();
            showToast('40 Player Demo Luxury Elite (10 Pro, 30 Normal) berhasil dimuat!', 'success');
        }

        function togglePlayerTier(playerId) {
            const p = state.players.find(pl => pl.id === playerId);
            if (!p) return;
            p.tier = p.tier === 'pro' ? 'normal' : 'pro';
            saveState();
            renderAll();
        }

        function deletePlayer(playerId) {
            state.players = state.players.filter(p => p.id !== playerId);
            if (swapSourcePlayerId === playerId) cancelSwap();
            saveState();
            renderAll();
        }

        function confirmClearAllPlayers() {
            if (state.players.length === 0) {
                showToast('Daftar player sudah kosong.', 'info');
                return;
            }
            openConfirmModal(
                'Hapus Semua Player?',
                `Semua ${state.players.length} player akan dihapus dari daftar roster. Lanjutkan?`,
                () => {
                    state.players = [];
                    cancelSwap();
                    saveState();
                    renderAll();
                    showToast('Semua player berhasil dihapus.', 'info');
                }
            );
        }

        function handleFileImport(event) {
            const file = event.target.files[0];
            if (!file) return;

            try {
                const reader = new FileReader();
                reader.onload = function (e) {
                    try {
                        const data = new Uint8Array(e.target.result);
                        const workbook = XLSX.read(data, { type: 'array' });
                        const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                        const rows = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

                        let added = 0;
                        rows.forEach((row, idx) => {
                            if (!row || row.length === 0) return;
                            const rawName = String(row[0] ?? '').trim();
                            if (!rawName) return;

                            // Skip header row like "Nama" / "Player"
                            if (idx === 0 && /^(nama|name|player|nickname)$/i.test(rawName)) return;

                            const rawSkill = String(row[1] ?? '').trim().toLowerCase();
                            const tier = rawSkill.includes('pro') ? 'pro' : 'normal';
                            state.players.push({
                                id: uid('pl'),
                                name: rawName,
                                tier,
                                teamId: null,
                                isLeader: false
                            });
                            added++;
                        });

                        saveState();
                        renderAll();
                        showToast(`Berhasil import ${added} player dari file!`, 'success');
                    } catch (err) {
                        console.error(err);
                        showToast('Gagal membaca file Excel/CSV. Pastikan format benar.', 'error');
                    }
                };
                reader.readAsArrayBuffer(file);
            } catch (err) {
                showToast('Terjadi kesalahan saat memuat file.', 'error');
            }
            event.target.value = '';
        }

        function downloadImportTemplate() {
            try {
                const wb = XLSX.utils.book_new();
                const sampleData = [
                    ['Nama', 'Skill'],
                    ['ipay', 'Pro'],
                    ['troxxxy', 'Pro'],
                    ['Xtreme', 'Normal'],
                    ['Borneo', 'Normal']
                ];
                const ws = XLSX.utils.aoa_to_sheet(sampleData);
                ws['!cols'] = [{ wch: 24 }, { wch: 12 }];
                XLSX.utils.book_append_sheet(wb, ws, 'Template_Roster');
                XLSX.writeFile(wb, 'Template_Roster_LuxuryElite.xlsx');
                showToast('Template Excel berhasil diunduh!', 'success');
            } catch (e) {
                showToast('Gagal membuat template Excel.', 'error');
            }
        }

        /* =======================================================================
           7. FACTIONS & TEAMS CUSTOMIZATION
        ======================================================================= */
        function applyPreset20v20() {
            openConfirmModal(
                'Reset Struktur ke 20v20?',
                'Struktur Fraksi & Tim akan dikembalikan ke 2 Fraksi x 5 Tim (kapasitas 4 orang). Pembagian tim player saat ini akan di-reset.',
                () => {
                    state.factions = buildDefaultFactions20v20();
                    state.players.forEach(p => { p.teamId = null; p.isLeader = false; });
                    state.wheelTarget = 'auto';
                    saveState();
                    renderAll();
                    showToast('Struktur di-reset ke default 20v20 (5 Tim x 4).', 'success');
                }
            );
        }

        function addFaction() {
            const idx = state.factions.length;
            const accent = FACTION_ACCENTS[idx % FACTION_ACCENTS.length];
            state.factions.push({
                id: uid('fac'),
                name: `FRAKSI ${idx + 1}`,
                accent,
                teams: [
                    { id: uid('tm'), name: `Tim ${idx + 1}A`, capacity: 4 }
                ]
            });
            saveState();
            renderAll();
            showToast('Fraksi baru ditambahkan!', 'success');
        }

        function deleteFaction(factionId) {
            if (state.factions.length <= 1) {
                showToast('Minimal harus ada 1 Fraksi.', 'error');
                return;
            }
            const fac = state.factions.find(f => f.id === factionId);
            if (!fac) return;
            const teamIds = fac.teams.map(t => t.id);
            state.players.forEach(p => {
                if (teamIds.includes(p.teamId)) {
                    p.teamId = null;
                    p.isLeader = false;
                }
            });
            state.factions = state.factions.filter(f => f.id !== factionId);
            saveState();
            renderAll();
        }

        function updateFactionName(factionId, newName) {
            const fac = state.factions.find(f => f.id === factionId);
            if (!fac) return;
            fac.name = newName.trim() || 'FRAKSI';
            saveState();
            renderStats();
            renderWheelTargetDropdown();
            renderLiveCompactTeams();
            renderMainBoard();
        }

        function addTeamToFaction(factionId) {
            const fac = state.factions.find(f => f.id === factionId);
            if (!fac) return;
            const totalTeams = getAllTeamsFlat().length;
            const letter = String.fromCharCode(65 + (totalTeams % 26));
            fac.teams.push({
                id: uid('tm'),
                name: `Tim ${letter}`,
                capacity: 4
            });
            saveState();
            renderAll();
        }

        function deleteTeam(factionId, teamId) {
            const fac = state.factions.find(f => f.id === factionId);
            if (!fac) return;
            if (fac.teams.length <= 1) {
                showToast('Minimal harus ada 1 Tim di dalam Fraksi.', 'error');
                return;
            }
            state.players.forEach(p => {
                if (p.teamId === teamId) {
                    p.teamId = null;
                    p.isLeader = false;
                }
            });
            fac.teams = fac.teams.filter(t => t.id !== teamId);
            if (state.wheelTarget === teamId) state.wheelTarget = 'auto';
            saveState();
            renderAll();
        }

        function updateTeamName(factionId, teamId, newName) {
            const fac = state.factions.find(f => f.id === factionId);
            if (!fac) return;
            const team = fac.teams.find(t => t.id === teamId);
            if (!team) return;
            team.name = newName.trim() || 'Tim';
            saveState();
            renderWheelTargetDropdown();
            renderLiveCompactTeams();
            renderMainBoard();
        }

        function updateTeamCapacity(factionId, teamId, newCap) {
            const fac = state.factions.find(f => f.id === factionId);
            if (!fac) return;
            const team = fac.teams.find(t => t.id === teamId);
            if (!team) return;
            const parsed = Math.max(1, Math.min(20, parseInt(newCap, 10) || 1));
            team.capacity = parsed;

            // If assigned players exceed new capacity, move excess to bench
            const members = getTeamMembers(teamId);
            if (members.length > parsed) {
                members.slice(parsed).forEach(p => {
                    p.teamId = null;
                    p.isLeader = false;
                });
            }
            saveState();
            renderAll();
        }

        function shuffleTeamsAcrossFactions() {
            const counts = state.factions.map(f => f.teams.length);
            const allTeams = shuffleArray(state.factions.flatMap(f => f.teams));
            let cursor = 0;
            state.factions.forEach((f, idx) => {
                f.teams = allTeams.slice(cursor, cursor + counts[idx]);
                cursor += counts[idx];
            });
            initAudio();
            playWinSound();
            shouldAnimateBoardCards = true;
            saveState();
            renderAll();
            showToast('Posisi Tim antar Fraksi berhasil diacak!', 'success');
        }

        /* =======================================================================
           7B. ANIMATED TEAM-TO-FACTION DRAFT MODAL (WHEEL, CASE DROP, CYBER SCAN)
        ======================================================================= */
        function openTeamDraftModal() {
            const allTeams = state.factions.flatMap(f => f.teams);
            if (allTeams.length < 2) {
                showToast('Minimal harus ada 2 Tim untuk diacak.', 'error');
                return;
            }

            tdIsSpinning = false;
            tdIsAutoSpinning = false;
            tdWheelAngle = 0;
            tdPool = shuffleArray(allTeams);
            tdAssigned = state.factions.map(f => ({
                id: f.id,
                name: f.name,
                accent: f.accent,
                targetCount: f.teams.length,
                teams: []
            }));

            const modal = document.getElementById('modal-team-draft');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('td-latest-pick').textContent = 'Siap diacak!';
            updateTeamAutoDraftBtn();
            setTeamDraftAnimStyle(state.animStyle || 'wheel');
            renderTeamDraftPreview();
        }

        function closeTeamDraftModal() {
            tdIsAutoSpinning = false;
            tdIsSpinning = false;
            const modal = document.getElementById('modal-team-draft');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function applyAndCloseTeamDraft() {
            if (tdIsSpinning) {
                showToast('Tunggu animasi selesai terlebih dahulu.', 'info');
                return;
            }
            // If any teams remain in pool, assign them evenly before applying
            if (tdPool.length > 0) {
                const remaining = shuffleArray(tdPool);
                remaining.forEach(team => {
                    const targetFac = getNextTargetFactionForDraft();
                    if (targetFac) targetFac.teams.push(team);
                });
                tdPool = [];
            }

            tdAssigned.forEach(draftFac => {
                const realFac = state.factions.find(f => f.id === draftFac.id);
                if (realFac) realFac.teams = [...draftFac.teams];
            });

            shouldAnimateBoardCards = true;
            saveState();
            closeTeamDraftModal();
            renderAll();
            playWinSound();
            showToast('Susunan Tim antar Fraksi berhasil diterapkan!', 'success');
        }

        function resetTeamDraftPool() {
            if (tdIsSpinning) return;
            tdIsAutoSpinning = false;
            updateTeamAutoDraftBtn();
            const allTeams = [
                ...tdPool,
                ...tdAssigned.flatMap(f => f.teams)
            ];
            tdPool = shuffleArray(allTeams);
            tdAssigned.forEach(f => { f.teams = []; });
            document.getElementById('td-latest-pick').textContent = 'Pool di-reset!';
            renderTeamDraftPreview();
            if (tdAnimStyle === 'wheel') drawTeamDraftWheel();
            if (tdAnimStyle === 'crate') renderTeamDraftIdleCrate();
        }

        function getNextTargetFactionForDraft() {
            const open = tdAssigned.filter(f => f.teams.length < f.targetCount);
            if (open.length === 0) return null;
            // Alternate evenly across factions (lowest team count first)
            open.sort((a, b) => a.teams.length - b.teams.length);
            return open[0];
        }

        function setTeamDraftAnimStyle(style) {
            if (tdIsSpinning) return;
            tdAnimStyle = style;

            const styles = ['wheel', 'crate', 'decrypt'];
            const btnLabels = {
                wheel: 'Acak 1 Tim',
                crate: 'Buka Case 1 Tim',
                decrypt: 'Scan 1 Tim'
            };

            styles.forEach(s => {
                const btn = document.getElementById(`td-anim-btn-${s}`);
                const stage = document.getElementById(`td-stage-${s}`);
                if (!btn || !stage) return;
                if (s === style) {
                    btn.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-yellow-500 text-obsidian';
                    stage.classList.remove('hidden');
                } else {
                    btn.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white';
                    stage.classList.add('hidden');
                }
            });

            document.getElementById('td-btn-spin-label').textContent = btnLabels[style];

            if (style === 'wheel') {
                setTimeout(() => {
                    resizeTeamDraftWheel();
                    drawTeamDraftWheel();
                }, 40);
            } else if (style === 'crate') {
                renderTeamDraftIdleCrate();
            } else if (style === 'decrypt') {
                document.getElementById('td-decrypt-status').textContent = 'STANDBY';
                document.getElementById('td-decrypt-name').textContent = 'READY TO SCAN';
                document.getElementById('td-decrypt-sub').textContent = 'Klik tombol Scan 1 Tim untuk memilih...';
            }
        }

        function resizeTeamDraftWheel() {
            const container = document.getElementById('td-wheel-container');
            const canvas = document.getElementById('td-wheel-canvas');
            if (!container || !canvas) return;
            const size = Math.min(container.clientWidth || 300, 330);
            const dpr = window.devicePixelRatio || 1;
            canvas.width = size * dpr;
            canvas.height = size * dpr;
            const ctx = canvas.getContext('2d');
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }

        function drawTeamDraftWheel() {
            const canvas = document.getElementById('td-wheel-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const dpr = window.devicePixelRatio || 1;
            const size = canvas.width / dpr;
            if (size <= 0) return;

            const cx = size / 2;
            const cy = size / 2;
            const radius = size / 2 - 8;
            ctx.clearRect(0, 0, size, size);

            if (tdPool.length === 0) {
                ctx.beginPath();
                ctx.arc(cx, cy, radius, 0, Math.PI * 2);
                ctx.fillStyle = '#111520';
                ctx.fill();
                ctx.lineWidth = 3;
                ctx.strokeStyle = '#10b981';
                ctx.stroke();

                ctx.fillStyle = '#34d399';
                ctx.font = '700 14px "Rajdhani", "Plus Jakarta Sans", sans-serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('Semua Tim Sudah Terbagi!', cx, cy - 48);
                return;
            }

            const sliceAngle = (Math.PI * 2) / tdPool.length;
            tdPool.forEach((team, i) => {
                const startA = tdWheelAngle + i * sliceAngle;
                const endA = startA + sliceAngle;

                ctx.beginPath();
                ctx.moveTo(cx, cy);
                ctx.arc(cx, cy, radius, startA, endA);
                ctx.closePath();

                ctx.fillStyle = WHEEL_COLORS[i % WHEEL_COLORS.length];
                ctx.fill();
                ctx.lineWidth = 1.5;
                ctx.strokeStyle = '#090b10';
                ctx.stroke();

                ctx.save();
                ctx.translate(cx, cy);
                ctx.rotate(startA + sliceAngle / 2);
                ctx.textAlign = 'right';
                ctx.textBaseline = 'middle';

                const isLight = ['#eab308', '#10b981', '#38bdf8', '#f59e0b'].includes(WHEEL_COLORS[i % WHEEL_COLORS.length]);
                ctx.fillStyle = isLight ? '#090b10' : '#f8fafc';
                ctx.font = `700 ${tdPool.length > 12 ? 12 : 14}px "Rajdhani", "Plus Jakarta Sans", sans-serif`;
                const clipped = team.name.length > 14 ? team.name.slice(0, 13) + '…' : team.name;
                ctx.fillText(clipped, radius - 14, 0);
                ctx.restore();
            });

            ctx.beginPath();
            ctx.arc(cx, cy, radius, 0, Math.PI * 2);
            ctx.lineWidth = 4;
            ctx.strokeStyle = '#facc15';
            ctx.stroke();
        }

        function buildTeamCrateCardHtml(team, isWinner = false) {
            const memCount = getTeamMembers(team.id).length;
            return `
                <div class="shrink-0 w-[132px] h-[106px] rounded-xl border-2 border-indigo-400/50 bg-gradient-to-b from-indigo-500/20 to-slate-950 p-3 flex flex-col items-center justify-between text-center select-none transition-transform"
                     data-td-winner="${isWinner ? '1' : '0'}">
                    <span class="px-2 py-0.5 rounded bg-yellow-400/20 text-yellow-300 text-[9px] font-extrabold uppercase tracking-wider">
                        SQUAD (${memCount}/${team.capacity})
                    </span>
                    <div class="font-display font-bold text-lg text-white leading-tight truncate w-full">
                        ${escapeHtml(team.name)}
                    </div>
                    <div class="w-8 h-1 rounded-full bg-yellow-400"></div>
                </div>
            `;
        }

        function renderTeamDraftIdleCrate() {
            const track = document.getElementById('td-crate-track');
            if (!track) return;
            track.style.transform = 'translateX(0px)';
            if (tdPool.length === 0) {
                track.innerHTML = `<div class="w-full text-center text-xs text-emerald-400 py-8 font-semibold">Semua Tim sudah terbagi ke Fraksi!</div>`;
                return;
            }
            const sample = Array.from({ length: 10 }, (_, i) => tdPool[i % tdPool.length]);
            track.innerHTML = sample.map(t => buildTeamCrateCardHtml(t)).join('');
        }

        function fireTeamDraftConfetti() {
            const canvas = document.getElementById('td-confetti-canvas');
            if (!canvas || !canvas.parentElement) return;
            const rect = canvas.parentElement.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
            const ctx = canvas.getContext('2d');

            const colors = ['#facc15', '#818cf8', '#10b981', '#f43f5e', '#ffffff'];
            const particles = Array.from({ length: 36 }, () => ({
                x: canvas.width * 0.35,
                y: canvas.height * 0.45,
                vx: (Math.random() - 0.5) * 11,
                vy: (Math.random() - 0.7) * 10 - 2,
                size: 4 + Math.random() * 5,
                color: colors[Math.floor(Math.random() * colors.length)],
                rot: Math.random() * Math.PI * 2,
                vrot: (Math.random() - 0.5) * 0.25,
                life: 1
            }));

            function step() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                let alive = false;
                particles.forEach(p => {
                    if (p.life <= 0) return;
                    alive = true;
                    p.x += p.vx;
                    p.y += p.vy;
                    p.vy += 0.28;
                    p.rot += p.vrot;
                    p.life -= 0.025;
                    ctx.save();
                    ctx.globalAlpha = Math.max(0, p.life);
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.rot);
                    ctx.fillStyle = p.color;
                    ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.6);
                    ctx.restore();
                });
                if (alive) requestAnimationFrame(step);
                else ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
            requestAnimationFrame(step);
        }

        function completeTeamDraftPick(winnerTeam, targetFac) {
            tdIsSpinning = false;
            tdPool = tdPool.filter(t => t.id !== winnerTeam.id);
            targetFac.teams.push(winnerTeam);

            playWinSound();
            fireTeamDraftConfetti();

            document.getElementById('td-latest-pick').textContent = `${winnerTeam.name} → ${targetFac.name}`;
            renderTeamDraftPreview();
            if (tdAnimStyle === 'wheel') drawTeamDraftWheel();

            if (tdIsAutoSpinning) {
                if (tdPool.length > 0 && getNextTargetFactionForDraft()) {
                    setTimeout(() => {
                        if (tdIsAutoSpinning) runTeamDraftOnce(true);
                    }, 520);
                } else {
                    tdIsAutoSpinning = false;
                    updateTeamAutoDraftBtn();
                    showToast('Semua tim selesai diacak! Klik "Terapkan ke Board".', 'success');
                }
            }
        }

        function runTeamDraftOnce(fastMode = false) {
            if (tdIsSpinning) return;
            if (tdPool.length === 0) {
                tdIsAutoSpinning = false;
                updateTeamAutoDraftBtn();
                showToast('Semua tim sudah masuk fraksi! Klik "Terapkan ke Board".', 'info');
                return;
            }
            const targetFac = getNextTargetFactionForDraft();
            if (!targetFac) return;

            initAudio();
            if (tdAnimStyle === 'crate') {
                runTeamDraftCrate(targetFac, fastMode);
            } else if (tdAnimStyle === 'decrypt') {
                runTeamDraftDecrypt(targetFac, fastMode);
            } else {
                runTeamDraftWheel(targetFac, fastMode);
            }
        }

        function runTeamDraftWheel(targetFac, fastMode = false) {
            tdIsSpinning = true;
            const winnerIndex = Math.floor(Math.random() * tdPool.length);
            const winnerTeam = tdPool[winnerIndex];
            const sliceAngle = (Math.PI * 2) / tdPool.length;

            const randomOffset = sliceAngle * (0.2 + Math.random() * 0.6);
            const desiredMod = (Math.PI * 2 - ((winnerIndex * sliceAngle + randomOffset) % (Math.PI * 2))) % (Math.PI * 2);
            const currentMod = ((tdWheelAngle % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
            let delta = desiredMod - currentMod;
            if (delta < 0) delta += Math.PI * 2;

            const extraSpins = fastMode ? 3 : 6;
            const totalDelta = extraSpins * Math.PI * 2 + delta;
            const startAngle = tdWheelAngle;
            const duration = fastMode ? 950 : 3100;
            const startTime = performance.now();
            tdLastSliceIndex = -1;

            function animate(now) {
                const t = Math.min(1, (now - startTime) / duration);
                const easeOut = 1 - Math.pow(1 - t, 3.3);
                tdWheelAngle = startAngle + totalDelta * easeOut;
                drawTeamDraftWheel();

                const normalized = (((-tdWheelAngle) % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
                const currSlice = Math.floor(normalized / sliceAngle);
                if (currSlice !== tdLastSliceIndex) {
                    tdLastSliceIndex = currSlice;
                    playTickSound();
                }

                if (t < 1) requestAnimationFrame(animate);
                else completeTeamDraftPick(winnerTeam, targetFac);
            }
            requestAnimationFrame(animate);
        }

        function runTeamDraftCrate(targetFac, fastMode = false) {
            tdIsSpinning = true;
            const winnerTeam = tdPool[Math.floor(Math.random() * tdPool.length)];
            const track = document.getElementById('td-crate-track');
            const viewport = document.getElementById('td-crate-viewport');

            const cardWidth = 132;
            const gap = 12;
            const stride = cardWidth + gap;
            const totalCards = fastMode ? 24 : 40;
            const winnerSlotIndex = totalCards - 5;

            const strip = [];
            for (let i = 0; i < totalCards; i++) {
                strip.push(i === winnerSlotIndex ? winnerTeam : tdPool[Math.floor(Math.random() * tdPool.length)]);
            }
            track.innerHTML = strip.map((t, i) => buildTeamCrateCardHtml(t, i === winnerSlotIndex)).join('');

            const viewportWidth = viewport.clientWidth || 420;
            const jitter = (Math.random() - 0.5) * (cardWidth * 0.5);
            const targetX = -(winnerSlotIndex * stride + cardWidth / 2 - viewportWidth / 2 + jitter);
            const duration = fastMode ? 1000 : 3200;
            const startTime = performance.now();
            let lastCrossed = -1;

            function animate(now) {
                const t = Math.min(1, (now - startTime) / duration);
                const easeOut = 1 - Math.pow(1 - t, 3.5);
                const currX = targetX * easeOut;
                track.style.transform = `translateX(${currX}px)`;

                const idx = Math.floor((Math.abs(currX) + viewportWidth / 2) / stride);
                if (idx !== lastCrossed) {
                    lastCrossed = idx;
                    playTickSound();
                }

                if (t < 1) requestAnimationFrame(animate);
                else {
                    const winEl = track.querySelector('[data-td-winner="1"]');
                    if (winEl) winEl.classList.add('ring-2', 'ring-yellow-400', 'scale-105');
                    completeTeamDraftPick(winnerTeam, targetFac);
                }
            }
            requestAnimationFrame(animate);
        }

        function runTeamDraftDecrypt(targetFac, fastMode = false) {
            tdIsSpinning = true;
            const winnerTeam = tdPool[Math.floor(Math.random() * tdPool.length)];

            const beam = document.getElementById('td-radar-beam');
            const statusEl = document.getElementById('td-decrypt-status');
            const nameEl = document.getElementById('td-decrypt-name');
            const subEl = document.getElementById('td-decrypt-sub');
            const iconEl = document.getElementById('td-decrypt-icon');

            beam.classList.add('radar-sweep-fast');
            statusEl.textContent = 'SCANNING...';
            iconEl.className = 'fa-solid fa-crosshairs text-2xl text-yellow-400 mt-1.5 animate-spin';
            subEl.textContent = `Menentukan skuad untuk ${targetFac.name}...`;

            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#%*';
            const totalDuration = fastMode ? 900 : 2400;
            const lockStart = totalDuration * 0.52;
            const startTime = performance.now();
            let lastTick = 0;

            function animate(now) {
                const elapsed = now - startTime;
                const t = Math.min(1, elapsed / totalDuration);

                if (elapsed < lockStart) {
                    if (now - lastTick > 70) {
                        lastTick = now;
                        nameEl.textContent = tdPool[Math.floor(Math.random() * tdPool.length)].name;
                        playTickSound();
                    }
                } else {
                    const prog = (elapsed - lockStart) / (totalDuration - lockStart);
                    const revealed = Math.floor(prog * winnerTeam.name.length);
                    let str = '';
                    for (let i = 0; i < winnerTeam.name.length; i++) {
                        str += (i < revealed || winnerTeam.name[i] === ' ')
                            ? winnerTeam.name[i]
                            : chars[Math.floor(Math.random() * chars.length)];
                    }
                    nameEl.textContent = str;
                    if (now - lastTick > 90) {
                        lastTick = now;
                        playTickSound();
                    }
                }

                if (t < 1) requestAnimationFrame(animate);
                else {
                    beam.classList.remove('radar-sweep-fast');
                    statusEl.textContent = 'DEPLOYED';
                    iconEl.className = 'fa-solid fa-shield-halved text-2xl text-yellow-400 mt-1.5';
                    nameEl.textContent = winnerTeam.name;
                    subEl.textContent = `LOCKED → ${targetFac.name}`;
                    completeTeamDraftPick(winnerTeam, targetFac);
                }
            }
            requestAnimationFrame(animate);
        }

        function toggleTeamAutoDraft() {
            if (tdIsAutoSpinning) {
                tdIsAutoSpinning = false;
                updateTeamAutoDraftBtn();
            } else {
                if (tdPool.length === 0) {
                    showToast('Semua tim sudah diacak.', 'info');
                    return;
                }
                tdIsAutoSpinning = true;
                updateTeamAutoDraftBtn();
                runTeamDraftOnce(true);
            }
        }

        function updateTeamAutoDraftBtn() {
            const btn = document.getElementById('td-btn-auto');
            if (!btn) return;
            if (tdIsAutoSpinning) {
                btn.className = 'px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs sm:text-sm shadow transition flex items-center gap-2';
                btn.innerHTML = '<i class="fa-solid fa-stop"></i> Stop';
            } else {
                btn.className = 'px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm shadow transition flex items-center gap-2';
                btn.innerHTML = '<i class="fa-solid fa-forward"></i> Auto-Acak Semua';
            }
        }

        function instantTeamDraftAll() {
            if (tdIsSpinning) return;
            if (tdPool.length === 0) return;
            const remaining = shuffleArray(tdPool);
            remaining.forEach(team => {
                const targetFac = getNextTargetFactionForDraft();
                if (targetFac) targetFac.teams.push(team);
            });
            tdPool = [];
            initAudio();
            playWinSound();
            fireTeamDraftConfetti();
            document.getElementById('td-latest-pick').textContent = 'Semua Tim Terbagi!';
            renderTeamDraftPreview();
            if (tdAnimStyle === 'wheel') drawTeamDraftWheel();
            if (tdAnimStyle === 'crate') renderTeamDraftIdleCrate();
        }

        function renderTeamDraftPreview() {
            const container = document.getElementById('td-factions-preview');
            document.getElementById('td-remaining-count').textContent = tdPool.length;

            const nextFac = getNextTargetFactionForDraft();
            document.getElementById('td-next-faction').textContent = nextFac ? nextFac.name : 'Selesai!';

            const accentBadge = {
                emerald: 'border-emerald-500/40 text-emerald-400 bg-emerald-500/10',
                rose: 'border-rose-500/40 text-rose-400 bg-rose-500/10',
                sky: 'border-sky-500/40 text-sky-400 bg-sky-500/10',
                amber: 'border-amber-500/40 text-amber-400 bg-amber-500/10'
            };

            container.innerHTML = tdAssigned.map(fac => `
                <div class="rounded-2xl bg-obsidian border border-slate-800 p-3.5 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-0.5 rounded-lg border text-xs font-display font-bold tracking-wider uppercase ${accentBadge[fac.accent] || accentBadge.emerald}">
                            ${escapeHtml(fac.name)}
                        </span>
                        <span class="text-xs font-mono ${fac.teams.length >= fac.targetCount ? 'text-emerald-400' : 'text-yellow-400'}">
                            ${fac.teams.length}/${fac.targetCount} Tim
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        ${fac.teams.map(t => `
                            <span class="px-2.5 py-1 rounded-lg bg-panel border border-yellow-500/30 text-xs font-bold text-white animate-card-drop">
                                ${escapeHtml(t.name)}
                            </span>
                        `).join('')}
                        ${Array.from({ length: Math.max(0, fac.targetCount - fac.teams.length) }).map(() => `
                            <span class="px-2.5 py-1 rounded-lg bg-slate-900/60 border border-dashed border-slate-800 text-xs text-slate-600">
                                Kosong
                            </span>
                        `).join('')}
                    </div>
                </div>
            `).join('');
        }

        /* =======================================================================
           8. RANDOMIZER & BALANCING ENGINE + MULTI-ANIMATION STAGE
        ======================================================================= */
        function setRandomMode(mode) {
            state.randomMode = mode;
            const btnBal = document.getElementById('mode-balanced');
            const btnRnd = document.getElementById('mode-random');
            if (mode === 'balanced') {
                btnBal.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-yellow-500 text-obsidian';
                btnRnd.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white';
            } else {
                btnRnd.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-yellow-500 text-obsidian';
                btnBal.className = 'px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white';
            }
            saveState();
        }

        function updateWheelTarget(val) {
            state.wheelTarget = val;
            saveState();
            updateNextTargetLabel();
        }

        function getNextTargetTeam() {
            const allTeams = getAllTeamsFlat();
            if (state.wheelTarget !== 'auto') {
                const chosen = allTeams.find(t => t.id === state.wheelTarget);
                if (chosen && getTeamMembers(chosen.id).length < chosen.capacity) {
                    return chosen;
                }
            }
            // Auto mode: fill evenly across teams (lowest member count first)
            const available = allTeams
                .map(t => ({ ...t, currentCount: getTeamMembers(t.id).length }))
                .filter(t => t.currentCount < t.capacity);
            if (available.length === 0) return null;

            available.sort((a, b) => a.currentCount - b.currentCount);
            const minCount = available[0].currentCount;
            const lowestGroup = available.filter(t => t.currentCount === minCount);
            return lowestGroup[0];
        }

        function pickWinnerForTeam(targetTeam, candidates) {
            if (state.randomMode === 'random') {
                return candidates[Math.floor(Math.random() * candidates.length)];
            }

            // BALANCED MODE: prevent stacking Pro players in the same team
            const prosLeft = candidates.filter(p => p.tier === 'pro');
            const normalsLeft = candidates.filter(p => p.tier !== 'pro');

            if (prosLeft.length === 0) {
                return normalsLeft[Math.floor(Math.random() * normalsLeft.length)];
            }
            if (normalsLeft.length === 0) {
                return prosLeft[Math.floor(Math.random() * prosLeft.length)];
            }

            const allTeams = getAllTeamsFlat();
            const teamProCounts = allTeams.map(t => ({
                id: t.id,
                proCount: getTeamMembers(t.id).filter(m => m.tier === 'pro').length,
                hasSpace: getTeamMembers(t.id).length < t.capacity
            }));

            const targetInfo = teamProCounts.find(t => t.id === targetTeam.id);
            const minProAmongOpen = Math.min(...teamProCounts.filter(t => t.hasSpace).map(t => t.proCount));

            // If this team currently has the fewest Pro players among open teams, pick a Pro
            if (targetInfo && targetInfo.proCount <= minProAmongOpen) {
                return prosLeft[Math.floor(Math.random() * prosLeft.length)];
            }
            return normalsLeft[Math.floor(Math.random() * normalsLeft.length)];
        }

        function instantRandomizeAll() {
            if (isSpinning) {
                showToast('Tunggu animasi selesai terlebih dahulu.', 'info');
                return;
            }
            const unassigned = getUnassignedPlayers();
            if (unassigned.length === 0) {
                showToast('Semua player sudah masuk tim. Klik Reset Hasil jika ingin acak ulang.', 'info');
                return;
            }

            let count = 0;
            if (state.randomMode === 'balanced') {
                // Distribute Pro players first evenly across teams, then Normal players
                const pros = shuffleArray(unassigned.filter(p => p.tier === 'pro'));
                const normals = shuffleArray(unassigned.filter(p => p.tier !== 'pro'));
                const orderedPool = [...pros, ...normals];

                orderedPool.forEach(player => {
                    const allTeams = getAllTeamsFlat()
                        .map(t => {
                            const mems = getTeamMembers(t.id);
                            return {
                                ...t,
                                count: mems.length,
                                proCount: mems.filter(m => m.tier === 'pro').length
                            };
                        })
                        .filter(t => t.count < t.capacity);

                    if (allTeams.length === 0) return;

                    if (player.tier === 'pro') {
                        allTeams.sort((a, b) => (a.proCount - b.proCount) || (a.count - b.count));
                    } else {
                        allTeams.sort((a, b) => a.count - b.count);
                    }

                    const bestMetric = player.tier === 'pro' ? allTeams[0].proCount : allTeams[0].count;
                    const bestGroup = allTeams.filter(t => (player.tier === 'pro' ? t.proCount : t.count) === bestMetric);
                    const chosen = bestGroup[Math.floor(Math.random() * bestGroup.length)];

                    player.teamId = chosen.id;
                    player.isLeader = false;
                    count++;
                });
            } else {
                const pool = shuffleArray(unassigned);
                pool.forEach(player => {
                    const target = getNextTargetTeam();
                    if (!target) return;
                    player.teamId = target.id;
                    player.isLeader = false;
                    count++;
                });
            }

            initAudio();
            playWinSound();
            fireConfettiBurst();
            saveState();
            renderAll();
            drawWheel();
            if (state.animStyle === 'crate') renderIdleCrateTrack();
            showToast(`${count} player berhasil diacak secara instan (${state.randomMode === 'balanced' ? 'Balanced' : 'Full Random'})!`, 'success');
        }

        function resetAllAssignments() {
            if (isSpinning) return;
            isAutoSpinning = false;
            updateAutoSpinButton();
            state.players.forEach(p => {
                p.teamId = null;
                p.isLeader = false;
            });
            cancelSwap();
            saveState();
            renderAll();
            drawWheel();
            if (state.animStyle === 'crate') renderIdleCrateTrack();
            document.getElementById('latest-winner-name').textContent = 'Siap Diputar!';
            document.getElementById('latest-winner-dest').textContent = 'Hasil tim sudah di-reset';
            showToast('Semua pembagian tim telah di-reset.', 'info');
        }

        /* =======================================================================
           8A. SPINNING WHEEL CANVAS RENDERER
        ======================================================================= */
        const WHEEL_COLORS = [
            '#eab308', '#1e293b', '#10b981', '#0f172a',
            '#f43f5e', '#1e293b', '#38bdf8', '#0f172a',
            '#f59e0b', '#1e293b', '#a855f7', '#0f172a'
        ];

        function resizeWheelCanvas() {
            const container = document.getElementById('wheel-container');
            const canvas = document.getElementById('wheel-canvas');
            if (!container || !canvas) return;
            const size = Math.min(container.clientWidth || 360, 440);
            const dpr = window.devicePixelRatio || 1;
            canvas.width = size * dpr;
            canvas.height = size * dpr;
            const ctx = canvas.getContext('2d');
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        }

        function drawWheel() {
            const canvas = document.getElementById('wheel-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const dpr = window.devicePixelRatio || 1;
            const size = canvas.width / dpr;
            if (size <= 0) return;

            const cx = size / 2;
            const cy = size / 2;
            const radius = size / 2 - 10;

            ctx.clearRect(0, 0, size, size);

            const entries = getUnassignedPlayers();
            if (entries.length === 0) {
                ctx.beginPath();
                ctx.arc(cx, cy, radius, 0, Math.PI * 2);
                ctx.fillStyle = '#111520';
                ctx.fill();
                ctx.lineWidth = 4;
                ctx.strokeStyle = '#334155';
                ctx.stroke();

                ctx.fillStyle = '#94a3b8';
                ctx.font = '700 14px "Rajdhani", "Plus Jakarta Sans", sans-serif';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('Semua player sudah masuk tim!', cx, cy - 55);
                return;
            }

            const sliceAngle = (Math.PI * 2) / entries.length;

            entries.forEach((player, i) => {
                const startA = wheelAngle + i * sliceAngle;
                const endA = startA + sliceAngle;

                ctx.beginPath();
                ctx.moveTo(cx, cy);
                ctx.arc(cx, cy, radius, startA, endA);
                ctx.closePath();

                ctx.fillStyle = WHEEL_COLORS[i % WHEEL_COLORS.length];
                ctx.fill();
                ctx.lineWidth = 1.2;
                ctx.strokeStyle = '#090b10';
                ctx.stroke();

                // Draw player name
                ctx.save();
                ctx.translate(cx, cy);
                ctx.rotate(startA + sliceAngle / 2);
                ctx.textAlign = 'right';
                ctx.textBaseline = 'middle';

                const isLightSlice = ['#eab308', '#10b981', '#38bdf8', '#f59e0b'].includes(WHEEL_COLORS[i % WHEEL_COLORS.length]);
                ctx.fillStyle = isLightSlice ? '#090b10' : '#f8fafc';

                const fontSize = entries.length > 30 ? 11 : entries.length > 18 ? 12.5 : 14;
                ctx.font = `700 ${fontSize}px "Rajdhani", "Plus Jakarta Sans", sans-serif`;

                const label = (player.tier === 'pro' ? '★ ' : '') + player.name;
                const clipped = label.length > 16 ? label.slice(0, 15) + '…' : label;
                ctx.fillText(clipped, radius - 14, 0);
                ctx.restore();
            });

            // Outer Gold Ring
            ctx.beginPath();
            ctx.arc(cx, cy, radius, 0, Math.PI * 2);
            ctx.lineWidth = 4;
            ctx.strokeStyle = '#facc15';
            ctx.stroke();
        }

        function shuffleWheelEntries() {
            if (isSpinning) return;
            const unassigned = state.players.filter(p => !p.teamId);
            const assigned = state.players.filter(p => p.teamId);
            state.players = [...assigned, ...shuffleArray(unassigned)];
            saveState();
            drawWheel();
            if (state.animStyle === 'crate') renderIdleCrateTrack();
            showToast('Urutan daftar nama berhasil dikocok!', 'info');
        }

        /* =======================================================================
           8B. MULTI-ANIMATION CONTROLLER (WHEEL, CASE DROP, CYBER SCAN, CONFETTI)
        ======================================================================= */
        function setAnimStyle(style) {
            if (isSpinning) {
                showToast('Tunggu animasi saat ini selesai terlebih dahulu.', 'info');
                return;
            }
            state.animStyle = style;
            saveState();

            const styles = ['wheel', 'crate', 'decrypt'];
            const labels = {
                wheel: { btn: 'Putar 1x', desc: 'Mode Roda Putar Klasik (Wheel of Names)' },
                crate: { btn: 'Buka Case 1x', desc: 'Mode Case Drop / Tactical Roulette (CS2 Style)' },
                decrypt: { btn: 'Scan Target 1x', desc: 'Mode Cyber Radar & Operator Decrypt' }
            };

            styles.forEach(s => {
                const btn = document.getElementById(`anim-btn-${s}`);
                const stage = document.getElementById(`stage-${s}`);
                if (!btn || !stage) return;
                if (s === style) {
                    btn.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 bg-yellow-500 text-obsidian';
                    stage.classList.remove('hidden');
                } else {
                    btn.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 text-slate-400 hover:text-white';
                    stage.classList.add('hidden');
                }
            });

            document.getElementById('btn-spin-label').textContent = labels[style].btn;
            document.getElementById('anim-mode-desc').textContent = labels[style].desc;

            if (style === 'wheel') {
                setTimeout(() => { resizeWheelCanvas(); drawWheel(); }, 30);
            } else if (style === 'crate') {
                renderIdleCrateTrack();
            } else if (style === 'decrypt') {
                document.getElementById('decrypt-status-tag').textContent = 'STANDBY';
                document.getElementById('decrypt-display-name').textContent = 'READY TO SCAN';
                document.getElementById('decrypt-display-sub').textContent = 'Klik tombol Scan Target untuk memilih operator...';
            }
        }

        // Celebratory Gold & Tactical Confetti Burst
        function fireConfettiBurst() {
            const canvas = document.getElementById('confetti-canvas');
            if (!canvas || !canvas.parentElement) return;
            const rect = canvas.parentElement.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
            const ctx = canvas.getContext('2d');

            const colors = ['#facc15', '#eab308', '#10b981', '#f43f5e', '#ffffff', '#38bdf8'];
            const particles = Array.from({ length: 42 }, () => ({
                x: canvas.width / 2,
                y: canvas.height / 2,
                vx: (Math.random() - 0.5) * 11,
                vy: (Math.random() - 0.7) * 11 - 2,
                size: 4 + Math.random() * 5,
                color: colors[Math.floor(Math.random() * colors.length)],
                rot: Math.random() * Math.PI * 2,
                vrot: (Math.random() - 0.5) * 0.25,
                life: 1
            }));

            function step() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                let alive = false;
                particles.forEach(p => {
                    if (p.life <= 0) return;
                    alive = true;
                    p.x += p.vx;
                    p.y += p.vy;
                    p.vy += 0.28;
                    p.rot += p.vrot;
                    p.life -= 0.022;

                    ctx.save();
                    ctx.globalAlpha = Math.max(0, p.life);
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.rot);
                    ctx.fillStyle = p.color;
                    ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.6);
                    ctx.restore();
                });
                if (alive) {
                    requestAnimationFrame(step);
                } else {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            }
            requestAnimationFrame(step);
        }

        // Shared Completion Handler for ALL 3 Animations
        function completeDraftPick(winner, targetTeam) {
            isSpinning = false;
            winner.teamId = targetTeam.id;
            winner.isLeader = false;
            playWinSound();
            fireConfettiBurst();

            const box = document.getElementById('latest-winner-box');
            document.getElementById('latest-winner-name').textContent = winner.name;
            document.getElementById('latest-winner-dest').innerHTML =
                `Masuk ke <strong class="text-yellow-400">${escapeHtml(targetTeam.name)}</strong> (${escapeHtml(targetTeam.factionName)}) ${winner.tier === 'pro' ? '• <span class="text-amber-300 font-bold">PRO</span>' : ''}`;
            box.classList.add('animate-winner');
            setTimeout(() => box.classList.remove('animate-winner'), 1400);

            saveState();
            renderAll();
            drawWheel();

            if (isAutoSpinning) {
                if (getUnassignedPlayers().length > 0 && getNextTargetTeam()) {
                    setTimeout(() => {
                        if (isAutoSpinning) runDraftOnce(true);
                    }, 550);
                } else {
                    isAutoSpinning = false;
                    updateAutoSpinButton();
                    showToast('Auto-Acak selesai! Semua player telah dibagi.', 'success');
                }
            }
        }

        // Unified Entry Point for Spin / Case Drop / Cyber Scan
        function runDraftOnce(fastMode = false) {
            if (isSpinning) return;

            const entries = getUnassignedPlayers();
            if (entries.length === 0) {
                isAutoSpinning = false;
                updateAutoSpinButton();
                showToast('Tidak ada sisa player untuk diacak!', 'info');
                return;
            }

            const targetTeam = getNextTargetTeam();
            if (!targetTeam) {
                isAutoSpinning = false;
                updateAutoSpinButton();
                showToast('Semua slot tim sudah penuh! Tambah kapasitas tim jika perlu.', 'error');
                return;
            }

            initAudio();
            if (state.animStyle === 'crate') {
                runCrateOpening(entries, targetTeam, fastMode);
            } else if (state.animStyle === 'decrypt') {
                runCyberDecrypt(entries, targetTeam, fastMode);
            } else {
                spinWheelOnce(entries, targetTeam, fastMode);
            }
        }

        // ---- ANIMATION 1: SPINNING WHEEL ----
        function spinWheelOnce(entries, targetTeam, fastMode = false) {
            isSpinning = true;

            const winner = pickWinnerForTeam(targetTeam, entries);
            const winnerIndex = entries.findIndex(p => p.id === winner.id);
            const sliceAngle = (Math.PI * 2) / entries.length;

            // Pointer is at angle 0 (3 o'clock).
            const randomOffset = sliceAngle * (0.2 + Math.random() * 0.6);
            const desiredMod = (Math.PI * 2 - ((winnerIndex * sliceAngle + randomOffset) % (Math.PI * 2))) % (Math.PI * 2);

            const currentMod = ((wheelAngle % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
            let deltaToDesired = desiredMod - currentMod;
            if (deltaToDesired < 0) deltaToDesired += Math.PI * 2;

            const extraSpins = fastMode ? 3 : (6 + Math.floor(Math.random() * 3));
            const totalDelta = extraSpins * Math.PI * 2 + deltaToDesired;

            const startAngle = wheelAngle;
            const duration = fastMode ? 1150 : 3800;
            const startTime = performance.now();
            lastSliceIndex = -1;

            function animate(now) {
                const elapsed = now - startTime;
                const t = Math.min(1, elapsed / duration);
                const easeOut = 1 - Math.pow(1 - t, 3.4);

                wheelAngle = startAngle + totalDelta * easeOut;
                drawWheel();

                const normalized = (((-wheelAngle) % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
                const currentSlice = Math.floor(normalized / sliceAngle);
                if (currentSlice !== lastSliceIndex) {
                    lastSliceIndex = currentSlice;
                    playTickSound();
                }

                if (t < 1) {
                    requestAnimationFrame(animate);
                } else {
                    completeDraftPick(winner, targetTeam);
                }
            }

            requestAnimationFrame(animate);
        }

        // ---- ANIMATION 2: TACTICAL CASE OPENING (ROULETTE STRIP) ----
        function buildCrateCardHtml(player, isWinnerCard = false) {
            const isPro = player.tier === 'pro';
            const borderCls = isPro ? 'border-yellow-400/70 bg-gradient-to-b from-yellow-500/20 to-slate-900' : 'border-slate-700 bg-gradient-to-b from-slate-800/80 to-slate-950';
            const badgeCls = isPro ? 'bg-yellow-400 text-slate-950' : 'bg-slate-800 text-slate-300';
            return `
                <div class="crate-card shrink-0 w-[136px] h-[118px] rounded-xl border-2 ${borderCls} p-3 flex flex-col items-center justify-between text-center select-none transition-transform"
                     data-winner="${isWinnerCard ? '1' : '0'}">
                    <span class="px-2 py-0.5 rounded text-[9px] font-extrabold uppercase tracking-wider ${badgeCls}">
                        ${isPro ? '★ PRO TIER' : 'OPERATOR'}
                    </span>
                    <div class="font-display font-bold text-base text-white leading-tight line-clamp-2 w-full">
                        ${escapeHtml(player.name)}
                    </div>
                    <div class="w-8 h-1 rounded-full ${isPro ? 'bg-yellow-400' : 'bg-emerald-500/70'}"></div>
                </div>
            `;
        }

        function renderIdleCrateTrack() {
            const track = document.getElementById('crate-track');
            if (!track) return;
            const entries = getUnassignedPlayers();
            track.style.transform = 'translateX(0px)';
            if (entries.length === 0) {
                track.innerHTML = `<div class="w-full text-center text-xs text-slate-500 py-8">Semua player sudah masuk tim.</div>`;
                return;
            }
            const sample = Array.from({ length: 12 }, (_, i) => entries[i % entries.length]);
            track.innerHTML = sample.map(p => buildCrateCardHtml(p)).join('');
        }

        function runCrateOpening(entries, targetTeam, fastMode = false) {
            isSpinning = true;
            const winner = pickWinnerForTeam(targetTeam, entries);
            const track = document.getElementById('crate-track');
            const viewport = document.getElementById('crate-viewport');

            const cardWidth = 136;
            const gap = 12;
            const stride = cardWidth + gap;
            const totalCards = fastMode ? 26 : 46;
            const winnerSlotIndex = totalCards - 6;

            const stripPlayers = [];
            for (let i = 0; i < totalCards; i++) {
                if (i === winnerSlotIndex) {
                    stripPlayers.push(winner);
                } else {
                    stripPlayers.push(entries[Math.floor(Math.random() * entries.length)]);
                }
            }
            track.innerHTML = stripPlayers.map((p, i) => buildCrateCardHtml(p, i === winnerSlotIndex)).join('');

            const viewportWidth = viewport.clientWidth || 500;
            const randomJitter = (Math.random() - 0.5) * (cardWidth * 0.55);
            const targetX = -(winnerSlotIndex * stride + cardWidth / 2 - viewportWidth / 2 + randomJitter);

            const duration = fastMode ? 1200 : 4000;
            const startTime = performance.now();
            let lastCardCrossed = -1;

            function animateCrate(now) {
                const elapsed = now - startTime;
                const t = Math.min(1, elapsed / duration);
                const easeOut = 1 - Math.pow(1 - t, 3.6);
                const currentX = targetX * easeOut;

                track.style.transform = `translateX(${currentX}px)`;

                const centerPos = Math.abs(currentX) + viewportWidth / 2;
                const cardIdx = Math.floor(centerPos / stride);
                if (cardIdx !== lastCardCrossed) {
                    lastCardCrossed = cardIdx;
                    playTickSound();
                }

                if (t < 1) {
                    requestAnimationFrame(animateCrate);
                } else {
                    const winCard = track.querySelector('[data-winner="1"]');
                    if (winCard) {
                        winCard.classList.add('ring-2', 'ring-yellow-400', 'scale-105', 'shadow-[0_0_24px_rgba(250,204,21,0.6)]');
                    }
                    completeDraftPick(winner, targetTeam);
                }
            }

            requestAnimationFrame(animateCrate);
        }

        // ---- ANIMATION 3: CYBER RADAR & TACTICAL DECRYPT ----
        function runCyberDecrypt(entries, targetTeam, fastMode = false) {
            isSpinning = true;
            const winner = pickWinnerForTeam(targetTeam, entries);

            const beam = document.getElementById('radar-beam');
            const statusTag = document.getElementById('decrypt-status-tag');
            const nameEl = document.getElementById('decrypt-display-name');
            const subEl = document.getElementById('decrypt-display-sub');
            const iconEl = document.getElementById('decrypt-icon');

            beam.classList.add('radar-sweep-fast');
            statusTag.textContent = 'SCANNING...';
            statusTag.className = 'px-2 py-0.5 rounded bg-emerald-500/20 border border-emerald-500/40 text-[10px] font-bold tracking-widest text-emerald-400 uppercase animate-pulse';
            iconEl.className = 'fa-solid fa-crosshairs text-3xl text-yellow-400 mt-2 animate-spin';
            subEl.textContent = `Mencari operator untuk ${targetTeam.name}...`;

            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#$%&*';
            const totalDuration = fastMode ? 1050 : 2800;
            const lockPhaseStart = totalDuration * 0.55;
            const startTime = performance.now();
            let lastTick = 0;

            function animateDecrypt(now) {
                const elapsed = now - startTime;
                const t = Math.min(1, elapsed / totalDuration);

                if (elapsed < lockPhaseStart) {
                    if (now - lastTick > 70) {
                        lastTick = now;
                        const randP = entries[Math.floor(Math.random() * entries.length)];
                        nameEl.textContent = randP.name;
                        nameEl.className = 'font-display font-bold text-2xl sm:text-3xl tracking-wider text-slate-200 truncate';
                        playTickSound();
                    }
                } else {
                    const lockProgress = (elapsed - lockPhaseStart) / (totalDuration - lockPhaseStart);
                    const revealedCount = Math.floor(lockProgress * winner.name.length);
                    let display = '';
                    for (let i = 0; i < winner.name.length; i++) {
                        if (i < revealedCount || winner.name[i] === ' ') {
                            display += winner.name[i];
                        } else {
                            display += chars[Math.floor(Math.random() * chars.length)];
                        }
                    }
                    nameEl.textContent = display;
                    nameEl.className = 'font-display font-bold text-2xl sm:text-3xl tracking-wider text-yellow-400 truncate';
                    if (now - lastTick > 95) {
                        lastTick = now;
                        playTickSound();
                    }
                }

                if (t < 1) {
                    requestAnimationFrame(animateDecrypt);
                } else {
                    beam.classList.remove('radar-sweep-fast');
                    statusTag.textContent = 'LOCKED ON';
                    statusTag.className = 'px-2 py-0.5 rounded bg-yellow-500 text-obsidian text-[10px] font-extrabold tracking-widest uppercase';
                    iconEl.className = 'fa-solid fa-shield-halved text-3xl text-yellow-400 mt-2';
                    nameEl.textContent = winner.name;
                    subEl.textContent = `LOCKED → ${targetTeam.name} (${targetTeam.factionName})`;
                    completeDraftPick(winner, targetTeam);
                }
            }

            requestAnimationFrame(animateDecrypt);
        }

        function toggleAutoSpin() {
            if (isAutoSpinning) {
                isAutoSpinning = false;
                updateAutoSpinButton();
                showToast('Auto-Acak dihentikan.', 'info');
            } else {
                if (getUnassignedPlayers().length === 0 || !getNextTargetTeam()) {
                    showToast('Tidak ada player atau slot kosong untuk Auto-Acak.', 'error');
                    return;
                }
                isAutoSpinning = true;
                updateAutoSpinButton();
                runDraftOnce(true);
            }
        }

        function updateAutoSpinButton() {
            const btn = document.getElementById('btn-auto-spin');
            if (!btn) return;
            if (isAutoSpinning) {
                btn.className = 'px-5 py-3 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-sm shadow-lg transition flex items-center gap-2';
                btn.innerHTML = '<i class="fa-solid fa-stop"></i> Stop Auto-Acak';
            } else {
                btn.className = 'px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-lg transition flex items-center gap-2';
                btn.innerHTML = '<i class="fa-solid fa-forward"></i> Auto-Acak Semua';
            }
        }

        /* =======================================================================
           9. BOARD INTERACTIONS (LEADER, MANUAL ASSIGN, SWAP, REMOVE)
        ======================================================================= */
        function setTeamLeader(playerId) {
            const player = state.players.find(p => p.id === playerId);
            if (!player || !player.teamId) return;

            const wasLeader = player.isLeader;
            // Clear existing leader in this team
            state.players.forEach(p => {
                if (p.teamId === player.teamId) p.isLeader = false;
            });
            player.isLeader = !wasLeader;

            saveState();
            renderAll();
            showToast(player.isLeader ? `${player.name} dipilih sebagai Squad Leader!` : `Status Leader ${player.name} dilepas.`, 'info');
        }

        function removePlayerFromTeam(playerId) {
            const player = state.players.find(p => p.id === playerId);
            if (!player) return;
            player.teamId = null;
            player.isLeader = false;
            if (swapSourcePlayerId === playerId) cancelSwap();
            saveState();
            renderAll();
        }

        function handleSwapClick(playerId) {
            const clicked = state.players.find(p => p.id === playerId);
            if (!clicked) return;

            if (!swapSourcePlayerId) {
                swapSourcePlayerId = playerId;
                const pill = document.getElementById('swap-status-pill');
                const txt = document.getElementById('swap-status-text');
                pill.classList.remove('hidden');
                txt.textContent = `Tukar "${clicked.name}" dengan... (klik player lain)`;
                renderMainBoard();
                return;
            }

            if (swapSourcePlayerId === playerId) {
                cancelSwap();
                return;
            }

            const source = state.players.find(p => p.id === swapSourcePlayerId);
            if (source) {
                const tempTeam = source.teamId;
                const tempLeader = source.isLeader;
                source.teamId = clicked.teamId;
                source.isLeader = clicked.isLeader;
                clicked.teamId = tempTeam;
                clicked.isLeader = tempLeader;

                showToast(`Berhasil menukar ${source.name} ↔ ${clicked.name}!`, 'success');
            }

            cancelSwap();
            saveState();
            renderAll();
        }

        function cancelSwap() {
            swapSourcePlayerId = null;
            const pill = document.getElementById('swap-status-pill');
            if (pill) pill.classList.add('hidden');
            renderMainBoard();
        }

        // Manual Assign Modal
        function openAssignModal(teamId) {
            const team = getTeamById(teamId);
            if (!team) return;
            assignModalTeamId = teamId;
            document.getElementById('modal-assign-team-name').textContent = `${team.name} (${team.factionName})`;
            document.getElementById('modal-assign-search').value = '';
            const modal = document.getElementById('modal-assign');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            renderAssignModalList();
        }

        function closeAssignModal() {
            assignModalTeamId = null;
            const modal = document.getElementById('modal-assign');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function renderAssignModalList() {
            const listEl = document.getElementById('modal-assign-list');
            const query = (document.getElementById('modal-assign-search').value || '').toLowerCase();
            const available = getUnassignedPlayers().filter(p => p.name.toLowerCase().includes(query));

            if (available.length === 0) {
                listEl.innerHTML = `<p class="text-xs text-slate-500 text-center py-6">Tidak ada player cadangan yang cocok.</p>`;
                return;
            }

            listEl.innerHTML = available.map(p => `
                <button onclick="assignPlayerToModalTeam('${p.id}')"
                    class="w-full px-3 py-2 rounded-xl bg-obsidian hover:bg-slate-800 border border-slate-800 hover:border-yellow-400/50 flex items-center justify-between text-left transition">
                    <span class="text-sm font-medium text-white truncate">${escapeHtml(p.name)}</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase ${p.tier === 'pro' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/40' : 'bg-slate-800 text-slate-400'}">
                        ${p.tier}
                    </span>
                </button>
            `).join('');
        }

        function assignPlayerToModalTeam(playerId) {
            if (!assignModalTeamId) return;
            const team = getTeamById(assignModalTeamId);
            const player = state.players.find(p => p.id === playerId);
            if (!team || !player) return;

            if (getTeamMembers(team.id).length >= team.capacity) {
                showToast(`Slot ${team.name} sudah penuh!`, 'error');
                closeAssignModal();
                return;
            }

            player.teamId = team.id;
            player.isLeader = false;
            saveState();
            renderAll();
            showToast(`${player.name} dimasukkan ke ${team.name}.`, 'success');

            if (getTeamMembers(team.id).length >= team.capacity || getUnassignedPlayers().length === 0) {
                closeAssignModal();
            } else {
                renderAssignModalList();
            }
        }

        // Confirmation Modal (Custom replacement for confirm())
        function openConfirmModal(title, message, onConfirm) {
            document.getElementById('confirm-title').textContent = title;
            document.getElementById('confirm-message').textContent = message;
            confirmCallback = onConfirm;
            const modal = document.getElementById('modal-confirm');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeConfirmModal() {
            confirmCallback = null;
            const modal = document.getElementById('modal-confirm');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('confirm-ok-btn').addEventListener('click', () => {
            const cb = confirmCallback;
            closeConfirmModal();
            if (typeof cb === 'function') cb();
        });

        /* =======================================================================
           10. EXPORT FEATURES (PNG, EXCEL .XLSX, COPY WA/DISCORD)
        ======================================================================= */
        function exportToPNG() {
            const board = document.getElementById('export-board');
            if (!board) return;
            showToast('Menyiapkan gambar HD PNG...', 'info');

            // Hide action buttons inside cards temporarily during screenshot
            const actionEls = board.querySelectorAll('.no-export');
            actionEls.forEach(el => el.classList.add('hidden'));

            setTimeout(() => {
                html2canvas(board, {
                    backgroundColor: '#090b10',
                    scale: 2,
                    useCORS: true,
                    logging: false
                }).then(canvas => {
                    actionEls.forEach(el => el.classList.remove('hidden'));
                    const link = document.createElement('a');
                    const dateStr = new Date().toISOString().slice(0, 10);
                    link.download = `LuxuryElite_DeltaForce_${dateStr}.png`;
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                    showToast('Gambar PNG berhasil diunduh!', 'success');
                }).catch(err => {
                    actionEls.forEach(el => el.classList.remove('hidden'));
                    console.error(err);
                    showToast('Gagal membuat gambar PNG.', 'error');
                });
            }, 80);
        }

        function exportToExcel() {
            try {
                const wb = XLSX.utils.book_new();
                const aoa = [];
                const merges = [];

                // Title row
                aoa.push(['LUXURY ELITE — DELTA FORCE MATCH ROSTER (Credit : iRzell)']);
                aoa.push([]);

                state.factions.forEach(fac => {
                    const numTeams = Math.max(1, fac.teams.length);
                    const startRow = aoa.length;

                    // Faction Title Row
                    const facRow = new Array(numTeams).fill('');
                    facRow[0] = fac.name.toUpperCase();
                    aoa.push(facRow);
                    if (numTeams > 1) {
                        merges.push({ s: { r: startRow, c: 0 }, e: { r: startRow, c: numTeams - 1 } });
                    }

                    // Team Names Row
                    aoa.push(fac.teams.map(t => t.name));

                    // Member Rows
                    const maxCap = Math.max(...fac.teams.map(t => Math.max(t.capacity, getTeamMembers(t.id).length)));
                    for (let rowIdx = 0; rowIdx < maxCap; rowIdx++) {
                        const memberRow = fac.teams.map(t => {
                            const mems = getTeamMembers(t.id);
                            const p = mems[rowIdx];
                            if (!p) return '';
                            return p.isLeader ? `★ ${p.name} (Leader)` : p.name;
                        });
                        aoa.push(memberRow);
                    }
                    aoa.push([]);
                });

                const ws = XLSX.utils.aoa_to_sheet(aoa);
                ws['!merges'] = merges;

                const maxCols = Math.max(...state.factions.map(f => f.teams.length), 5);
                ws['!cols'] = Array.from({ length: maxCols }, () => ({ wch: 24 }));

                XLSX.utils.book_append_sheet(wb, ws, 'DeltaForce_Roster');
                const dateStr = new Date().toISOString().slice(0, 10);
                XLSX.writeFile(wb, `LuxuryElite_DeltaForce_${dateStr}.xlsx`);
                showToast('File Excel (.xlsx) berhasil diunduh!', 'success');
            } catch (err) {
                console.error(err);
                showToast('Gagal export ke Excel.', 'error');
            }
        }

        function copyFormattedText() {
            const lines = [];
            lines.push('🏆 *LUXURY ELITE — DELTA FORCE ROSTER* 🏆');
            lines.push('━━━━━━━━━━━━━━━━━━━━');

            state.factions.forEach(fac => {
                lines.push('');
                lines.push(`⚔️ *${fac.name.toUpperCase()}*`);
                fac.teams.forEach(t => {
                    const mems = getTeamMembers(t.id);
                    lines.push(`\n*${t.name}* (${mems.length}/${t.capacity})`);
                    if (mems.length === 0) {
                        lines.push('  - (Kosong)');
                    } else {
                        mems.forEach((p, idx) => {
                            const leaderTag = p.isLeader ? '👑 ' : `${idx + 1}. `;
                            lines.push(`  ${leaderTag}${p.name}`);
                        });
                    }
                });
            });

            lines.push('\n━━━━━━━━━━━━━━━━━━━━');
            lines.push('_Credit : iRzell • Luxury Elite_');

            const text = lines.join('\n');
            const tempArea = document.createElement('textarea');
            tempArea.value = text;
            tempArea.style.position = 'fixed';
            tempArea.style.opacity = '0';
            document.body.appendChild(tempArea);
            tempArea.select();
            try {
                document.execCommand('copy');
                showToast('Roster berhasil disalin! Siap paste ke WA/Discord.', 'success');
            } catch (e) {
                showToast('Gagal menyalin teks ke clipboard.', 'error');
            }
            document.body.removeChild(tempArea);
        }

        /* =======================================================================
           11. RENDER FUNCTIONS
        ======================================================================= */
        function renderAll() {
            renderStats();
            renderRosterList();
            renderFactionsConfig();
            renderWheelTargetDropdown();
            updateNextTargetLabel();
            renderLiveCompactTeams();
            renderMainBoard();
            renderBenchList();
        }

        function renderStats() {
            const totalPlayers = state.players.length;
            const proPlayers = state.players.filter(p => p.tier === 'pro').length;
            const assignedCount = state.players.filter(p => p.teamId).length;
            const totalSlots = getAllTeamsFlat().reduce((sum, t) => sum + t.capacity, 0);

            document.getElementById('stat-total-players').textContent = totalPlayers;
            document.getElementById('stat-pro-players').textContent = proPlayers;
            document.getElementById('stat-slots').textContent = `${assignedCount}/${totalSlots}`;
            document.getElementById('badge-roster-count').textContent = totalPlayers;
            document.getElementById('wheel-remaining-count').textContent = getUnassignedPlayers().length;

            // Update Export Header Date & Subtitle
            const dateEl = document.getElementById('export-date');
            if (dateEl) {
                dateEl.textContent = new Date().toLocaleDateString('id-ID', {
                    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                });
            }
            const subEl = document.getElementById('export-subtitle');
            if (subEl) {
                const countsText = state.factions
                    .map(f => f.teams.reduce((s, t) => s + t.capacity, 0))
                    .join(' vs ');
                subEl.textContent = `Official Match Roster • ${countsText} Tactical Warfare`;
            }
        }

        function renderRosterList() {
            const container = document.getElementById('roster-list');
            const query = (document.getElementById('search-player').value || '').toLowerCase();
            const filtered = state.players.filter(p => p.name.toLowerCase().includes(query));

            if (filtered.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-8 text-xs text-slate-500 border border-dashed border-slate-800 rounded-xl">
                        Belum ada player. Paste nama di atas atau klik <strong class="text-yellow-400">Muat 40 Demo</strong>.
                    </div>
                `;
                return;
            }

            container.innerHTML = filtered.map((p, idx) => {
                const team = p.teamId ? getTeamById(p.teamId) : null;
                return `
                    <div class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl bg-obsidian border border-slate-800/90 hover:border-slate-700 transition">
                        <div class="min-w-0 flex items-center gap-2">
                            <span class="text-[10px] font-mono text-slate-500 w-5">${idx + 1}.</span>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-sm font-medium text-white truncate">${escapeHtml(p.name)}</div>
                                ${team ? `<div class="text-[10px] text-emerald-400 truncate">${escapeHtml(team.name)} (${escapeHtml(team.factionName)})</div>` : ''}
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <button onclick="togglePlayerTier('${p.id}')" title="Klik untuk ubah tier Pro/Normal"
                                class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold uppercase tracking-wider transition ${
                                    p.tier === 'pro'
                                        ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/40 hover:bg-yellow-500/30'
                                        : 'bg-slate-800 text-slate-400 border border-slate-700 hover:text-white'
                                }">
                                ${p.tier === 'pro' ? '★ PRO' : 'NORMAL'}
                            </button>
                            <button onclick="deletePlayer('${p.id}')" title="Hapus player"
                                class="p-1 text-slate-500 hover:text-rose-400 transition">
                                <i class="fa-solid fa-xmark text-xs"></i>
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderFactionsConfig() {
            const container = document.getElementById('factions-config-list');
            const accentBorder = {
                emerald: 'border-emerald-500/30',
                rose: 'border-rose-500/30',
                sky: 'border-sky-500/30',
                amber: 'border-amber-500/30'
            };
            const accentDot = {
                emerald: 'bg-emerald-400',
                rose: 'bg-rose-400',
                sky: 'bg-sky-400',
                amber: 'bg-amber-400'
            };

            container.innerHTML = state.factions.map(fac => {
                const totalCap = fac.teams.reduce((sum, t) => sum + t.capacity, 0);
                return `
                    <div class="rounded-2xl bg-obsidian border ${accentBorder[fac.accent] || 'border-slate-800'} p-3.5 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 flex-1">
                                <span class="w-2.5 h-2.5 rounded-full ${accentDot[fac.accent] || 'bg-yellow-400'} shrink-0"></span>
                                <input type="text" value="${escapeHtml(fac.name)}"
                                    onchange="updateFactionName('${fac.id}', this.value)"
                                    class="w-full bg-transparent font-display font-bold text-base text-white border-b border-transparent focus:border-yellow-400 outline-none">
                            </div>
                            <span class="text-[11px] text-slate-400 shrink-0">${totalCap} slot</span>
                            <button onclick="addTeamToFaction('${fac.id}')" title="Tambah Tim"
                                class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs text-emerald-400 font-semibold transition">
                                <i class="fa-solid fa-plus"></i> Tim
                            </button>
                            ${state.factions.length > 1 ? `
                                <button onclick="deleteFaction('${fac.id}')" title="Hapus Fraksi"
                                    class="p-1 text-slate-500 hover:text-rose-400 transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            ` : ''}
                        </div>

                        <div class="space-y-1.5">
                            ${fac.teams.map(t => `
                                <div class="flex items-center justify-between gap-2 px-2.5 py-1.5 rounded-xl bg-panel border border-slate-800/80">
                                    <input type="text" value="${escapeHtml(t.name)}"
                                        onchange="updateTeamName('${fac.id}', '${t.id}', this.value)"
                                        class="flex-1 bg-transparent text-xs font-semibold text-slate-200 outline-none focus:text-yellow-300 min-w-0">
                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <span class="text-[10px] text-slate-500">Slot:</span>
                                        <input type="number" min="1" max="20" value="${t.capacity}"
                                            onchange="updateTeamCapacity('${fac.id}', '${t.id}', this.value)"
                                            class="w-12 px-1.5 py-0.5 rounded-lg bg-obsidian border border-slate-700 text-xs text-center text-yellow-400 font-bold outline-none focus:border-yellow-400">
                                        <button onclick="deleteTeam('${fac.id}', '${t.id}')" title="Hapus Tim"
                                            class="p-1 text-slate-500 hover:text-rose-400 transition">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function renderWheelTargetDropdown() {
            const sel = document.getElementById('wheel-target-team');
            if (!sel) return;
            const currentVal = state.wheelTarget;
            let html = `<option value="auto">Target: Otomatis (Isi Merata)</option>`;
            state.factions.forEach(fac => {
                html += `<optgroup label="${escapeHtml(fac.name)}">`;
                fac.teams.forEach(t => {
                    const count = getTeamMembers(t.id).length;
                    html += `<option value="${t.id}">${escapeHtml(t.name)} (${count}/${t.capacity})</option>`;
                });
                html += `</optgroup>`;
            });
            sel.innerHTML = html;
            sel.value = currentVal;
            if (!sel.value) sel.value = 'auto';
        }

        function updateNextTargetLabel() {
            const el = document.getElementById('wheel-next-target-label');
            if (!el) return;
            const next = getNextTargetTeam();
            el.textContent = next ? `${next.name} (${next.factionName})` : 'Semua Tim Penuh';
        }

        function renderLiveCompactTeams() {
            const container = document.getElementById('live-compact-teams');
            if (!container) return;

            container.innerHTML = state.factions.map(fac => `
                <div class="space-y-1.5">
                    <div class="text-[11px] font-display font-bold uppercase tracking-wider text-slate-400">${escapeHtml(fac.name)}</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        ${fac.teams.map(t => {
                            const mems = getTeamMembers(t.id);
                            const pct = Math.min(100, Math.round((mems.length / t.capacity) * 100));
                            return `
                                <div class="rounded-xl bg-obsidian border border-slate-800 p-2.5">
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="font-bold text-white truncate">${escapeHtml(t.name)}</span>
                                        <span class="${mems.length >= t.capacity ? 'text-emerald-400' : 'text-yellow-400'} font-mono text-[11px]">${mems.length}/${t.capacity}</span>
                                    </div>
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden mb-1.5">
                                        <div class="h-full ${mems.length >= t.capacity ? 'bg-emerald-400' : 'bg-yellow-400'} transition-all" style="width:${pct}%"></div>
                                    </div>
                                    <div class="text-[11px] text-slate-400 truncate">
                                        ${mems.length > 0 ? mems.map(m => escapeHtml(m.name)).join(', ') : '<span class="italic text-slate-600">Kosong</span>'}
                                    </div>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            `).join('');
        }

        function renderMainBoard() {
            const container = document.getElementById('board-factions-container');
            if (!container) return;
            const showTier = document.getElementById('toggle-show-tier')?.checked ?? true;

            const factionHeaderStyles = {
                emerald: 'from-emerald-500/20 to-transparent border-emerald-500/40 text-emerald-400',
                rose: 'from-rose-500/20 to-transparent border-rose-500/40 text-rose-400',
                sky: 'from-sky-500/20 to-transparent border-sky-500/40 text-sky-400',
                amber: 'from-amber-500/20 to-transparent border-amber-500/40 text-amber-400'
            };

            container.innerHTML = state.factions.map(fac => {
                const facPlayers = fac.teams.reduce((s, t) => s + getTeamMembers(t.id).length, 0);
                const facCap = fac.teams.reduce((s, t) => s + t.capacity, 0);
                const facPros = fac.teams.reduce((s, t) => s + getTeamMembers(t.id).filter(m => m.tier === 'pro').length, 0);

                return `
                    <div class="space-y-4">
                        <!-- Faction Header Bar -->
                        <div class="flex flex-wrap items-center justify-between gap-2 px-4 py-2.5 rounded-2xl bg-gradient-to-r ${factionHeaderStyles[fac.accent] || factionHeaderStyles.emerald} border">
                            <h3 class="font-display font-bold text-xl tracking-widest uppercase">${escapeHtml(fac.name)}</h3>
                            <div class="flex items-center gap-3 text-xs font-semibold text-slate-300">
                                <span>Total: <strong class="text-white">${facPlayers}/${facCap}</strong></span>
                                ${showTier ? `<span>Pro: <strong class="text-yellow-400">${facPros}</strong></span>` : ''}
                            </div>
                        </div>

                        <!-- Teams Grid (5 columns on desktop like example screenshot) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3.5">
                            ${fac.teams.map((t, tIdx) => {
                                const mems = getTeamMembers(t.id);
                                const emptySlots = Math.max(0, t.capacity - mems.length);
                                const animAttr = shouldAnimateBoardCards
                                    ? `style="animation-delay: ${tIdx * 75}ms"`
                                    : '';
                                const animCls = shouldAnimateBoardCards ? 'animate-card-drop' : '';
                                return `
                                    <div ${animAttr} class="${animCls} rounded-2xl bg-panel border border-slate-800 overflow-hidden flex flex-col shadow-lg">
                                        <!-- Team Header -->
                                        <div class="px-3.5 py-2.5 bg-slate-900/90 border-b border-slate-800 flex items-center justify-between gap-2">
                                            <span class="font-display font-black text-base text-white uppercase tracking-wider truncate">${escapeHtml(t.name)}</span>
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold ${mems.length >= t.capacity ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-slate-800 text-slate-400 border border-slate-700'}">
                                                ${mems.length}/${t.capacity}
                                            </span>
                                        </div>

                                        <!-- Members List -->
                                        <div class="divide-y divide-slate-800/70 flex-1">
                                            ${mems.map((p, pIdx) => {
                                                const isSwapSelected = swapSourcePlayerId === p.id;
                                                const rowBg = p.isLeader
                                                    ? 'bg-gradient-to-r from-yellow-400 via-amber-400 to-yellow-500 text-obsidian font-bold shadow-sm'
                                                    : isSwapSelected
                                                        ? 'bg-sky-500/25 text-white ring-1 ring-inset ring-sky-400'
                                                        : 'bg-transparent text-slate-100 hover:bg-slate-800/50';
                                                const iconBtnCls = p.isLeader
                                                    ? 'text-obsidian/75 hover:text-obsidian'
                                                    : 'text-slate-500 hover:text-white';

                                                return `
                                                    <div class="px-3 py-2 flex items-center justify-between gap-1.5 text-xs transition ${rowBg}">
                                                        <div class="min-w-0 flex items-center gap-1.5">
                                                            <span class="font-mono text-[10px] ${p.isLeader ? 'text-obsidian/70 font-bold' : 'text-slate-500'} w-4 shrink-0">${pIdx + 1}.</span>
                                                            ${p.isLeader ? '<span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-obsidian text-yellow-400 text-[9px] font-mono font-black tracking-wider uppercase shrink-0"><i class="fa-solid fa-crown text-[8px]"></i> LEADER</span>' : ''}
                                                            <span class="truncate font-medium">${escapeHtml(p.name)}</span>
                                                            ${showTier && p.tier === 'pro' ? `
                                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-mono font-extrabold uppercase shrink-0 ${p.isLeader ? 'bg-obsidian/20 text-obsidian border border-obsidian/40' : 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30'}">PRO</span>
                                                            ` : ''}
                                                        </div>
                                                        <div class="no-export flex items-center gap-1 shrink-0">
                                                            <button onclick="setTeamLeader('${p.id}')" title="Jadikan Squad Leader" class="p-1 transition ${p.isLeader ? 'text-obsidian' : 'text-slate-500 hover:text-yellow-400'}">
                                                                <i class="fa-solid fa-crown text-[11px]"></i>
                                                            </button>
                                                            <button onclick="handleSwapClick('${p.id}')" title="Tukar Posisi Player" class="p-1 transition ${isSwapSelected ? 'text-sky-300' : iconBtnCls}">
                                                                <i class="fa-solid fa-right-left text-[11px]"></i>
                                                            </button>
                                                            <button onclick="removePlayerFromTeam('${p.id}')" title="Keluarkan ke Cadangan" class="p-1 transition ${p.isLeader ? 'text-obsidian/70 hover:text-rose-800' : 'text-slate-500 hover:text-rose-400'}">
                                                                <i class="fa-solid fa-xmark text-[11px]"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                `;
                                            }).join('')}

                                            ${Array.from({ length: emptySlots }).map((_, sIdx) => `
                                                <div class="px-3 py-2 text-xs text-slate-600 font-mono italic bg-obsidian/30 flex items-center gap-1.5">
                                                    <span class="text-slate-700 w-4">${mems.length + sIdx + 1}.</span>
                                                    <span>// SLOT KOSONG</span>
                                                </div>
                                            `).join('')}
                                        </div>

                                        <!-- Manual Assign Footer Button -->
                                        ${emptySlots > 0 ? `
                                            <button onclick="openAssignModal('${t.id}')"
                                                class="no-export w-full py-2 text-[11px] font-semibold text-emerald-400 hover:bg-emerald-500/10 border-t border-slate-800/80 transition flex items-center justify-center gap-1">
                                                <i class="fa-solid fa-plus"></i> Isi Manual
                                            </button>
                                        ` : ''}
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                `;
            }).join('');
            shouldAnimateBoardCards = false;
        }

        function renderBenchList() {
            const container = document.getElementById('bench-list');
            const bench = getUnassignedPlayers();
            document.getElementById('bench-count').textContent = bench.length;

            if (bench.length === 0) {
                container.innerHTML = `<span class="text-xs text-slate-500 italic">Semua player sudah masuk ke dalam tim.</span>`;
                return;
            }

            container.innerHTML = bench.map(p => `
                <div class="px-3 py-1.5 rounded-xl bg-obsidian border border-slate-800 text-xs text-slate-200 flex items-center gap-2">
                    <span>${escapeHtml(p.name)}</span>
                    ${p.tier === 'pro' ? '<span class="px-1.5 py-0.5 rounded bg-yellow-500/20 text-yellow-400 text-[9px] font-bold">PRO</span>' : ''}
                </div>
            `).join('');
        }

        /* =======================================================================
           12. INITIALIZATION & RESIZE LISTENER
        ======================================================================= */
        window.addEventListener('resize', () => {
            if (currentTab === 'wheel' && state.animStyle === 'wheel') {
                resizeWheelCanvas();
                drawWheel();
            }
        });

        window.onload = function () {
            loadState();
            setRandomMode(state.randomMode);
            setAnimStyle(state.animStyle || 'wheel');
            if (!state.soundEnabled) {
                document.getElementById('icon-sound').className = 'fa-solid fa-volume-xmark text-slate-500';
            }
            renderAll();
            resizeWheelCanvas();
            drawWheel();
        };
    </script>
</body>
</html>