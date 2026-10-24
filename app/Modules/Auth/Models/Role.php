<?php

namespace Modules\Auth\Models;

/**
 * Daftar role yang dikenal sistem (RBAC sederhana: satu role per user,
 * disimpan pada kolom `role` di tabel users).
 */
enum Role: string
{
    case Admin = 'admin';
    case User = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::User => 'User Biasa',
        };
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
