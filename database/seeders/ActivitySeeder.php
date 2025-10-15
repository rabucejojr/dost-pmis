<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all projects
        $projects = Project::all();

        // Possible activity templates
        $activityTemplates = [
            [
                'activity_title' => 'Training Workshop on Project Implementation',
                'description' => 'Capacity building session for project beneficiaries and implementers.',
            ],
            [
                'activity_title' => 'Consultation Meeting with Stakeholders',
                'description' => 'Discussion of project progress, issues, and coordination among stakeholders.',
            ],
            [
                'activity_title' => 'Monitoring and Evaluation Visit',
                'description' => 'Field monitoring and evaluation to assess project performance and challenges.',
            ],
            [
                'activity_title' => 'Turnover Ceremony and Exit Conference',
                'description' => 'Formal turnover of completed project deliverables to beneficiaries.',
            ],
            [
                'activity_title' => 'Post-Implementation Review',
                'description' => 'Gather feedback from beneficiaries and partner agencies after project completion.',
            ],
        ];

        foreach ($projects as $project) {
            // Create 2–3 random activities per project
            $randomActivities = collect($activityTemplates)->shuffle()->take(rand(2, 3));

            foreach ($randomActivities as $template) {
                $statusOptions = ['planned', 'ongoing', 'completed', 'rescheduled'];

                // Randomly select a status
                $status = collect($statusOptions)->random();

                // Generate date ranges and handle rescheduled condition
                $start = now()->subDays(rand(5, 30));
                $end = (clone $start)->addDays(rand(1, 5));

                $rescheduledDate = null;
                if ($status === 'rescheduled') {
                    $rescheduledDate = now()->addDays(rand(5, 15)); // Future date
                }

                Activity::create([
                    'project_id' => $project->id,
                    'activity_title' => $template['activity_title'],
                    'description' => $template['description'],
                    'start_date' => $start,
                    'end_date' => $end,
                    'status' => $status,
                    'rescheduled_date' => $rescheduledDate,
                    'remarks' => $status === 'rescheduled'
                        ? 'Activity has been rescheduled due to conflict in venue availability.'
                        : Str::ucfirst($status) . ' successfully.',
                ]);
            }
        }
    }
}
