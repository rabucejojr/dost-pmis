<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Accomplishment;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class AccomplishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(array $params = []): void
    {
        // ✅ Accept parameter from PerspectiveSeeder
        $project = $params['project'] ?? null;

        if ($project) {
            $this->seedForProject($project);
            return;
        }

        // ✅ Fallback: run for all projects if called standalone
        $projects = Project::all();

        if ($projects->isEmpty()) {
            $this->command?->warn('⚠️ No projects found — please seed Projects first.');
            return;
        }

        foreach ($projects as $project) {
            $this->seedForProject($project);
        }

        $this->command?->info('✅ All accomplishments seeded for all projects.');
    }

    /**
     * Seed accomplishments for a specific project.
     */
    protected function seedForProject(Project $project): void
    {
        $this->command?->info("💰 Seeding accomplishments for Project: {$project->title}");

        // Create a small random number of accomplishments per project
        $count = rand(1, 3);

        foreach (range(1, $count) as $i) {
            Accomplishment::create([
                'project_id'        => $project->id,
                'project_title'     => $project->title,
                'implementing_year' => Carbon::parse($project->start_date)->year,
                'budget_utilized' => round($project->budget * fake()->randomFloat(2, 0.3, 0.9), 2),
                'status'            => $project->status,
            ]);
        }

        $this->command?->info("✅ {$count} accomplishments seeded for {$project->title}");
    }
}
