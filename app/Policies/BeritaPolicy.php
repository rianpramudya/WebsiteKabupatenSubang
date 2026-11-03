<?php

namespace App\Policies;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BeritaPolicy
{

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    private function isOwner(User $user, Berita $berita): bool
    {

        if ($user->hasRole('admin-kecamatan') && $user->kecamatan_id == $berita->kecamatan_id) {
            return true;
        }

        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkat_daerah_id == $berita->perangkat_daerah_id) {
            return true;
        }

        return false;
    }

    public function viewAny(User $user): bool
    {

        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function view(User $user, Berita $berita): bool
    {
        return $this->isOwner($user, $berita);
    }

    public function create(User $user): bool
    {

        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function update(User $user, Berita $berita): bool
    {
        return $this->isOwner($user, $berita);
    }

    public function delete(User $user, Berita $berita): bool
    {
        return $this->isOwner($user, $berita);
    }
}
