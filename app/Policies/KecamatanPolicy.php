<?php

namespace App\Policies;

use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KecamatanPolicy
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
     * Tentukan apakah user bisa mengelola data untuk sebuah kecamatan.
     * Ini akan dipanggil oleh middleware auth.kecamatan.
     * HANYA SATU METODE MANAGE INI YANG DIPERLUKAN.
     */
    public function manage(User $user, Kecamatan $kecamatan): bool
    {
        // Kondisi untuk super-admin sudah ditangani oleh metode before(),
        // namun menambahkannya di sini juga aman sebagai pertahanan berlapis.
        if ($user->hasRole('super-admin')) {
            return true;
        }

        // Jika user adalah admin kecamatan, periksa apakah ID kecamatannya cocok.
        if ($user->hasRole('admin-kecamatan')) {
            return $user->kecamatan_id === $kecamatan->id;
        }

        // Jika bukan keduanya, tolak.
        return false;
    }

    /**
     * Tentukan apakah user bisa melihat daftar kecamatan di panel admin.
     */
    public function viewAny(User $user): bool
    {
        // Mengizinkan admin kecamatan melihat daftar tidak masalah,
        // karena mereka hanya bisa mengelola kecamatannya sendiri.
        return $user->hasRole('admin-kecamatan');
    }

    /**
     * Tentukan apakah user bisa melihat detail admin kecamatan tertentu.
     */
    public function view(User $user, Kecamatan $kecamatan): bool
    {
        return $user->kecamatan_id === $kecamatan->id;
    }

    /**
     * Tentukan apakah user bisa membuat kecamatan baru.
     * Hanya super-admin yang bisa, ditangani oleh method before().
     */
    public function create(User $user): bool
    {
        return false; // Admin kecamatan tidak boleh membuat kecamatan baru.
    }

    /**
     * Tentukan apakah user bisa memperbarui kecamatan.
     */
    public function update(User $user, Kecamatan $kecamatan): bool
    {
        return $user->kecamatan_id === $kecamatan->id;
    }

    /**
     * Tentukan apakah user bisa menghapus kecamatan.
     * Hanya super-admin yang bisa, ditangani oleh method before().
     */
    public function delete(User $user, Kecamatan $kecamatan): bool
    {
        return false;
    }

    /**
     * Tentukan apakah user bisa memulihkan kecamatan yang dihapus.
     */
    public function restore(User $user, Kecamatan $kecamatan): bool
    {
        return false;
    }

    /**
     * Tentukan apakah user bisa menghapus kecamatan secara permanen.
     */
    public function forceDelete(User $user, Kecamatan $kecamatan): bool
    {
        return false;
    }
}