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

Daftar urutan pengerjaan bertahap (Phase by Phase) untuk menyempurnakan platform management:

### 🟩 Phase 1: Database Migration & Seeding Data Nyata (Foundation Data)
- [ ] **1.1 Migration Eksekusi Turnamen:** Jalankan migrasi tabel `tournaments` & `tournament_matches` di database produksi/remote.
- [ ] **1.2 Seeder Skuad Resmi & Roster Awal:** Seed data skuad resmi (`Luxury Elite Alpha`, `Luxury Elite Bravo`, `Luxury Elite Havoc Division`) dan data pemain inti clan.
- [ ] **1.3 Superadmin & Staff Default Account:** Memastikan kredensial akun Superadmin (Owner) dan Manager siap digunakan untuk live testing autentikasi manajemen.

### 🟦 Phase 2: Roster Builder & Squad Allocation Engine (Management Player)
- [ ] **2.1 Squad Member Assignment:** Form interaktif di Player Management untuk menugaskan pemain ke skuad tertentu beserta slot role (`IGL`, `Starter 1-4`, `Sub/Cadangan`).
- [ ] **2.2 Trial-to-Core Promotion Workflow:** Tombol 1-klik untuk menaikkan pemain berstatus `Trial` menjadi `Competitive Core` resmi clan dengan tanggal bergabung tercatat otomatis.
- [ ] **2.3 Player Stats Input:** Fitur input/update K/D ratio, Winrate (%), total jam terbang scrim, dan lencana MVP per pemain.

### 🟨 Phase 3: Scrim Telemetry, Interactive RSVP & Proof Ingest (Management Scrim)
- [ ] **3.1 Live RSVP Widget Pemain:** Di dashboard pemain & halaman match publik, pemain bisa klik 1-tombol: `Hadir / Ready`, `Tentative`, atau `Izin` (dengan modal input alasan wajib).
- [ ] **3.2 Telemetri Kesiapan Lineup (Readiness Indicator):** Badge dinamis penanda kesiapan skuad (misal: `5/5 Full Ready Tempur` atau `Kurang 1 Orang (Need Sub)`).
- [ ] **3.3 Timed Secret Room Reveal:** Room ID & Password hanya otomatis terlihat 15-30 menit sebelum match dimulai khusus bagi pemain yang berstatus RSVP `Attending`.
- [ ] **3.4 Upload Screenshot Scoreboard Proof:** File uploader untuk bukti screenshot scoreboard hasil akhir scrim yang langsung tampil di match report.

### 🟧 Phase 4: Tournament Visual Bracket Tree & Clan Trophy Showcase (Management Tour)
- [ ] **4.1 Interactive Visual Bracket Tree:** Tampilan bagan pohon visual untuk Single Elimination (Quarterfinal &rarr; Semifinal &rarr; Grand Final) dengan garis konektor taktis.
- [ ] **4.2 Auto-Progression Bracket:** Saat match babak perempat final ditandai "Won", tim pemenang otomatis maju dan mengisi slot di babak semifinal.
- [ ] **4.3 Clan Hall of Fame / Trophy Room:** Halaman publik showcase prestasi (`/trophies` atau section di beranda) yang menampilkan piala juara 1, runner-up, dan total perolehan prizepool clan.

### 🟪 Phase 5: Otomasi & Integrasi Komunitas (Discord Webhooks)
- [ ] **5.1 Discord Scrim Announcer:** Webhook otomatis mengirim pemberitahuan jadwal scrim baru ke channel `#scrim-announcement` Discord clan.
- [ ] **5.2 Discord Tryout Application Alert:** Webhook otomatis mengirim ringkasan profil saat ada pendaftar baru dari form Join Squad ke channel `#recruitment-logs`.
