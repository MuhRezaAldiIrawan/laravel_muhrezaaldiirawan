# Laravel 10 - CRUD Pasien dengan Filter Rumah Sakit (AJAX + Bootstrap)

## 📌 Deskripsi
Aplikasi ini dibangun menggunakan **Laravel 10**, **AJAX**, dan **Bootstrap 5**.  
Fitur utama:
- Login menggunakan **username** (bukan email).
- CRUD data **Pasien** dengan relasi ke **Rumah Sakit**.
- Filter pasien berdasarkan **Rumah Sakit** menggunakan AJAX.

---

## 🛠️ Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/MuhRezaAldiIrawan/laravel_muhrezaaldiirawan.git
cd laravel_muhrezaaldiirawan
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run dev
```

### 3. Setup Environment
Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Edit konfigurasi database pada `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teramedik-hospital
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key
```bash
php artisan key:generate
```

---

## 🗄️ Database

### 1. Migration
Jalankan migration untuk membuat tabel:
```bash
php artisan migrate
atau 
php artisan migrate:fresh --seed

```

---

## 🔑 Autentikasi

Menggunakan **Laravel Breeze** (sudah mendukung login & register).  
Pastikan saat register, user mengisi **username**.  
Edit model `User.php` agar login menggunakan **username**.


---

## 👨‍⚕️ CRUD Pasien

### Routes (`routes/web.php`)
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/list', [PatientController::class, 'list']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::put('/patients/{id}', [PatientController::class, 'update']);
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
});
```

### Controller (`app/Http/Controllers/PatientController.php`)
Berisi fungsi `index`, `list`, `store`, `update`, dan `destroy` sesuai dengan AJAX.

### View (`resources/views/patients/index.blade.php`)
Menggunakan **Bootstrap 5** + **AJAX**.  
Terdapat modal form untuk Tambah/Edit Pasien dan dropdown filter Rumah Sakit.

---

## ▶️ Menjalankan Aplikasi
```bash
php artisan serve
```
Akses di browser:  
👉 `http://127.0.0.1:8000`

Login dengan user yang sudah dibuat.  

Username: admin
Password: password

Lalu buka menu **Patients** untuk melihat CRUD dengan filter Rumah Sakit.

---

---

## ✅ Selesai
Aplikasi **CRUD Pasien** dengan filter Rumah Sakit berbasis **Laravel 10, AJAX, dan Bootstrap** siap digunakan!
