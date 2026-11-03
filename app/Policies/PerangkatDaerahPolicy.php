<?php

namespace App\Policies;

use App\Models\PerangkatDaerah;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerangkatDaerahPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    public function manage(User $user, PerangkatDaerah $perangkatDaerah): bool
    {

        if ($user->hasRole('admin-perangkat-daerah')) {

            return $user->perangkat_daerah_id === $perangkatDaerah->id;
        }

        return false;
    }

    public function viewAny(User $user): bool
    {

        return $user->hasAnyRole(['admin-perangkat-daerah', 'admin-kecamatan']);
    }

    public function view(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return $this->manage($user, $perangkatDaerah);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return $this->manage($user, $perangkatDaerah);
    }

    public function delete(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return false;
    }

    public function restore(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return false;
    }

    public function forceDelete(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return false;
    }
}
