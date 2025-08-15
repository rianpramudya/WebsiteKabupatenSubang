<?php

namespace App\Policies;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AgendaPolicy
{
    /**
     * Berikan akses penuh kepada super-admin.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

    /**
     * Helper terpusat untuk mengecek kepemilikan.
     */
    private function isOwner(User $user, Agenda $agenda): bool
    {
        if ($user->hasRole('admin-kecamatan') && $user->kecamatan_id == $agenda->kecamatan_id) {
            return true;
        }

        if ($user->hasRole('admin-perangkat-daerah') && $user->perangkat_daerah_id == $agenda->perangkat_daerah_id) {
            return true;
        }

        return false;
    }

    /**
     * Tentukan apakah user bisa melihat daftar agenda.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    /**
     * Tentukan apakah user bisa membuat agenda.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    /**
     * Tentukan apakah user bisa memperbarui agenda.
     */
    public function update(User $user, Agenda $agenda): bool
    {
        return $this->isOwner($user, $agenda);
    }

    /**
     * Tentukan apakah user bisa menghapus agenda.
     */
    public function delete(User $user, Agenda $agenda): bool
    {
        return $this->isOwner($user, $agenda);
    }
}
