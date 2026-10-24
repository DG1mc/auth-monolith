# Auth Monolith — Autentikasi & RBAC (Laravel 13, Modular Monolith)

Praktikum Backend Development (DT199) — Pertemuan 4: Autentikasi & Authorization (Monolith).

Fitur: register, login, logout (session-based, Laravel Breeze + Blade), RBAC dua role (`admin`, `user`),
middleware `role`, serta nilai plus: manajemen user oleh admin dan update profil sendiri.

## Menjalankan

```bash
composer install
npm install && npm run build      # atau: npm run dev
cp .env.example .env && php artisan key:generate   # lewati jika .env sudah ada
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

Akun demo (dari `AdminUserSeeder`):

| Role  | Email             | Password    |
|-------|-------------------|-------------|
| admin | admin@example.com | password123 |
| user  | user@example.com  | password123 |

## Struktur Modul Auth

```
app/Modules/Auth/
├── Controllers/
│   ├── AuthController.php            # register, login, logout
│   ├── AdminDashboardController.php  # dashboard admin
│   └── UserManagementController.php  # (plus) list/ubah role/hapus user
├── Middleware/RoleMiddleware.php     # alias: role:admin
├── Models/Role.php                   # enum role: admin | user
├── Providers/AuthServiceProvider.php # memuat routes modul (grup 'web')
├── Requests/
│   ├── LoginRequest.php
│   └── RegisterRequest.php
└── routes/web.php
```

Namespace `Modules\` dipetakan ke `app/Modules/` pada `composer.json` (PSR-4).
Provider didaftarkan di `bootstrap/providers.php`, alias middleware di `bootstrap/app.php`.

## Route Penting

| Method | URI                       | Middleware        | Nama                |
|--------|---------------------------|-------------------|---------------------|
| GET/POST | /register, /login       | guest             | register, login     |
| POST   | /logout                   | auth              | logout              |
| GET    | /dashboard                | auth              | dashboard (redirect sesuai role) |
| GET    | /user/dashboard           | auth              | user.dashboard      |
| GET    | /admin/dashboard          | auth, role:admin  | admin.dashboard     |
| GET    | /admin/users              | auth, role:admin  | admin.users.index   |
| PATCH  | /admin/users/{user}/role  | auth, role:admin  | admin.users.role    |
| DELETE | /admin/users/{user}       | auth, role:admin  | admin.users.destroy |
| GET/PATCH/DELETE | /profile        | auth              | profile.*           |

## Pengujian

```bash
php artisan test
```

## Commit ke GitHub

```bash
git add .
git commit -m "feat: implementasi autentikasi dan RBAC dengan pendekatan Modular Monolith"
git push origin main
```
