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
   - Seed data awal untuk mode game Delta Force (Detonation, Hazard Operations, Havoc Warfare).
4. **Resilience & Production Verification:**
   - Seluruh query publik dibungkus penanganan fallback database (`try-catch`) agar website tetap berjalan 100% stabil saat database maintenance.
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
