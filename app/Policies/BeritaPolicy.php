<?php

namespace App\Policies;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BeritaPolicy
{
    /**
     * Memberikan akses penuh kepada super-admin sebelum pengecekan lainnya.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null; // Penting untuk mengembalikan null agar policy lain dijalankan
    }

    /**
     * Helper privat untuk mengecek kepemilikan berita.
     * Ini menyatukan logika untuk view, update, dan delete.
     */
    private function isOwner(User $user, Berita $berita): bool
    {
        // Cek jika user adalah admin kecamatan dan ID-nya cocok
        if ($user->hasRole('admin-kecamatan') && $user->kecamatan_id == $berita->kecamatan_id) {
            return true;
        }

        // Cek jika user adalah admin perangkat daerah dan ID-nya cocok
        // Menggunakan '==' untuk keamanan terhadap tipe data (string vs integer)
        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkat_daerah_id == $berita->perangkat_daerah_id) {
            return true;
        }

        // Jika tidak ada kondisi yang cocok, tolak akses
        return false;
    }

    /**
     * Tentukan apakah user bisa melihat daftar berita di panel admin.
     */
    public function viewAny(User $user): bool
    {
        // Izinkan jika user adalah admin kecamatan ATAU admin perangkat daerah.
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    /**
     * Tentukan apakah user bisa melihat detail berita.
     */
    public function view(User $user, Berita $berita): bool
    {
        return $this->isOwner($user, $berita);
    }

    /**
     * Tentukan apakah user bisa membuat berita.
     */
    public function create(User $user): bool
    {
        // Izinkan jika user adalah admin kecamatan ATAU admin perangkat daerah.
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    /**
     * Tentukan apakah user bisa memperbarui berita.
     */
    public function update(User $user, Berita $berita): bool
    {
        return $this->isOwner($user, $berita);
    }

    /**
     * Tentukan apakah user bisa menghapus berita.
     */
    public function delete(User $user, Berita $berita): bool
    {
        return $this->isOwner($user, $berita);
    }
}
