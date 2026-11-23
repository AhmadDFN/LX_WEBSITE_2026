@extends('layouts.app')

@section('title', 'Player Management - Luxury Elite')
@section('page_title', '1. Management Player & Roster')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8" x-data="{
    editModalOpen: false,
    roleModalOpen: false,
    squadModalOpen: false,
    selectedPlayer: null,
    selectedUser: null,
    openEdit(player) {
        this.selectedPlayer = player;
        this.editModalOpen = true;
    },
    openRole(user) {
        this.selectedUser = user;
        this.roleModalOpen = true;
    },
    openSquad(player) {
        this.selectedPlayer = player;
        this.squadModalOpen = true;
    }
}">
    @include('management.partials.nav')

    <!-- FILTER & SEARCH BAR -->
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 p-4 rounded-xl bg-[#090b10] border border-white/5">
        <!-- TIER TABS -->
        <div class="flex items-center gap-1 overflow-x-auto pb-1 sm:pb-0">
            <a href="{{ route('management.players.index', ['tier' => 'all', 'q' => $search]) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold uppercase transition whitespace-nowrap
                {{ $tier === 'all' ? 'bg-yellow-500 text-black' : 'text-zinc-400 hover:text-white bg-zinc-900' }}">
                All ({{ $players->count() }})
            </a>
            <a href="{{ route('management.players.index', ['tier' => 'competitive', 'q' => $search]) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold uppercase transition whitespace-nowrap
                {{ $tier === 'competitive' ? 'bg-yellow-500 text-black' : 'text-zinc-400 hover:text-white bg-zinc-900' }}">
                Competitive Core
            </a>
            <a href="{{ route('management.players.index', ['tier' => 'trial', 'q' => $search]) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold uppercase transition whitespace-nowrap
                {{ $tier === 'trial' ? 'bg-yellow-500 text-black' : 'text-zinc-400 hover:text-white bg-zinc-900' }}">
                Trial
            </a>
            <a href="{{ route('management.players.index', ['tier' => 'casual', 'q' => $search]) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold uppercase transition whitespace-nowrap
                {{ $tier === 'casual' ? 'bg-yellow-500 text-black' : 'text-zinc-400 hover:text-white bg-zinc-900' }}">
                Casual
            </a>
            <a href="{{ route('management.players.index', ['tier' => 'inactive', 'q' => $search]) }}"
                class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold uppercase transition whitespace-nowrap
                {{ $tier === 'inactive' ? 'bg-yellow-500 text-black' : 'text-zinc-400 hover:text-white bg-zinc-900' }}">
                Inactive / Bench
            </a>
        </div>

        <!-- SEARCH FORM -->
        <form method="GET" action="{{ route('management.players.index') }}" class="flex items-center gap-2">
            <input type="hidden" name="tier" value="{{ $tier }}">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search IGN / UID..."
                class="px-3 py-1.5 rounded-lg bg-zinc-900 border border-zinc-800 text-xs font-mono text-white placeholder-zinc-500 focus:outline-none focus:border-yellow-500 w-full sm:w-48">
            <button type="submit" class="px-3 py-1.5 rounded-lg bg-zinc-800 hover:bg-zinc-700 text-xs font-mono text-zinc-300">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <!-- PLAYERS TABLE -->
    <div class="rounded-2xl bg-[#090b10] border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans">
                <thead class="bg-carbon-900 border-b border-zinc-800 text-[11px] font-mono text-zinc-400 uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Operator / IGN</th>
                        <th class="py-3.5 px-4">Delta Force UID</th>
                        <th class="py-3.5 px-4">Preferred Class</th>
                        <th class="py-3.5 px-4">Squad Allocation</th>
                        <th class="py-3.5 px-4">Roster Status</th>
                        <th class="py-3.5 px-4">Command Role</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800/60 font-mono">
                    @forelse($players as $player)
                    <tr class="hover:bg-carbon-900/40 transition">
                        <!-- IGN / User -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-carbon-800 border border-zinc-700 flex items-center justify-center font-bold text-yellow-400 overflow-hidden shrink-0">
                                    @if($player->avatar_url)
                                        <img src="{{ $player->avatar_url }}" alt="{{ $player->ign }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($player->ign, 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-white text-sm font-sans flex items-center gap-2">
                                        {{ $player->ign }}
                                        @if($player->status === 'active')
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400" title="Active"></span>
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-zinc-600" title="Inactive"></span>
                                        @endif
                                    </div>
                                    <div class="text-[11px] text-zinc-500 font-mono">{{ $player->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- UID -->
                        <td class="py-3.5 px-4 text-zinc-300">
                            {{ $player->delta_force_uid ?? 'N/A' }}
                            @if($player->discord_tag)
                            <div class="text-[10px] text-zinc-500 flex items-center gap-1 mt-0.5">
                                <i class="fa-brands fa-discord"></i> {{ $player->discord_tag }}
                            </div>
                            @endif
                        </td>

                        <!-- Class -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider
                                    @if($player->preferred_class === 'assault') bg-red-500/15 text-red-400 border border-red-500/30
                                    @elseif($player->preferred_class === 'engineer') bg-amber-500/15 text-amber-400 border border-amber-500/30
                                    @elseif($player->preferred_class === 'support') bg-emerald-500/15 text-emerald-400 border border-emerald-500/30
                                    @else bg-cyan-500/15 text-cyan-400 border border-cyan-500/30
                                    @endif">
                                    {{ $player->preferred_class }}
                                </span>
                                <span class="font-bold text-yellow-400 text-[11px]">
                                    {{ $player->rank_tier ?? 'Pinnacle' }}
                                </span>
                            </div>
                        </td>

                        <!-- Squad Allocation -->
                        <td class="py-3.5 px-4">
                            @if($player->squads->isNotEmpty())
                                @php $sq = $player->squads->first(); @endphp
                                <div class="text-white font-bold text-xs font-sans">
                                    {{ $sq->squad_name }}
                                </div>
                                <div class="text-[10px] text-zinc-400 flex items-center gap-1 mt-0.5">
                                    <span class="px-1.5 py-0.2 rounded bg-zinc-800 text-yellow-400 uppercase font-mono font-semibold">
                                        {{ $sq->pivot->slot_type ?? 'Starter' }}
                                    </span>
                                    <span>{{ $sq->pivot->role_specialization ?? '' }}</span>
                                </div>
                            @else
                                <span class="text-zinc-500 text-[11px] italic">Belum Ada Skuad</span>
                            @endif
                        </td>

                        <!-- Status / Type -->
                        <td class="py-3.5 px-4">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                @if($player->player_type === 'competitive') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                @elseif($player->player_type === 'trial') bg-purple-500/20 text-purple-400 border border-purple-500/30
                                @elseif($player->player_type === 'casual') bg-blue-500/20 text-blue-400 border border-blue-500/30
                                @else bg-zinc-800 text-zinc-400
                                @endif">
                                {{ strtoupper($player->player_type) }}
                            </span>
                        </td>

                        <!-- User Role -->
                        <td class="py-3.5 px-4">
                            @if($player->user)
                            <button @click="openRole({{ json_encode($player->user) }})" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider hover:ring-1 hover:ring-yellow-400 transition cursor-pointer
                                @if($player->user->role === 'superadmin') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                @elseif($player->user->role === 'manager') bg-cyan-500/20 text-cyan-400 border border-cyan-500/30
                                @elseif($player->user->role === 'coach') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                @elseif($player->user->role === 'captain') bg-purple-500/20 text-purple-400 border border-purple-500/30
                                @else bg-zinc-800 text-zinc-300 border border-zinc-700
                                @endif" title="Klik untuk ubah role pengurus">
                                {{ strtoupper($player->user->role) }} <i class="fa-solid fa-pen text-[8px] ml-1 opacity-70"></i>
                            </button>
                            @else
                            <span class="text-zinc-600">-</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-right space-x-1.5">
                            @if($player->player_type === 'trial')
                            <form action="{{ route('management.players.promoteTrial', $player->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Promote {{ $player->ign }} menjadi Competitive Core Roster resmi?')" class="px-2.5 py-1 rounded bg-emerald-500/20 hover:bg-emerald-500 hover:text-black text-emerald-400 border border-emerald-500/30 font-bold transition text-[11px]" title="Promote Trial to Competitive Core">
                                    <i class="fa-solid fa-arrow-up"></i> Angkat Core
                                </button>
                            </form>
                            @endif

                            <button @click="openSquad({{ json_encode($player) }})" class="px-2.5 py-1 rounded bg-zinc-800 hover:bg-zinc-700 text-yellow-400 font-bold transition text-[11px]" title="Tugaskan ke Skuad">
                                <i class="fa-solid fa-shield"></i> Skuad
                            </button>

                            <button @click="openEdit({{ json_encode($player) }})" class="px-2.5 py-1 rounded bg-zinc-800 hover:bg-yellow-500 hover:text-black text-zinc-300 font-bold transition text-[11px]">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-10 text-center text-zinc-500">
                            Tidak ada player ditemukan untuk kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- STAFF COMMAND HIERARCHY OVERVIEW -->
    <div class="p-6 rounded-2xl bg-[#090b10] border border-white/5 space-y-4">
        <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-shield-halved text-yellow-400"></i>
                <h3 class="text-xs font-mono uppercase tracking-widest text-white">Struktur Pengurus &amp; Command Staff Clan</h3>
            </div>
            <span class="text-[11px] font-mono text-zinc-400">Total Pengurus: {{ $allUsers->whereIn('role', ['superadmin', 'manager', 'coach', 'captain'])->count() }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($allUsers->whereIn('role', ['superadmin', 'manager', 'coach', 'captain']) as $staff)
            <div class="p-4 rounded-xl bg-carbon-900 border border-zinc-800 flex items-center justify-between gap-3">
                <div>
                    <div class="font-bold text-sm text-white">{{ $staff->name }}</div>
                    <div class="text-[11px] font-mono text-zinc-400">{{ $staff->email }}</div>
                    <span class="inline-block mt-2 px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase
                        @if($staff->role === 'superadmin') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                        @elseif($staff->role === 'manager') bg-cyan-500/20 text-cyan-400 border border-cyan-500/30
                        @elseif($staff->role === 'coach') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                        @else bg-purple-500/20 text-purple-400 border border-purple-500/30
                        @endif">
                        {{ strtoupper($staff->role) }}
                    </span>
                </div>
                <button @click="openRole({{ json_encode($staff) }})" class="p-2 rounded bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-white transition text-xs">
                    <i class="fa-solid fa-pen"></i>
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- MODAL 1: EDIT PLAYER DOSSIER -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-lg w-full p-6 space-y-5 shadow-2xl" @click.away="editModalOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-yellow-400"></i> Edit Player Dossier
                </h3>
                <button @click="editModalOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <template x-if="selectedPlayer">
                <form :action="'{{ url('/management/players') }}/' + selectedPlayer.id + '/update'" method="POST" class="space-y-4 text-xs font-mono">
                    @csrf
                    <div>
                        <label class="block text-zinc-400 mb-1">IN-GAME NAME (IGN)</label>
                        <input type="text" name="ign" :value="selectedPlayer.ign" required
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-zinc-400 mb-1">DELTA FORCE UID</label>
                            <input type="text" name="delta_force_uid" :value="selectedPlayer.delta_force_uid" required
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                        <div>
                            <label class="block text-zinc-400 mb-1">DISCORD TAG</label>
                            <input type="text" name="discord_tag" :value="selectedPlayer.discord_tag"
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-zinc-400 mb-1">PREFERRED CLASS</label>
                            <select name="preferred_class" :value="selectedPlayer.preferred_class" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                                <option value="assault">Assault</option>
                                <option value="engineer">Engineer</option>
                                <option value="support">Support</option>
                                <option value="recon">Recon</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-zinc-400 mb-1">RANK TIER</label>
                            <select name="rank_tier" :value="selectedPlayer.rank_tier" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                                <option value="Pinnacle">Pinnacle</option>
                                <option value="Master">Master</option>
                                <option value="Diamond">Diamond</option>
                                <option value="Platinum">Platinum</option>
                                <option value="Gold">Gold</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-zinc-400 mb-1">ROSTER TIER (STATUS)</label>
                            <select name="player_type" :value="selectedPlayer.player_type" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                                <option value="competitive">Competitive Core (Starter/Sub)</option>
                                <option value="trial">Trial Operator</option>
                                <option value="casual">Casual Member</option>
                                <option value="inactive">Inactive / Bench</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-zinc-400 mb-1">ACTIVITY STATUS</label>
                            <select name="status" :value="selectedPlayer.status" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- MODAL 2: ASSIGN ROLE PENGURUS -->
    <div x-show="roleModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-md w-full p-6 space-y-5 shadow-2xl" @click.away="roleModalOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-user-shield text-yellow-400"></i> Atur Role Pengurus
                </h3>
                <button @click="roleModalOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <template x-if="selectedUser">
                <form :action="'{{ url('/management/users') }}/' + selectedUser.id + '/update-role'" method="POST" class="space-y-4 text-xs font-mono">
                    @csrf
                    <div>
                        <div class="text-zinc-400">USER ACCOUNT</div>
                        <div class="text-white text-sm font-bold mt-1" x-text="selectedUser.name + ' (' + selectedUser.email + ')'"></div>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">COMMAND PRIVILEGE ROLE</label>
                        <select name="role" :value="selectedUser.role" class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            <option value="superadmin">Superadmin (Owner - Full Root Access)</option>
                            <option value="manager">Manager (Operasional Clan &amp; Scrim)</option>
                            <option value="coach">Head Coach (Taktik, Lineup &amp; Evaluasi)</option>
                            <option value="captain">Squad Captain / IGL</option>
                            <option value="player">Player (Roster Resmi)</option>
                            <option value="casual_member">Casual Member</option>
                        </select>
                        <p class="text-[11px] text-zinc-500 mt-2">
                            *Role Superadmin, Manager, dan Coach memiliki akses ke seluruh dashboard management.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                        <button type="button" @click="roleModalOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider transition">
                            Update Role
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>

    <!-- MODAL 3: ASSIGN SQUAD ALLOCATION -->
    <div x-show="squadModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="bg-carbon-900 border border-yellow-500/30 rounded-2xl max-w-md w-full p-6 space-y-5 shadow-2xl" @click.away="squadModalOpen = false">
            <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                <h3 class="text-lg font-black text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-shield text-yellow-400"></i> Penugasan Skuad Taktis
                </h3>
                <button @click="squadModalOpen = false" class="text-zinc-400 hover:text-white text-lg">&times;</button>
            </div>

            <template x-if="selectedPlayer">
                <form :action="'{{ url('/management/players') }}/' + selectedPlayer.id + '/assign-squad'" method="POST" class="space-y-4 text-xs font-mono">
                    @csrf
                    <div>
                        <div class="text-zinc-400">OPERATOR</div>
                        <div class="text-white text-sm font-bold mt-0.5" x-text="selectedPlayer.ign + ' (' + selectedPlayer.preferred_class.toUpperCase() + ')'"></div>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">TARGET SKUAD <span class="text-yellow-400">*</span></label>
                        <select name="squad_id" required class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                            @foreach($squads as $sq)
                                <option value="{{ $sq->id }}">{{ $sq->squad_name }} ({{ $sq->gameMode->name ?? 'DF' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-zinc-400 mb-1">SLOT TYPE <span class="text-yellow-400">*</span></label>
                            <select name="slot_type" required class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                                <option value="starter">Starter (Lineup Utama)</option>
                                <option value="substitute">Substitute (Cadangan)</option>
                                <option value="reserve">Reserve (Cadangan Tambahan)</option>
                                <option value="standin">Stand-in (Pemain Pengganti)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-zinc-400 mb-1">SUB-TEAM NO. (HAVOC)</label>
                            <input type="number" name="sub_team_number" min="1" max="5" placeholder="1-5"
                                class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-zinc-400 mb-1">ROLE SPESIALISASI TAKTIS</label>
                        <input type="text" name="role_specialization" placeholder="e.g. IGL / Captain, Entry Fragger, Anchor, Sniper"
                            class="w-full px-3 py-2 rounded-lg bg-zinc-900 border border-zinc-700 text-white focus:outline-none focus:border-yellow-400">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-800">
                        <button type="button" @click="squadModalOpen = false" class="px-4 py-2 rounded-lg bg-zinc-800 text-zinc-300 hover:bg-zinc-700 transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-400 text-black font-bold uppercase tracking-wider transition">
                            Assign to Squad
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>
@endsection
