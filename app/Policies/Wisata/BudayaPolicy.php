<?php

namespace App\Policies\Wisata;

use App\Models\Budaya;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudayaPolicy
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
        return $user->hasRole('admin-kecamatan');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin-kecamatan');
    }

    public function update(User $user, Budaya $budaya): bool
    {
        return $user->kecamatan_id === $budaya->kecamatan_id;
    }

    public function delete(User $user, Budaya $budaya): bool
    {
        return $user->kecamatan_id === $budaya->kecamatan_id;
    }
}
