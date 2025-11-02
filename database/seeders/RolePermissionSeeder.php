<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 🔄 Clear cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        DB::transaction(function () {
            // 1️⃣ Define permissions
            $permissions = [
                'view projects',
                'create projects',
                'edit projects',
                'delete projects',
                'approve projects',
                'manage users',
            ];

            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web',
                ]);
            }

            // 2️⃣ Define roles and their permissions
            $roles = [
                'Admin' => Permission::all()->pluck('name')->toArray(),
                'User' => ['view projects', 'create projects'],
                'Guest' => ['view projects'],
            ];

            foreach ($roles as $roleName => $rolePermissions) {
                $role = Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web',
                ]);

                $role->syncPermissions($rolePermissions);
            }

            // 3️⃣ Create default Admin
            $admin = User::firstOrCreate(
                ['email' => 'admin@dost.gov.ph'],
                [
                    'name' => 'System Administrator',
                    'password' => Hash::make('password'), // ⚠️ change in production
                    'user_type' => UserType::ADMIN,
                ]
            );
            $admin->assignRole('Admin');

            // 4️⃣ Create default User
            $user = User::firstOrCreate(
                ['email' => 'user@dost.gov.ph'],
                [
                    'name' => 'Regular User',
                    'password' => Hash::make('password'), // ⚠️ change in production
                    'user_type' => UserType::USER,
                ]
            );
            $user->assignRole('User');

            // 5️⃣ Create default Guest
            $guest = User::firstOrCreate(
                ['email' => 'guest@dost.gov.ph'],
                [
                    'name' => 'Guest Account',
                    'password' => Hash::make('password'), // ⚠️ change in production
                    'user_type' => UserType::GUEST,
                ]
            );
            $guest->assignRole('Guest');

            // 6️⃣ Output info to console
            $this->command->info('✅ Roles, permissions, and default users created successfully!');
            $this->command->warn('👉 Admin login: admin@dost.gov.ph / password');
            $this->command->warn('👉 User login: user@dost.gov.ph / password');
            $this->command->warn('👉 Guest login: guest@dost.gov.ph / password');
        });
    }
}
