<?php

namespace App\Policies;

use App\Models\Pejabat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PejabatPolicy
{
    use HandlesAuthorization;

    /**
     * Memberikan akses penuh ("Kunci Emas") kepada super-admin.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    /**
     * Izinkan jika user adalah admin kecamatan ATAU admin perangkat daerah.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    /**
     * Izinkan melihat detail jika user bisa meng-update.
     */
    public function view(User $user, Pejabat $pejabat): bool
    {
        return $this->update($user, $pejabat);
    }

    /**
     * Izinkan membuat jika user adalah admin kecamatan ATAU admin perangkat daerah.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    /**
     * Aturan utama: Tentukan apakah user bisa memperbarui data pejabat.
     */
    public function update(User $user, Pejabat $pejabat): bool
    {
        // Jika user adalah admin kecamatan, cek kepemilikan via kecamatan_id.
        if ($user->hasRole('admin-kecamatan')) {
            return $user->kecamatan_id === $pejabat->kecamatan_id;
        }

        // Jika user adalah admin perangkat daerah, cek kepemilikan via perangkat_daerah_id.
        if ($user->hasRole('admin-perangkat-daerah')) {
            return $user->perangkat_daerah_id === $pejabat->perangkat_daerah_id;
        }

        // Tolak untuk peran lainnya.
        return false;
    }

    /**
     * Aturan hapus sama dengan aturan update.
     */
    public function delete(User $user, Pejabat $pejabat): bool
    {
        return $this->update($user, $pejabat);
    }
}
