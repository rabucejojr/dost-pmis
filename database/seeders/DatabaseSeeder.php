<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Throwable;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Optional: visually separate output in console
        $this->command->info('Starting database seeding...');

        // List of all seeders to execute
        $seeders = [
            ProgramSeeder::class,
            ProjectSeeder::class,
            AccomplishmentSeeder::class,
            ProjectStaffSeeder::class,
            ActivitySeeder::class,
            RolePermissionSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            try {
                $this->command->info("Seeding: {$seeder}");
                $this->call($seeder);
                $this->command->info("Successfully seeded: {$seeder}\n");
            } catch (Throwable $e) {
                $this->command->error("Failed seeding: {$seeder}");
                $this->command->error('   ↳ Error: '.$e->getMessage());

                // Optional: Uncomment if you want to stop all seeding on failure
                throw $e;
            }
        }

        $this->command->info('🎉 Database seeding completed.');
    }
}
