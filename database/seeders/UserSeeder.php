<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kecamatan;
use App\Models\PerangkatDaerah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@subang.go.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('superadmin123'),
                'kecamatan_id' => null,
                'perangkat_daerah_id' => null,
            ]
        );
        $superAdmin->assignRole('super-admin');

        // 2. Admin Kecamatan
        $this->command->info('Membuat user untuk Admin Kecamatan...');
        $kecamatans = Kecamatan::where('slug', '!=', 'kabupaten-subang')->get();

        foreach ($kecamatans as $kecamatan) {
            $adminKecamatan = User::updateOrCreate(
                ['email' => "admin-{$kecamatan->slug}@subang.go.id"],
                [
                    'name' => "Admin Kecamatan {$kecamatan->name}",
                    'password' => Hash::make('admin1234'),
                    'kecamatan_id' => $kecamatan->id,
                    'perangkat_daerah_id' => null,
                ]
            );
            $adminKecamatan->assignRole('admin-kecamatan');
        }
        $this->command->info('User Admin Kecamatan selesai dibuat.');

        // 3. Admin Perangkat Daerah
        $this->command->info('Membuat user untuk Admin Perangkat Daerah...');
        $perangkatDaerahs = PerangkatDaerah::all();

        foreach ($perangkatDaerahs as $pd) {
            $adminPd = User::updateOrCreate(
                ['email' => "admin-{$pd->slug}@subang.go.id"],
                [
                    'name' => "Admin {$pd->name}",
                    'password' => Hash::make('admin1234'),
                    'kecamatan_id' => null,
                    'perangkat_daerah_id' => $pd->id,
                ]
            );
            $adminPd->assignRole('admin-perangkat-daerah');
        }
        $this->command->info('User Admin Perangkat Daerah selesai dibuat.');
    }
}