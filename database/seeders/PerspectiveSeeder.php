<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perspective;

class PerspectiveSeeder extends Seeder
{
    public function run(array $params = []): void
    {
        $project = $params['project'] ?? null;

        if (!$project) {
            // Warn only when run directly (not part of chained call)
            if (app()->runningInConsole()) {
                $this->command?->warn('⚠️ PerspectiveSeeder skipped — no project passed.');
            }
            return;
        }

        $year = $project->implementing_year;
        $perspectives = [
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Customer Perspective',
                'description' => 'Measures how well the organization delivers value and satisfaction to its customers.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Internal Process Perspective',
                'description' => 'Focuses on improving key operational processes that drive performance and quality.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Learning and Growth Perspective',
                'description' => 'Enhances employee skills, innovation, and organizational capacity for continuous improvement.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Financial Perspective',
                'description' => 'Evaluates financial performance and resource management to ensure sustainability and growth.',
            ],
        ];

        foreach ($perspectives as $index => $data) {
            $perspective = Perspective::create($data);
            $this->command?->info("Perspective Created: {$perspective->name}");

            // Propagate chain
            app(ObjectiveSeeder::class)
                ->setContainer(app())
                ->setCommand($this->command)
                ->run([
                    'perspective' => $perspective,
                    'perspective_index' => $index + 1,
                ]);
        }

        $this->command?->info("4 perspectives seeded for Project: {$project->project_title}");
        // ✅ Integrate AccomplishmentSeeder per project
        app(AccomplishmentSeeder::class)
            ->setContainer(app())
            ->setCommand($this->command)
            ->run([
                'project' => $project, // Pass the project to link accomplishments
            ]);
        $this->command?->info("Financial accomplishments seeded for Project: {$project->project_title}");
    }
}
