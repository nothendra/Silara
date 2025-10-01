# 📌 Git Guidelines

Dokumen ini berisi aturan standar penggunaan Git untuk project ACP agar kolaborasi tetap rapi, konsisten, dan mudah dikelola lintas batch.

---

## 🌳 Branching Strategy

- **Protected Branches:**
    - `main` → branch stabil, hanya untuk release.
    - `dev` → branch pengembangan utama, gabungan semua fitur sebelum masuk ke `main`.

- **Tim & Member:**
    - Setiap **tim** membuat branch berdasarkan challenge yang dikerjakan.
        - Format: `challenge/<nama-challenge>`
        - Contoh: `challenge/pengajuan-surat`
    - Setiap **member** dalam tim membuat branch per fitur.
        - Format: `feature/<nama-fitur>`
        - Contoh: `feature/form-pengajuan`, `feature/notifikasi-status`

---

## ✍️ Commit Guidelines

Gunakan format commit message berikut:
**Type** yang digunakan:
- `feat` → fitur baru
- `fix` → perbaikan bug
- `docs` → perubahan dokumentasi
- `style` → perubahan non-code (indentasi, format, dll.)
- `refactor` → perubahan code tanpa mengubah fungsionalitas
- `test` → menambah/perbaikan testing

**Contoh commit:**
- `feat: tambah form pengajuan surat`
- `fix: perbaikan validasi input NIK`
- `docs: update README untuk setup database`
---

## 🔄 Pull Request (PR) Guidelines

- PR hanya boleh dibuat ke:
    - `feature/*` → merge ke branch `challenge/*` tim.
    - `challenge/*` → merge ke `dev` (setelah review mentor).
    - `dev` → merge ke `main` (hanya mentor/panitia).

**Aturan PR:**
- Minimal 1 reviewer (tim leader / mentor).
- Jelaskan perubahan dengan jelas di deskripsi PR.
- Pastikan sudah **merge/rebase dengan branch terbaru** sebelum membuat PR.
- Jangan langsung push ke `dev` atau `main`.

**Contoh judul PR:**
- `[feat] Tambah fitur form pengajuan surat`
- `[fix] Perbaikan validasi NIK pada backend`

---

## ✅ Workflow Summary

1. Buat branch dari `challenge/*` sesuai fitur → `feature/*`.
2. Commit perubahan dengan format yang benar.
3. Push branch → buat PR ke `challenge/*`.
4. Setelah diverifikasi tim leader, merge ke `challenge/*`.
5. Mentor review dan merge `challenge/*` → `dev`.
6. Setelah akhir sprint, `dev` → `main` (oleh mentor/panitia).

---

## ⚠️ Catatan

- Jangan commit file sensitif (contoh: `.env`, API keys).
- Gunakan `.gitignore` untuk file lokal.
- Selalu `pull` branch terbaru sebelum mulai kerja.

---