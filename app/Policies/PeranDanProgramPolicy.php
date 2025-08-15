<?php

namespace App\Policies;

use App\Models\PeranDanProgram;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeranDanProgramPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function update(User $user, PeranDanProgram $peranProgram): bool
    {
        if ($user->hasRole('admin-kecamatan')) {
            return $user->kecamatan_id === $peranProgram->kecamatan_id;
        }
        if ($user->hasRole('admin-perangkat-daerah')) {
            return $user->perangkat_daerah_id === $peranProgram->perangkat_daerah_id;
        }
        return false;
    }

    public function delete(User $user, PeranDanProgram $peranProgram): bool
    {
        return $this->update($user, $peranProgram);
    }
}