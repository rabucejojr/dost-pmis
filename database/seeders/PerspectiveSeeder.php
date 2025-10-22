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
            $this->command?->warn('⚠️ No project passed to PerspectiveSeeder.');
            return;
        }

        $year = $project->implementing_year;

        $perspectives = [
            [
                'project_id'        => $project->id,
                'implementing_year' => $year,
                'name'              => 'Sustainable Development and Inclusive Growth',
                'description'       => 'Focuses on sustainability and community empowerment.',
            ],
            [
                'project_id'        => $project->id,
                'implementing_year' => $year,
                'name'              => 'Science, Technology, and Innovation Advancement',
                'description'       => 'Promotes applied research and innovation.',
            ],
            [
                'project_id'        => $project->id,
                'implementing_year' => $year,
                'name'              => 'Digital Transformation and Smart Communities',
                'description'       => 'Advances e-governance and smart solutions.',
            ],
            [
                'project_id'        => $project->id,
                'implementing_year' => $year,
                'name'              => 'Human Resource Development and Institutional Capacity',
                'description'       => 'Strengthens HR and institutional capability.',
            ],
        ];

        foreach ($perspectives as $index => $data) {
            $perspective = Perspective::create($data);
            $this->command?->info("🌱 Perspective Created: {$perspective->name}");

            // ✅ Propagate parameters correctly
            app(ObjectiveSeeder::class)
                ->setContainer(app())
                ->setCommand($this->command)
                ->run([
                    'perspective'       => $perspective,
                    'perspective_index' => $index + 1,
                ]);
        }

        $this->command?->info("✅ Seeded 4 perspectives for Project: {$project->title}");
    }
}
