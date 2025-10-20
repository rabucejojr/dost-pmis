<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perspective;

class PerspectiveSeeder extends Seeder
{
    public function run(array $params = []): void
    {
        $project = $params['project'] ?? null;
        if (!$project) return;

        $year = $project->implementing_year;

        $perspectives = [
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Sustainable Development and Inclusive Growth',
                'description' => 'Focuses on environmental sustainability and equitable community progress.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Science, Technology, and Innovation Advancement',
                'description' => 'Strengthens applied research, innovation systems, and technology transfer.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Digital Transformation and Smart Communities',
                'description' => 'Advances local digitalization and e-governance systems.',
            ],
            [
                'project_id' => $project->id,
                'implementing_year' => $year,
                'name' => 'Human Resource Development and Institutional Capacity',
                'description' => 'Builds staff competencies and institutional efficiency in S&T.',
            ],
        ];

        foreach ($perspectives as $index => $data) {
            $perspective = Perspective::create($data);
            $this->callWith(ObjectiveSeeder::class, [
                'perspective' => $perspective,
                'perspective_index' => $index + 1,
            ]);
        }
    }
}
