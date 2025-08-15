<?php

namespace App\Policies;

use App\Models\Galeri;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GaleriPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    private function isOwner(User $user, Galeri $galeri): bool
    {
        if ($user->hasRole('admin-kecamatan') && $user->kecamatan_id == $galeri->kecamatan_id) {
            return true;
        }

        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkat_daerah_id == $galeri->perangkat_daerah_id) {
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

    public function update(User $user, Galeri $galeri): bool
    {
        // Meskipun tidak ada halaman edit, policy ini baik untuk konsistensi
        return $this->isOwner($user, $galeri);
    }

    public function delete(User $user, Galeri $galeri): bool
    {
        return $this->isOwner($user, $galeri);
    }
}
