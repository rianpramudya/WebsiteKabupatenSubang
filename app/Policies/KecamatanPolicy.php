<?php

namespace App\Policies;

use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KecamatanPolicy
{
    use HandlesAuthorization;

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    public function manage(User $user, Kecamatan $kecamatan): bool
    {

        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($user->hasRole('admin-kecamatan')) {
            return $user->kecamatan_id === $kecamatan->id;
        }

        return false;
    }

    public function viewAny(User $user): bool
    {

        return $user->hasRole('admin-kecamatan');
    }

    public function view(User $user, Kecamatan $kecamatan): bool
    {
        return $user->kecamatan_id === $kecamatan->id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Kecamatan $kecamatan): bool
    {
        return $user->kecamatan_id === $kecamatan->id;
    }

    public function delete(User $user, Kecamatan $kecamatan): bool
    {
        return false;
    }

    public function restore(User $user, Kecamatan $kecamatan): bool
    {
        return false;
    }

    public function forceDelete(User $user, Kecamatan $kecamatan): bool
    {
        return false;
    }
}