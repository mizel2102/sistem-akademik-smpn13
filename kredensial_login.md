# 🔑 Kredensial Login Akses User - SIAKAD SMPN 13

Berikut adalah daftar akun default yang terdaftar di sistem untuk setiap peran (role):

| No | Peran (Role) | Email | Password (Bawaan) | Nama Pengguna |
| :-: | :--- | :--- | :--- | :--- |
| 1 | **Administrator (Admin)** | `admin@example.com` | `password` | Administrator |
| 2 | **Guru Mata Pelajaran** | `guru@example.com` | `password` | Guru Mata Pelajaran |
| 3 | **Guru Bimbingan Konseling (BK)** | `guru.bk@example.com` | `password` | Guru Bimbingan Konseling |
| 4 | **Siswa (Student)** | `siswa@example.com` | `password` | Siswa Contoh |

---

### 💡 Petunjuk Sinkronisasi Database (Seeding)

Jika database Anda tereset atau kosong, Anda dapat mengisi ulang data akun-akun default di atas ke database dengan menjalankan perintah berikut di terminal Anda:

```bash
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=AcademicDataSeeder
```
