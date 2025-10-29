# API Documentation - Sistem Laporan Aduan

## Base URL
```
http://your-domain.com/api
```

## Authentication
API ini menggunakan Laravel Sanctum untuk autentikasi. Setiap request yang memerlukan autentikasi harus menyertakan token Bearer di header:
```
Authorization: Bearer {your_token}
```

---

## Table of Contents
1. [Authentication Endpoints](#authentication-endpoints)
2. [Aduan Endpoints](#aduan-endpoints)
3. [Recommendation Endpoints](#recommendation-endpoints)
4. [Status Codes](#status-codes)

---

## Authentication Endpoints

### 1. Register User
**Endpoint:** `POST /register`

**Description:** Mendaftarkan user baru dengan role warga

**Request Body:**
```json
{
  "name": "Nama Lengkap",
  "email": "user@example.com",
  "password": "password123",
  "role": "warga"
}
```

**Response Success (200):**
```json
{
  "message": "User registered successfully",
  "token": "1|xxxxxxxxxxxxxxxxxxxxxx",
  "user": {
    "id": 1,
    "name": "Nama Lengkap",
    "email": "user@example.com",
    "role": "warga",
    "created_at": "2025-10-29T10:00:00.000000Z",
    "updated_at": "2025-10-29T10:00:00.000000Z"
  }
}
```

---

### 2. Login
**Endpoint:** `POST /login`

**Description:** Login user dan mendapatkan token autentikasi

**Request Body:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Response Success (200):**
```json
{
  "message": "Login berhasil",
  "user": {
    "id": 1,
    "name": "Nama Lengkap",
    "email": "user@example.com",
    "role": "warga"
  },
  "token": "2|xxxxxxxxxxxxxxxxxxxxxx"
}
```

**Response Error (401):**
```json
{
  "message": "Email atau password salah"
}
```

---

### 3. Logout
**Endpoint:** `POST /logout`

**Description:** Logout user dan menghapus token aktif

**Headers:**
```
Authorization: Bearer {token}
```

**Response Success (200):**
```json
{
  "message": "Logout success"
}
```

---

## Aduan Endpoints

### 4. Get All Aduan (RT & Admin Only)
**Endpoint:** `GET /aduan`

**Description:** Menampilkan semua aduan (hanya untuk RT dan Admin)

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters (Optional):**
- `status` (integer): Filter berdasarkan status (1=Pending, 2=Dalam Proses, 3=Selesai)

**Example Request:**
```
GET /aduan?status=1
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Daftar semua aduan",
  "data": [
    {
      "id": 1,
      "judul": "Jalan Rusak",
      "deskripsi": "Jalan di depan RT rusak parah",
      "foto": "aduan/photo.jpg",
      "foto_url": "http://your-domain.com/storage/aduan/photo.jpg",
      "tanggal": "2025-10-29",
      "status": 1,
      "status_text": "Pending",
      "user_id": 3,
      "created_at": "2025-10-29T10:00:00.000000Z",
      "updated_at": "2025-10-29T10:00:00.000000Z",
      "user": {
        "id": 3,
        "name": "Warga Test",
        "email": "warga@lapor.com"
      }
    }
  ]
}
```

**Response Error (403):**
```json
{
  "success": false,
  "message": "Akses ditolak. Hanya RT dan Admin yang bisa melihat semua laporan.",
  "your_role": "warga"
}
```

---

### 5. Create Aduan (Warga Only)
**Endpoint:** `POST /aduan`

**Description:** Membuat laporan aduan baru (hanya untuk Warga)

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Request Body (Form Data):**
```
judul: "Judul Aduan"
deskripsi: "Deskripsi lengkap aduan minimal 10 karakter"
foto: [file] (optional, max 2MB, jpg/jpeg/png)
tanggal: "2025-10-29"
```

**Response Success (201):**
```json
{
  "success": true,
  "message": "Aduan berhasil ditambahkan!",
  "data": {
    "id": 1,
    "judul": "Jalan Rusak",
    "deskripsi": "Jalan di depan RT rusak parah",
    "foto": "aduan/photo.jpg",
    "foto_url": "http://your-domain.com/storage/aduan/photo.jpg",
    "tanggal": "2025-10-29",
    "status": 1,
    "status_text": "Pending",
    "user_id": 3,
    "user": {
      "id": 3,
      "name": "Warga Test",
      "email": "warga@lapor.com"
    }
  }
}
```

**Response Error (422):**
```json
{
  "success": false,
  "errors": {
    "judul": ["The judul field is required."],
    "deskripsi": ["The deskripsi must be at least 10 characters."]
  }
}
```

---

### 6. Get Aduan by Warga (Warga Only)
**Endpoint:** `GET /warga/aduan`

**Description:** Menampilkan aduan milik warga yang login

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters (Optional):**
- `status` (integer): Filter berdasarkan status

**Response Success (200):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "judul": "Jalan Rusak",
      "deskripsi": "Jalan di depan RT rusak parah",
      "foto": "aduan/photo.jpg",
      "foto_url": "http://your-domain.com/storage/aduan/photo.jpg",
      "tanggal": "2025-10-29",
      "status": 1,
      "status_text": "Pending",
      "user_id": 3,
      "user": {
        "id": 3,
        "name": "Warga Test",
        "email": "warga@lapor.com"
      }
    }
  ]
}
```

---

### 7. Get Aduan Detail
**Endpoint:** `GET /aduan/{id}`

**Description:** Menampilkan detail aduan berdasarkan ID

**Headers:**
```
Authorization: Bearer {token}
```

**Response Success (200):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "judul": "Jalan Rusak",
    "deskripsi": "Jalan di depan RT rusak parah",
    "foto": "aduan/photo.jpg",
    "foto_url": "http://your-domain.com/storage/aduan/photo.jpg",
    "tanggal": "2025-10-29",
    "status": 1,
    "status_text": "Pending",
    "user_id": 3,
    "user": {
      "id": 3,
      "name": "Warga Test",
      "email": "warga@lapor.com"
    }
  }
}
```

**Response Error (404):**
```json
{
  "success": false,
  "message": "Aduan tidak ditemukan"
}
```

**Response Error (403):**
```json
{
  "success": false,
  "message": "Anda tidak memiliki akses ke aduan ini"
}
```

---

### 8. Update Status Aduan (Admin Only)
**Endpoint:** `PUT /aduan/{id}/status`

**Description:** Mengubah status aduan secara langsung (hanya Admin)

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "status": 2
}
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Status berhasil diperbarui!",
  "data": {
    "id": 1,
    "judul": "Jalan Rusak",
    "status": 2,
    "status_text": "Dalam Proses",
    "user": {
      "id": 3,
      "name": "Warga Test",
      "email": "warga@lapor.com"
    }
  }
}
```

---

## Recommendation Endpoints

### 9. Send Recommendation (RT Only)
**Endpoint:** `POST /aduan/{id}/recommend`

**Description:** Mengirim rekomendasi perubahan status dari RT ke Admin

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "recommended_status": 2,
  "notes": "Sudah ditinjau, perlu segera diproses"
}
```

**Response Success (201):**
```json
{
  "success": true,
  "message": "Rekomendasi berhasil dikirim ke Admin!",
  "data": {
    "id": 1,
    "aduan_id": 1,
    "rt_id": 2,
    "recommended_status": 2,
    "recommended_status_text": "Dalam Proses",
    "notes": "Sudah ditinjau, perlu segera diproses",
    "approval_status": "pending",
    "approval_status_text": "Menunggu Persetujuan",
    "approved_by": null,
    "admin_notes": null,
    "approved_at": null,
    "aduan": {
      "id": 1,
      "judul": "Jalan Rusak",
      "user": {
        "id": 3,
        "name": "Warga Test",
        "email": "warga@lapor.com"
      }
    },
    "rt": {
      "id": 2,
      "name": "RT 001",
      "email": "rt@lapor.com"
    }
  }
}
```

**Response Error (400):**
```json
{
  "success": false,
  "message": "Anda sudah mengirim rekomendasi untuk aduan ini."
}
```

---

### 10. Get Recommendations (Admin Only)
**Endpoint:** `GET /admin/recommendations`

**Description:** Melihat daftar rekomendasi (hanya Admin)

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters (Optional):**
- `status` (string): Filter berdasarkan status (pending/approved/rejected), default: pending

**Example Request:**
```
GET /admin/recommendations?status=pending
```

**Response Success (200):**
```json
{
  "success": true,
  "message": "Daftar rekomendasi: pending",
  "data": [
    {
      "id": 1,
      "aduan_id": 1,
      "rt_id": 2,
      "recommended_status": 2,
      "recommended_status_text": "Dalam Proses",
      "notes": "Sudah ditinjau, perlu segera diproses",
      "approval_status": "pending",
      "approval_status_text": "Menunggu Persetujuan",
      "approved_by": null,
      "admin_notes": null,
      "approved_at": null,
      "aduan": {
        "id": 1,
        "judul": "Jalan Rusak",
        "user": {
          "id": 3,
          "name": "Warga Test",
          "email": "warga@lapor.com"
        }
      },
      "rt": {
        "id": 2,
        "name": "RT 001",
        "email": "rt@lapor.com"
      },
      "admin": null
    }
  ]
}
```

---

### 11. Handle Recommendation (Admin Only)
**Endpoint:** `POST /admin/recommendations/{id}/handle`

**Description:** Approve atau reject rekomendasi dari RT (hanya Admin)

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "action": "approve",
  "admin_notes": "Rekomendasi disetujui, akan segera ditindaklanjuti"
}
```

**Parameters:**
- `action` (string, required): "approve" atau "reject"
- `admin_notes` (string, optional): Catatan dari admin

**Response Success (200) - Approve:**
```json
{
  "success": true,
  "message": "Rekomendasi disetujui! Status berhasil diperbarui.",
  "data": {
    "id": 1,
    "aduan_id": 1,
    "rt_id": 2,
    "recommended_status": 2,
    "recommended_status_text": "Dalam Proses",
    "notes": "Sudah ditinjau, perlu segera diproses",
    "approval_status": "approved",
    "approval_status_text": "Disetujui",
    "approved_by": 1,
    "admin_notes": "Rekomendasi disetujui, akan segera ditindaklanjuti",
    "approved_at": "2025-10-29T12:00:00.000000Z",
    "aduan": {
      "id": 1,
      "judul": "Jalan Rusak",
      "status": 2,
      "user": {
        "id": 3,
        "name": "Warga Test",
        "email": "warga@lapor.com"
      }
    },
    "rt": {
      "id": 2,
      "name": "RT 001",
      "email": "rt@lapor.com"
    },
    "admin": {
      "id": 1,
      "name": "Admin",
      "email": "admin@lapor.com"
    }
  }
}
```

**Response Success (200) - Reject:**
```json
{
  "success": true,
  "message": "Rekomendasi ditolak.",
  "data": {
    ...
    "approval_status": "rejected",
    "approval_status_text": "Ditolak",
    ...
  }
}
```

**Response Error (400):**
```json
{
  "success": false,
  "message": "Rekomendasi sudah diproses"
}
```

---

## Status Codes

| Code | Description |
|------|-------------|
| 200 | OK - Request berhasil |
| 201 | Created - Resource berhasil dibuat |
| 400 | Bad Request - Request tidak valid |
| 401 | Unauthorized - Token tidak valid atau tidak ada |
| 403 | Forbidden - Tidak memiliki akses |
| 404 | Not Found - Resource tidak ditemukan |
| 422 | Unprocessable Entity - Validasi gagal |

---

## Role-Based Access

### Warga (Citizen)
- Create aduan
- View own aduan
- View detail own aduan

### RT (Neighborhood Leader)
- View all aduan
- View aduan detail
- Send recommendation to admin

### Admin
- View all aduan
- View aduan detail
- Update aduan status directly
- View recommendations
- Approve/reject recommendations

---

## Status Reference

### Aduan Status
- `1` - Pending (Menunggu Konfirmasi)
- `2` - Dalam Proses
- `3` - Selesai

### Recommendation Approval Status
- `pending` - Menunggu Persetujuan
- `approved` - Disetujui
- `rejected` - Ditolak

---

## Test Accounts

Gunakan akun berikut untuk testing (setelah menjalankan seeder):

**Admin:**
```
Email: admin@lapor.com
Password: 123
```

**RT:**
```
Email: rt@lapor.com
Password: 123
```

**Warga:**
```
Email: warga@lapor.com
Password: 123
```

---

## Example Usage with cURL

### Login
```bash
curl -X POST http://your-domain.com/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "warga@lapor.com",
    "password": "123"
  }'
```

### Create Aduan
```bash
curl -X POST http://your-domain.com/api/aduan \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "judul=Jalan Rusak" \
  -F "deskripsi=Jalan di depan RT rusak parah" \
  -F "foto=@/path/to/photo.jpg" \
  -F "tanggal=2025-10-29"
```

### Get All Aduan (RT/Admin)
```bash
curl -X GET http://your-domain.com/api/aduan \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Notes
- Semua endpoint yang memerlukan autentikasi harus menyertakan Bearer token
- File foto maksimal 2MB dengan format jpg, jpeg, atau png
- Status aduan hanya bisa diubah oleh Admin atau melalui approval rekomendasi dari RT
- RT hanya bisa mengirim satu rekomendasi pending per aduan
