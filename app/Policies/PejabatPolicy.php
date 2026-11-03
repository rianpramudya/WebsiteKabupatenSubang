<?php

namespace App\Policies;

use App\Models\Pejabat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PejabatPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function view(User $user, Pejabat $pejabat): bool
    {
        return $this->update($user, $pejabat);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function update(User $user, Pejabat $pejabat): bool
    {

        if ($user->hasRole('admin-kecamatan')) {
            return $user->kecamatan_id === $pejabat->kecamatan_id;
        }

        if ($user->hasRole('admin-perangkat-daerah')) {
            return $user->perangkat_daerah_id === $pejabat->perangkat_daerah_id;
        }

        return false;
    }

    public function delete(User $user, Pejabat $pejabat): bool
    {
        return $this->update($user, $pejabat);
    }
}
