<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have programs before seeding projects
        $programs = Program::all();

        if ($programs->isEmpty()) {
            $this->command->warn('No programs found. Please seed Programs first.');
            return;
        }

        foreach ($programs as $program) {
            // Create 3 projects per program
            for ($i = 1; $i <= 3; $i++) {
                Project::create([
                    'program_id' => $program->id,
                    'title' => "{$program->name} Project {$i}",
                    'description' => "This is a sample description for {$program->name} Project {$i}.",
                    'location' => fake()->city(),
                    'status' => fake()->randomElement([
                        'ongoing',
                        'completed',
                        'terminated',
                        'continuing',
                        'graduated',
                        'grace_period',
                        'liquidated',
                        'unliquidated'
                    ]),
                    'budget' => fake()->randomFloat(2, 100000, 5000000),
                    'start_date' => fake()->dateTimeBetween('-2 years', 'now'),
                    'end_date' => fake()->dateTimeBetween('now', '+1 year'),
                    'project_leader' => fake()->name(),
                    'contact_email' => fake()->safeEmail(),
                ]);
            }

            $this->command->info("Seeded 3 projects for Program: {$program->name}");
        }
    }
}
