<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Project;
use function fake;
class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $programs = Program::all();

        if ($programs->isEmpty()) {
            $this->command?->warn('⚠️ No programs found. Please seed Programs first.');
            return;
        }

        foreach ($programs as $program) {
            $this->command?->info("🚀 Seeding projects for Program: {$program->name}");

            for ($i = 1; $i <= 3; $i++) {
                $year = now()->year + ($i - 1);

                $project = Project::create([
                    'program_id'        => $program->id,
                    'title'             => "{$program->name} Project {$i}",
                    'description'       => "Demo description for {$program->name} Project {$i}.",
                    'location'          => fake()->city(),
                    'status'            => fake()->randomElement([
                        'ongoing', 'completed', 'terminated',
                        'continuing', 'graduated', 'grace_period',
                        'liquidated', 'unliquidated',
                    ]),
                    'budget'            => fake()->randomFloat(2, 100000, 5000000),
                    'start_date'        => fake()->dateTimeBetween('-2 years', 'now'),
                    'end_date'          => fake()->dateTimeBetween('now', '+1 year'),
                    'project_leader'    => fake()->name(),
                    'contact_email'     => fake()->safeEmail(),
                    'implementing_year' => $year,
                ]);

                // ✅ Call PerspectiveSeeder for this project (triggers hierarchy)
                app(PerspectiveSeeder::class)
                    ->setContainer(app())
                    ->setCommand($this->command)
                    ->run(['project' => $project]);

                $this->command?->info("🌱 Project seeded: {$project->title}");
            }

            $this->command?->info("🎯 3 projects seeded for Program: {$program->name}");
        }

        $this->command?->info('✅ All programs processed successfully.');
    }
}
