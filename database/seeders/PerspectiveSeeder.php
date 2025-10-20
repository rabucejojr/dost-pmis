<?php

namespace Database\Seeders;

use App\Models\Perspective;
use Illuminate\Database\Seeder;
use Database\Seeders\ObjectiveSeeder;

class PerspectiveSeeder extends Seeder
{
    public function run($params = []): void
    {
        $project = $params['project'] ?? null;
        if (!$project) {
            $this->command->warn('⚠️ No project passed to PerspectiveSeeder.');
            return;
        }

        $year = $project->implementing_year;

        $perspectives = [
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Sustainable Development and Inclusive Growth',
                'description' => 'Focuses on sustainability, environment, and community empowerment.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Science, Technology, and Innovation Advancement',
                'description' => 'Promotes applied research, technology transfer, and innovation.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Digital Transformation and Smart Communities',
                'description' => 'Supports e-governance and local digital transformation.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Human Resource Development and Institutional Capacity',
                'description' => 'Builds workforce and institutional excellence for S&T services.',
            ],
        ];

        foreach ($perspectives as $index => $data) {
            $perspective = Perspective::create($data);

            // Cascade down
            $this->callWith(ObjectiveSeeder::class, [
                'perspective' => $perspective,
                'perspective_index' => $index + 1,
            ]);
        }

        $this->command->info("✅ Seeded 4 perspectives for Project: {$project->title}");
    }
}
