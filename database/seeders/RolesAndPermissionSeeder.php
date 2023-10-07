<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{

    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        DB::table('users')->delete();
        $super_admin = $this->createUser('Super Admin', 'super_admin@gmail.com');
        $user = $this->createUser('user', 'user@gmail.com');
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'user']);
        $super_admin->assignRole('Super Admin');
        $user->assignRole('user');
    }

    private function createUser($name, $email)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(12345678)
        ]);
    }

}
