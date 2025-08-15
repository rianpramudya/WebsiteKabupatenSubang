<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request; // <-- Tambahkan ini

class TenantScope implements Scope
{
    /**
     * Terapkan scope ke query Eloquent yang diberikan.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Scope hanya berjalan jika ada pengguna yang login dan bukan dari CLI
        if (php_sapi_name() === 'cli' || !Auth::check()) {
            return;
        }

        // ======================================================================
        // PERBAIKAN LOGIKA FINAL:
        // Scope ini sekarang HANYA berlaku jika pengguna berada di dalam panel admin.
        // Ini memastikan halaman publik tidak akan pernah terfilter,
        // sesuai dengan aturan "semua admin bisa melihat semua konten publik".
        // ======================================================================
        if (!Request::is('admin/*')) {
            return;
        }

        $user = Auth::user();
        $tableName = $model->getTable();

        // 1. Logika untuk Admin spesifik (bukan Super Admin)
        if ($user->hasRole('admin-kecamatan')) {
            if (Schema::hasColumn($tableName, 'kecamatan_id') && $user->kecamatan_id) {
                $builder->where($tableName . '.kecamatan_id', $user->kecamatan_id);
            }
        } elseif ($user->hasRole('admin-perangkat-daerah')) {
            if (Schema::hasColumn($tableName, 'perangkat_daerah_id') && $user->perangkat_daerah_id) {
                $builder->where($tableName . '.perangkat_daerah_id', $user->perangkat_daerah_id);
            }
        }
        // 2. Logika untuk Super Admin yang bisa berpindah-pindah konteks
        elseif ($user->hasRole('super-admin')) {
            $hasKecamatanColumn = Schema::hasColumn($tableName, 'kecamatan_id');
            $hasPerangkatDaerahColumn = Schema::hasColumn($tableName, 'perangkat_daerah_id');

            // Prioritaskan konteks Perangkat Daerah yang aktif di sesi
            $activePerangkatDaerahId = Session::get('active_perangkat_daerah_id');
            if ($activePerangkatDaerahId !== null && $hasPerangkatDaerahColumn) {
                $builder->where($tableName . '.perangkat_daerah_id', $activePerangkatDaerahId);
                return; // Hentikan jika konteks PD ditemukan
            }

            // Jika tidak ada konteks PD, cek konteks Kecamatan yang aktif di sesi
            $activeKecamatanId = Session::get('active_kecamatan_id');
            if ($activeKecamatanId !== null && $hasKecamatanColumn) {
                $builder->where($tableName . '.kecamatan_id', $activeKecamatanId);
                return; // Hentikan jika konteks Kecamatan ditemukan
            }
        }
    }
}
