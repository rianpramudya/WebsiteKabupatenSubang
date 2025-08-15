<?php

namespace App\Policies;

use App\Models\Penghargaan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenghargaanPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }

    private function isOwner(User $user, Penghargaan $penghargaan): bool
    {
        if ($user->hasRole('admin-kecamatan') && $user->kecamatan_id == $penghargaan->kecamatan_id) {
            return true;
        }
        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkat_daerah_id == $penghargaan->perangkat_daerah_id) {
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

    public function update(User $user, Penghargaan $penghargaan): bool
    {
        return $this->isOwner($user, $penghargaan);
    }

    public function delete(User $user, Penghargaan $penghargaan): bool
    {
        return $this->isOwner($user, $penghargaan);
    }
}
