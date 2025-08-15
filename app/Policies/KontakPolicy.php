<?php

namespace App\Policies;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class KontakPolicy
{
    /**
     * Memberikan akses penuh kepada super-admin.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    /**
     * Tentukan apakah user bisa memperbarui data kontak tenant.
     */
    public function update(User $user, Model $tenant): bool
    {
        if ($tenant instanceof Kecamatan) {
            return $user->kecamatan_id === $tenant->id;
        }

        if ($tenant instanceof PerangkatDaerah) {
            return $user->perangkat_daerah_id === $tenant->id;
        }

        return false;
    }
}