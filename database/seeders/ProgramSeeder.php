<?php

namespace Database\Seeders;

use App\Enums\ProgramType;
use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $programs =[
            [
                'program_name' => 'Small Enterprises Technology Upgrading Program',
                'description' => 'SETUP program specifically targets micro, small, and medium enterprises (MSMEs) by providing financial support for the acquisition of technology to improve their operations, particularly in food processing and manufacturing.',
                'slug' => 'setup',
                'type' => ProgramType::SETUP,
            ],
            [
                'program_name' => 'Local Grants-in-Aid',
                'description' => 'Program provides direct funding for science and technology projects, particularly in underserved areas.',
                'slug' => 'lgia',
                'type' => ProgramType::LGIA,
            ],
            [
                'program_name' => 'Community Empowerment through Science and Technology',
                'description' => 'CEST program focuses on empowering marginalized communities, including geographically isolated and disadvantaged areas (GIDA), conflict-affected zones, Indigenous Peoples (IP) communities, and women’s groups, through science and technology-based interventions.',
                'slug' => 'cest',
                'type' => ProgramType::CEST,
            ],
            [
                'program_name' => 'Smart and Sustainable Communities Program',
                'description' => 'A national initiative designed to guide local government units (LGUs) in becoming smarter, more resilient, and sustainable communities by leveraging technology and innovation to enhance urban functionality, sustainability, and livability.',
                'slug' => 'sscp',
                'type' => ProgramType::SSCP,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
