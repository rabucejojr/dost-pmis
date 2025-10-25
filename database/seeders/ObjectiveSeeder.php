<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Objective;

class ObjectiveSeeder extends Seeder
{
    public function run(array $params = []): void
    {
        $perspective = $params['perspective'] ?? null;
        $index       = $params['perspective_index'] ?? null;

        if (!$perspective || !$index) {
            if (app()->runningInConsole()) {
                $this->command?->warn('⚠️ ObjectiveSeeder skipped — missing perspective/index.');
            }
            return;
        }

        $objectiveMap = [
            1 => [7, 6, 4, 36, 11, 3, 3, 4, 9, 2],
            2 => [3, 6, 6],
            3 => [4, 5, 1],
            4 => [7],
        ];

        $objectives = $objectiveMap[$index] ?? [];

        foreach ($objectives as $objIndex => $indicatorCount) {
            $objective = Objective::create([
                'perspective_id'    => $perspective->id,
                'implementing_year' => $perspective->implementing_year,
                'name'              => "Objective " . ($objIndex + 1) . " under {$perspective->name}",
                'description'       => "Supports goals of {$perspective->name}.",
            ]);

            $this->command?->info("📌 Objective Created: {$objective->name}");

            app(IndicatorSeeder::class)
                ->setContainer(app())
                ->setCommand($this->command)
                ->run([
                    'objective'       => $objective,
                    'indicator_count' => $indicatorCount,
                ]);
        }

        $this->command?->info("✅ " . count($objectives) . " objectives seeded for {$perspective->name}");
    }

}
