<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'role_name' => 'veterinarian',
            'read_access' => true,
            'change_access' => true,
        ]);
        UserRole::create([
            'role_name' => 'animal shelter veterinarian',
            'read_access' => true,
            'change_access' => true,
        ]);
        UserRole::create([
            'role_name' => 'animal shelter operator',
            'read_access' => true,
            'change_access' => true,
        ]);
        UserRole::create([
            'role_name' => 'veterinary service curator',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'LSGB curator',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'catching curator',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'animal shelter curator',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'veterinary service curator',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create( [
            'role_name' => 'LSGB operator',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'catching operator',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'veterinary service signer',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'LSGB signer',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'catching signer',
            'read_access' => true,
            'change_access' => false,
        ]);
        UserRole::create([
            'role_name' => 'veterinary service signer',
            'read_access' => true,
            'change_access' => false,
        ]);

    }
}
