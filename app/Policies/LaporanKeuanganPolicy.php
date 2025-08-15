<?php

namespace App\Policies;

use App\Models\LaporanKeuangan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LaporanKeuanganPolicy
{
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

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function update(User $user, LaporanKeuangan $laporanKeuangan): bool
    {
        if ($user->hasRole('admin-kecamatan')) {
            return $user->kecamatan_id === $laporanKeuangan->kecamatan_id;
        }
        if ($user->hasRole('admin-perangkat-daerah')) {
            return $user->perangkat_daerah_id === $laporanKeuangan->perangkat_daerah_id;
        }
        return false;
    }

    public function delete(User $user, LaporanKeuangan $laporanKeuangan): bool
    {
        return $this->update($user, $laporanKeuangan);
    }
}