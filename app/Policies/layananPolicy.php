<?php

namespace App\Policies;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LayananPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    private function isOwner(User $user, Layanan $layanan): bool
    {
        if ($user->hasRole('admin-kecamatan') && $user->kecamatan_id == $layanan->kecamatan_id) {
            return true;
        }

        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkat_daerah_id == $layanan->perangkat_daerah_id) {
            return true;
        }

        return false;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function update(User $user, Layanan $layanan): bool
    {
        return $this->isOwner($user, $layanan);
    }

    public function delete(User $user, Layanan $layanan): bool
    {
        return $this->isOwner($user, $layanan);
    }
}
