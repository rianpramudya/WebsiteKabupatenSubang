<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

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

        if (php_sapi_name() === 'cli' || !Auth::check()) {
            return;
        }

        if (!Request::is('admin/*')) {
            return;
        }

        $user = Auth::user();
        $tableName = $model->getTable();

        if ($user->hasRole('admin-kecamatan')) {
            if (Schema::hasColumn($tableName, 'kecamatan_id') && $user->kecamatan_id) {
                $builder->where($tableName . '.kecamatan_id', $user->kecamatan_id);
            }
        } elseif ($user->hasRole('admin-perangkat-daerah')) {
            if (Schema::hasColumn($tableName, 'perangkat_daerah_id') && $user->perangkat_daerah_id) {
                $builder->where($tableName . '.perangkat_daerah_id', $user->perangkat_daerah_id);
            }
        }

        elseif ($user->hasRole('super-admin')) {
            $hasKecamatanColumn = Schema::hasColumn($tableName, 'kecamatan_id');
            $hasPerangkatDaerahColumn = Schema::hasColumn($tableName, 'perangkat_daerah_id');

            $activePerangkatDaerahId = Session::get('active_perangkat_daerah_id');
            if ($activePerangkatDaerahId !== null && $hasPerangkatDaerahColumn) {
                $builder->where($tableName . '.perangkat_daerah_id', $activePerangkatDaerahId);
                return;
            }

            $activeKecamatanId = Session::get('active_kecamatan_id');
            if ($activeKecamatanId !== null && $hasKecamatanColumn) {
                $builder->where($tableName . '.kecamatan_id', $activeKecamatanId);
                return;
            }
        }
    }
}
