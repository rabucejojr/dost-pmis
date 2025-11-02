<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectStaff;
use Illuminate\Database\Seeder;

class ProjectStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all projects
        $projects = Project::all();

        // ✅ Master list of all 11 staff (you can update names freely)
        $staffList = [
            ['name' => 'Engr. Juan Dela Cruz', 'position' => 'Project Leader', 'contact_no' => '09170000001', 'email' => 'juan.delacruz@dost.gov.ph'],
            ['name' => 'Maria Santos', 'position' => 'Technical Staff', 'contact_no' => '09170000002', 'email' => 'maria.santos@dost.gov.ph'],
            ['name' => 'Pedro Reyes', 'position' => 'Technical Staff', 'contact_no' => '09170000003', 'email' => 'pedro.reyes@dost.gov.ph'],
            ['name' => 'Anna Lopez', 'position' => 'Administrative Officer', 'contact_no' => '09170000004', 'email' => 'anna.lopez@dost.gov.ph'],
            ['name' => 'Carlo Mendoza', 'position' => 'IT Support', 'contact_no' => '09170000005', 'email' => 'carlo.mendoza@dost.gov.ph'],
            ['name' => 'Ella Cruz', 'position' => 'Science Research Specialist', 'contact_no' => '09170000006', 'email' => 'ella.cruz@dost.gov.ph'],
            ['name' => 'Mark Villanueva', 'position' => 'Field Coordinator', 'contact_no' => '09170000007', 'email' => 'mark.villanueva@dost.gov.ph'],
            ['name' => 'Sofia Ramos', 'position' => 'Project Assistant', 'contact_no' => '09170000008', 'email' => 'sofia.ramos@dost.gov.ph'],
            ['name' => 'Ryan Garcia', 'position' => 'Finance Assistant', 'contact_no' => '09170000009', 'email' => 'ryan.garcia@dost.gov.ph'],
            ['name' => 'Liza Fernandez', 'position' => 'Documentation Officer', 'contact_no' => '09170000010', 'email' => 'liza.fernandez@dost.gov.ph'],
            ['name' => 'Dr. Noel Aquino', 'position' => 'Consultant', 'contact_no' => '09170000011', 'email' => 'noel.aquino@dost.gov.ph'],
        ];

        // ✅ Assign 3 random unique staff per project
        foreach ($projects as $project) {
            // Randomly pick 3 distinct staff members
            $selectedStaff = collect($staffList)->shuffle()->take(3);

            foreach ($selectedStaff as $staff) {
                ProjectStaff::create([
                    'project_id' => $project->id,
                    'name' => $staff['name'],
                    'position' => $staff['position'],
                    'contact_no' => $staff['contact_no'],
                    'email' => $staff['email'],
                ]);
            }
        }
    }
}
