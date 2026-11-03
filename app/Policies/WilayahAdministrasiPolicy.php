<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WilayahAdministrasi;
use Illuminate\Auth\Access\HandlesAuthorization;

class WilayahAdministrasiPolicy
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

    public function view(User $user, WilayahAdministrasi $wilayahAdministrasi): bool
    {
        return $this->update($user, $wilayahAdministrasi);
    }

    public function create(User $user): bool
    {

        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function update(User $user, WilayahAdministrasi $wilayahAdministrasi): bool
    {

        if ($user->hasRole('admin-kecamatan')) {
            return $user->kecamatan_id === $wilayahAdministrasi->kecamatan_id;
        }
        if ($user->hasRole('admin-perangkat-daerah')) {
            return $user->perangkat_daerah_id === $wilayahAdministrasi->perangkat_daerah_id;
        }
        return false;
    }

    public function delete(User $user, WilayahAdministrasi $wilayahAdministrasi): bool
    {
        return $this->update($user, $wilayahAdministrasi);
    }
}