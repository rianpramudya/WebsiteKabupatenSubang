<?php

namespace App\Policies;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AgendaPolicy
{

    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }

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

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin-kecamatan', 'admin-perangkat-daerah']);
    }

    public function update(User $user, Agenda $agenda): bool
    {
        return $this->isOwner($user, $agenda);
    }

    public function delete(User $user, Agenda $agenda): bool
    {
        return $this->isOwner($user, $agenda);
    }
}
