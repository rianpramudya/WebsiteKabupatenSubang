<?php

namespace App\Policies;

use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use App\Models\Sejarah;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SejarahPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
    }

    private function isOwner(User $user, Sejarah $sejarah): bool
    {
        if ($user->hasRole('admin-kecamatan') && $user->kecamatan_id == $sejarah->kecamatan_id) {
            return true;
        }
        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkat_daerah_id == $sejarah->perangkat_daerah_id) {
            return true;
        }
        return false;
    }

    public function viewAny(User $user, $tenant): bool
    {
        if ($tenant instanceof Kecamatan) {
            return $user->kecamatan_id === $tenant->id;
        }
        if ($tenant instanceof PerangkatDaerah) {
            return $user->perangkat_daerah_id === $tenant->id;
        }
        return false;
    }

    public function create(User $user, $tenant): bool
    {
        return $this->viewAny($user, $tenant);
    }

    public function update(User $user, Sejarah $sejarah): bool
    {
        return $this->isOwner($user, $sejarah);
    }

    public function delete(User $user, Sejarah $sejarah): bool
    {
        return $this->isOwner($user, $sejarah);
    }
}
