<?php

namespace App\Policies\Wisata;

use App\Models\Budaya;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudayaPolicy
{
    use HandlesAuthorization;

    /**
     * Memberikan akses penuh kepada super-admin sebelum pengecekan lainnya.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    /**
     * Otorisasi untuk 'viewAny' ditangani oleh middleware dan ->scoped().
     * Namun, jika dipanggil, pastikan hanya admin kecamatan yang bisa.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin-kecamatan');
    }

    /**
     * Tentukan apakah user bisa membuat data budaya baru.
     * Middleware sudah memastikan user berada di kecamatan yang benar.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin-kecamatan');
    }

    /**
     * Tentukan apakah user bisa memperbarui data budaya yang ada.
     */
    public function update(User $user, Budaya $budaya): bool
    {
        return $user->kecamatan_id === $budaya->kecamatan_id;
    }

    /**
     * Tentukan apakah user bisa menghapus data budaya yang ada.
     */
    public function delete(User $user, Budaya $budaya): bool
    {
        return $user->kecamatan_id === $budaya->kecamatan_id;
    }
}
