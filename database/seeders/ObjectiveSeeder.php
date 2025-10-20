<?php

namespace Database\Seeders;

use App\Models\Objective;

use Illuminate\Database\Seeder;
use Database\Seeders\IndicatorSeeder;

class ObjectiveSeeder extends Seeder
{
    public function run(array $params = []): void
    {
        $perspective = $params['perspective'] ?? null;
        $index = $params['perspective_index'] ?? null;
        if (!$perspective || !$index) return;

        $objectiveMap = [
            1 => [7, 6, 4, 36, 11, 3, 3, 4, 9, 2],
            2 => [3, 6, 6],
            3 => [4, 5, 1],
            4 => [7],
        ];

        $objectives = $objectiveMap[$index] ?? [];

        foreach ($objectives as $objIndex => $indicatorCount) {
            $objective = Objective::create([
                'perspective_id' => $perspective->id,
                'name' => "Objective " . ($objIndex + 1) . " under " . $perspective->name,
                'description' => "Supports the goals of {$perspective->name}.",
            ]);

            $this->callWith(IndicatorSeeder::class, [
                'objective' => $objective,
                'indicator_count' => $indicatorCount,
            ]);
        }
    }
}
