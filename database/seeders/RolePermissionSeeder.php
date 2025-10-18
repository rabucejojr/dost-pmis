<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Enums\UserType;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
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

            // 2️⃣ Define roles and assign permissions
            $roles = [
                'Admin' => Permission::all()->pluck('name')->toArray(),
                'User'  => ['view projects', 'create projects'],
                'Guest' => ['view projects'],
            ];

            foreach ($roles as $roleName => $rolePermissions) {
                $role = Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web',
                ]);

                $role->syncPermissions($rolePermissions);
            }

            // 3️⃣ Create default Admin user (if not exists)
            $admin = User::firstOrCreate(
                ['email' => 'admin@dost.gov.ph'],
                [
                    'name' => 'System Administrator',
                    'password' => Hash::make('password'), // change this in production
                    'user_type' => UserType::ADMIN,
                ]
            );

            // Assign Admin role if not yet assigned
            if (! $admin->hasRole('Admin')) {
                $admin->assignRole('Admin');
            }

            // 4️⃣ Optional: Output summary to console
            $this->command->info('✅ Roles, permissions, and default admin account seeded successfully!');
            $this->command->warn('👉 Admin login: admin@dost.gov.ph / password');
        });
    }
}
