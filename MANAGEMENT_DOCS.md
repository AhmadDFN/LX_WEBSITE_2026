# Luxury Elite — Platform Management & Operational Documentation

> **Status:** Active Reference & Production Specification  
> **Repository:** `https://github.com/AhmadDFN/LX_WEB_NEW2026.git`  
> **Production URL:** `https://luxuryelite.web.id/`  
> **Target Game:** Delta Force (Detonation 5v5, Hazard Operations 3v3, Havoc Warfare 32v32)  
> **Framework & Tech Stack:** Laravel 11.x, PHP 8.3+, Tailwind CSS, Alpine.js, MySQL / SQLite, Tone.js, SheetJS, HTML2Canvas.

---

## 1. Changelog & Rekam Jejak Pengerjaan

### Selesai Dikerjakan (Completed)
1. **Landing Page & UI Overhaul (`#020612` Dark Gold Theme):**
   - Mengadopsi desain presisi dari referensi Svelte/Hostinger dengan font *Instrument Sans* & *Inter*.
   - Implementasi efek animasi: `gold-shimmer`, `float-anim` untuk 3D Diamond logo, dan 6-kolom dynamic roster grid.
   - Perbaikan seluruh aset grafis resolusi tinggi (`logo-lx.png`, `irzell.png`, `Jersey.jpeg`, `favicon.ico`, `apple-touch-icon.png`).
2. **Tactical Tool: Delta Force 20v20 Draft & Randomizer (Credit: iRzell):**
   - Terintegrasi penuh ke dalam sistem Laravel di rute:
     - `/tools/randomizer`
     - `/draft-randomizer`
   - Menyediakan fitur audio synthesizer (Tone.js), Roulette Crate Drop animation, Cyber Radar Sweep, generator faksi seimbang, serta ekspor gambar (HTML2Canvas) dan Excel (SheetJS).
   - Terhubung dengan navigasi utama di Navbar Desktop, Mobile menu, dan tombol kembali ke HQ.
3. **Database Scaffolding Dasar:**
   - Tabel: `users`, `game_modes`, `player_profiles`, `squads`, `squad_members`, `scrim_matches`, `scrim_attendances`, `match_results`, `recruitment_applications`.
   - Migration baru: `2026_10_14_000009_create_tournaments_and_matches_tables.php` untuk `tournaments` dan `tournament_matches`.
   - Model Eloquent `Tournament` dan `TournamentMatch` terpasang dengan relasi penuh.
4. **Portal Command Ops & 3 Modul Management:**
   - Dashboard Terpadu Pengurus: `/management`
   - Modul 1 — Player & Staff Roles: `/management/players` (filter tier, edit dossier, assign privilege role pengurus).
   - Modul 2 — Scrim Operations: `/management/scrims` (jadwal scrim, room credential vault reveal/hide, input hasil & evaluasi coach).
   - Modul 3 — Tournaments & Brackets: `/management/tournaments` & `/management/tournaments/{id}` (registrasi turnamen, fixture ronde, scoring, dan pencatatan gelar juara/placement).
5. **Resilience & Production Verification:**
   - Seluruh query dibungkus penanganan fallback database (`try-catch`) agar website tetap berjalan 100% stabil saat database maintenance.
   - Pengujian live di server produksi Hostinger: seluruh rute publik & tools mengembalikan `HTTP 200 OK`.

---

## 2. Rencana & Struktur Pengerjaan Fitur Management

Sesuai arahan, sistem dibagi menjadi 3 pilar utama dengan antarmuka pengurus (Management Ops) terpadu:

```
                                  [ MANAGEMENT OPS ]
                                          |
        +---------------------------------+---------------------------------+
        |                                 |                                 |
[ 1. Player Management ]        [ 2. Scrim Management ]         [ 3. Tour Management ]
  - Roster Directory              - Scrim Scheduler               - Tournament Master
  - Tier & Status Matrix          - Secret Room Key Lock          - Bracket Generator
  - Squad Assignment              - Live Player RSVP Tracker      - Match Scoring
  - UID & Class Roles             - Result & Proof Upload         - Standings Leaderboard
  - Trial Promotion/Demotion      - Tactical Coach Evaluation     - Clan Trophy Room
```

### Modul 1: Management Player
- **Direktori Player:** Menampilkan seluruh roster dengan status (Starter / Core, Substitute, Trial, Bench / Inactive).
- **Spesialisasi Role:** Assault, Engineer, Support, Recon, serta peran taktis (IGL, Entry, Anchor, Sniper, Pilot).
- **Edit & Mutasi:** Penugasan squad (`LX Alpha`, `LX Bravo`, dll), update in-game UID, rank tier (Pinnacle/Master), dan approval pemain trial menjadi anggota tetap.

### Modul 2: Management Scrim
- **Penjadwalan:** Tanggal, waktu (WIB), format match (BO1, BO3, BO5), nama tim lawan, logo, dan kontak manager lawan.
- **Keamanan Room Taktis:** Room ID dan password diamankan dan hanya dapat dilihat oleh pemain yang telah melakukan konfirmasi kehadiran (RSVP) menjelang match dimulai.
- **RSVP Telemetry:** Tombol satu klik bagi pemain: *Hadir / Ready*, *Tentative*, atau *Absen / Izin* (wajib mengisi alasan tertulis).
- **Lineup Readiness:** Indikator visual real-time (contoh: `5/5 Siap Tempur`, `Kurang 1 Pemain`).
- **Post-Match Ingest:** Input skor map per map, upload bukti tangkapan layar (screenshot proof), link VOD rekaman pertandingan, serta evaluasi taktis dari pelatih (Coach Review).

### Modul 3: Management Tour (Tournament)
- **Data Turnamen:** Nama kejuaraan, organizer, prize pool, tanggal pelaksanaan, dan status turnamen.
- **Bagan Turnamen (Bracket Engine):** Mendukung bagan Single Elimination (sistem gugur) dan Group Stage / Round Robin.
- **Alokasi Tim:** Menentukan skuad Luxury Elite mana yang diterjunkan ke turnamen.
- **Trophy Room / Prestasi:** Pencatatan gelar juara (Juara 1, Runner-up, Top 4) yang otomatis terintegrasi ke profil publik clan.

---

## 3. Matriks Role & Hak Akses Pengurus (RBAC)

| Peran (Role) | Hak Akses Utama |
| :--- | :--- |
| **Superadmin (Owner)** | Akses menyeluruh ke semua fitur, mutasi role pengurus, konfigurasi sistem, dan keuangan/prizepool clan. |
| **Manager** | Operasional clan, menjadwalkan scrim, pendaftaran turnamen, review rekrutmen member baru, dan kontak tim lawan. |
| **Head Coach / Pelatih** | Menentukan susunan lineup taktis, mengisi evaluasi performa pasca match, dan menganalisis statistik pemain. |
| **Squad Captain / IGL** | Memastikan kesiapan dan kehadiran pemain satu skuad, input skor darurat di lapangan bila pelatih/manager berhalangan. |
| **Player (Roster / Trial)** | Mengakses portal pemain, konfirmasi kehadiran scrim (RSVP), melihat password room match, dan membaca evaluasi coach. |

---

## 4. Standar Pengujian & Deployment

1. **Uji Sintaks PHP:** `php -l <path-to-file>` wajib dijalankan pada setiap controller, route, dan model baru.
2. **Uji Blade & Route:** `php artisan route:list` dan `php artisan view:cache` memastikan tidak ada error kompilasi template.
3. **Commit & Push:** Setiap perubahan fungsional di-commit dengan pesan deskriptif dan di-push ke remote branch `main`.
4. **Live Verification:** Memeriksa status HTTP 200 melalui server Hostinger untuk menjamin fungsionalitas di lingkungan nyata.

---

## 5. Roadmap & Prioritized Execution Phases (TODO Tasks)

Status implementasi seluruh tahapan (Phase 1 s/d Phase 5):

### 🟩 Phase 1: Database Migration & Seeding Data Nyata (Foundation Data) [COMPLETED]
- [x] **1.1 Migration Eksekusi Turnamen:** Migrasi tabel `tournaments` & `tournament_matches` siap di file `2026_10_14_000009_create_tournaments_and_matches_tables.php`.
- [x] **1.2 Seeder Skuad Resmi & Roster Awal:** `TournamentSeeder.php` dan `LuxuryEliteRosterSeeder.php` telah mengonfigurasi skuad Detonation, Hazard, dan Havoc.
- [x] **1.3 Superadmin & Staff Default Account:** `AdminUserSeeder.php` telah menyiapkan akun command staff:
  - Superadmin: `admin@luxuryelite.web.id` (Password: `luxury2026!`)
  - Manager: `manager@luxuryelite.web.id` (Password: `luxury2026!`)
  - Coach: `coach@luxuryelite.web.id` (Password: `luxury2026!`)

### 🟦 Phase 2: Roster Builder & Squad Allocation Engine (Management Player) [COMPLETED]
- [x] **2.1 Squad Member Assignment:** Form modal penugasan skuad interaktif (`/management/players/{id}/assign-squad`) dengan pemilihan slot role (`Starter`, `Substitute`, `Standin`, `Reserve`) dan nomor sub-tim.
- [x] **2.2 Trial-to-Core Promotion Workflow:** Tombol 1-klik `Angkat Core` (`/management/players/{id}/promote-trial`) otomatis menaikkan status trial menjadi competitive core.
- [x] **2.3 Player Stats & Dossier Input:** Form edit dossier terpadu untuk K/D, Rank Tier, preferred class, and Discord tag.

### 🟨 Phase 3: Scrim Telemetry, Interactive RSVP & Proof Ingest (Management Scrim) [COMPLETED]
- [x] **3.1 Live RSVP Widget Pemain:** Di halaman match publik (`/matches/{id}`), profil pemain yang login otomatis terpilih dengan pilihan komitmen `Confirmed Attending`, `Tentative`, atau `Absent`.
- [x] **3.2 Telemetri Kesiapan Lineup (Readiness Indicator):** Peringatan otomatis missing starters dan ketersediaan reserve pool.
- [x] **3.3 Timed Secret Room Reveal:** Room Password diproteksi hanya dapat dibuka oleh Pengurus & Roster yang telah RSVP `Attending`.
- [x] **3.4 Upload Screenshot Scoreboard Proof:** File upload `screenshot_file` langsung terarsip di sistem storage.

### 🟧 Phase 4: Tournament Visual Bracket Tree & Clan Trophy Showcase (Management Tour) [COMPLETED]
- [x] **4.1 Interactive Visual Bracket Tree:** Bagan turnamen dinamis dengan skor, stream link, dan status di `/management/tournaments/{id}`.
- [x] **4.2 Auto-Progression Bracket & Scoring:** Modal update skor kilat untuk menentukan tim pemenang yang lolos ke babak selanjutnya.
- [x] **4.3 Clan Hall of Fame / Trophy Room:** Halaman publik baru di rute [`/trophies`](https://luxuryelite.web.id/trophies) lengkap dengan kartu piala kejuaraan dan rekam jejak turnamen.

### 🟪 Phase 5: Otomasi & Integrasi Komunitas (Discord Webhooks) [COMPLETED]
- [x] **5.1 Discord Scrim Announcer:** Service `DiscordWebhookService::notifyScrimScheduled()` otomatis mengirim kartu embed pengumuman scrim baru ke Discord clan.
- [x] **5.2 Discord Tryout Application Alert:** `DiscordWebhookService::notifyNewRecruitment()` mengirim alert instan saat ada pendaftar baru dari form Join Squad.
- [x] **5.3 Discord Tournament Victory Broadcast:** `DiscordWebhookService::notifyTournamentVictory()` menyiarkan kemenangan match turnamen ke Discord.
