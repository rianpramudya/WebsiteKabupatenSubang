<?php

namespace App\Policies;

use App\Models\PerangkatDaerah;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerangkatDaerahPolicy
{
    use HandlesAuthorization;

    /**
     * Memberikan akses penuh kepada super-admin sebelum pengecekan lainnya.
     * Ini adalah cara yang bersih untuk memastikan super-admin bisa melakukan apa saja.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null; // Lanjutkan ke pengecekan method policy lainnya jika bukan super-admin
    }

    /**
     * Tentukan apakah pengguna bisa mengelola data untuk sebuah perangkat daerah.
     * Ini akan digunakan oleh middleware otorisasi untuk Perangkat Daerah.
     */
    public function manage(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        // Jika pengguna adalah admin perangkat daerah, periksa apakah ID-nya cocok.
        if ($user->hasRole('admin-perangkat-daerah')) {
            // Pastikan model User Anda memiliki kolom 'perangkat_daerah_id'.
            return $user->perangkat_daerah_id === $perangkatDaerah->id;
        }

        // Jika bukan, tolak. (Super-admin sudah ditangani oleh method before()).
        return false;
    }

    /**
     * Tentukan apakah pengguna bisa melihat daftar perangkat daerah.
     */
    public function viewAny(User $user): bool
    {
        // Semua jenis admin boleh melihat daftar perangkat daerah.
        return $user->hasAnyRole(['admin-perangkat-daerah', 'admin-kecamatan']);
    }

    /**
     * Tentukan apakah pengguna bisa melihat detail perangkat daerah.
     * Ini juga digunakan oleh @can('view', $perangkatDaerah)
     */
    public function view(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return $this->manage($user, $perangkatDaerah);
    }

    /**
     * Tentukan apakah pengguna bisa membuat perangkat daerah baru.
     * Hanya super-admin yang bisa (ditangani oleh method before()).
     */
    public function create(User $user): bool
    {
        return false; // Admin biasa tidak boleh membuat.
    }

    /**
     * Tentukan apakah pengguna bisa memperbarui perangkat daerah.
     * Ini digunakan oleh @can('update', $perangkatDaerah) di view Anda.
     */
    public function update(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return $this->manage($user, $perangkatDaerah);
    }

    /**
     * Tentukan apakah pengguna bisa menghapus perangkat daerah.
     * Hanya super-admin yang bisa (ditangani oleh method before()).
     */
    public function delete(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return false;
    }

    /**
     * Tentukan apakah pengguna bisa merestore perangkat daerah yang dihapus.
     */
    public function restore(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return false;
    }

    /**
     * Tentukan apakah pengguna bisa menghapus permanen perangkat daerah.
     */
    public function forceDelete(User $user, PerangkatDaerah $perangkatDaerah): bool
    {
        return false;
    }
}
