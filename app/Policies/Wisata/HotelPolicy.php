<?php

namespace App\Policies\Wisata;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HotelPolicy
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

    public function update(User $user, Hotel $hotel): bool
    {
        return $user->kecamatan_id === $hotel->kecamatan_id;
    }

    public function delete(User $user, Hotel $hotel): bool
    {
        return $user->kecamatan_id === $hotel->kecamatan_id;
    }
}
