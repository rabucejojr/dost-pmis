<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Indicator;

class IndicatorSeeder extends Seeder
{
    public function run(array $params = []): void
    {
        $objective       = $params['objective'] ?? null;
        $indicatorCount  = $params['indicator_count'] ?? 3;

        if (!$objective) {
            $this->command?->warn('⚠️ IndicatorSeeder skipped — no objective passed.');
            return;
        }

        $perspective = $objective->perspective;
        $year        = $perspective->implementing_year ?? now()->year;

        $perspectiveCode = str_pad($perspective->id, 3, '0', STR_PAD_LEFT);
        $objectiveCode   = str_pad($objective->id, 3, '0', STR_PAD_LEFT);
        $baseCode        = "{$year}-P-{$perspectiveCode}-O-{$objectiveCode}";

        $indicators = [
            'No. of research projects completed',
            'No. of technologies developed',
            'No. of MSMEs assisted',
            'Percentage of project targets achieved',
            'No. of trainings conducted',
            'No. of beneficiaries reached',
            'Customer satisfaction rate (%)',
            'No. of policy recommendations formulated',
            'No. of patents/IPs filed',
            'No. of collaborations established',
        ];

        shuffle($indicators);

        for ($i = 1; $i <= $indicatorCount; $i++) {
            $label = $indicators[($i - 1) % count($indicators)];

            Indicator::create([
                'objective_id'       => $objective->id,
                'implementing_year'  => $year,
                'name'               => $label,
                'description'        => "Tracks performance for '{$objective->name}' under {$perspective->name}.",
                'target_value'       => rand(5, 30),
                'actual_value'       => rand(3, 25),
                'unit'               => str_contains($label, '%') ? '%' : 'count',
                'frequency'          => str_contains($label, '%') ? 'Annually' : 'Quarterly',
                'code'               => "{$baseCode}-I-" . str_pad($i, 3, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command?->info("✅ {$indicatorCount} indicators seeded for {$objective->name}");
    }
}
