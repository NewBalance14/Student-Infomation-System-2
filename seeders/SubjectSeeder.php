<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // IT Subjects - 1st Year
            ['code' => 'IT101', 'name' => 'Introduction to Computing', 'department' => 'IT', 'year_level' => 1, 'semester' => 1],
            ['code' => 'IT102', 'name' => 'Programming Fundamentals', 'department' => 'IT', 'year_level' => 1, 'semester' => 1],
            ['code' => 'IT103', 'name' => 'Data Structures and Algorithms', 'department' => 'IT', 'year_level' => 1, 'semester' => 2],

            // IT Subjects - 2nd Year
            ['code' => 'IT201', 'name' => 'Database Management Systems', 'department' => 'IT', 'year_level' => 2, 'semester' => 1],
            ['code' => 'IT202', 'name' => 'Web Development', 'department' => 'IT', 'year_level' => 2, 'semester' => 1],
            ['code' => 'IT203', 'name' => 'Object-Oriented Programming', 'department' => 'IT', 'year_level' => 2, 'semester' => 2],

            // IT Subjects - 3rd Year
            ['code' => 'IT301', 'name' => 'Software Engineering', 'department' => 'IT', 'year_level' => 3, 'semester' => 1],
            ['code' => 'IT302', 'name' => 'Computer Networks and Security', 'department' => 'IT', 'year_level' => 3, 'semester' => 1],
            ['code' => 'IT303', 'name' => 'Mobile Application Development', 'department' => 'IT', 'year_level' => 3, 'semester' => 2],

            // IT Subjects - 4th Year
            ['code' => 'IT401', 'name' => 'IT Capstone Project', 'department' => 'IT', 'year_level' => 4, 'semester' => 1],
            ['code' => 'IT402', 'name' => 'Cloud Computing', 'department' => 'IT', 'year_level' => 4, 'semester' => 1],
            ['code' => 'IT403', 'name' => 'Systems Administration and Maintenance', 'department' => 'IT', 'year_level' => 4, 'semester' => 2],

            // EMC Subjects - 1st Year
            ['code' => 'EMC101', 'name' => 'Introduction to Multimedia Computing', 'department' => 'EMC', 'year_level' => 1, 'semester' => 1],
            ['code' => 'EMC102', 'name' => 'Fundamentals of 2D and 3D Graphics', 'department' => 'EMC', 'year_level' => 1, 'semester' => 1],
            ['code' => 'EMC103', 'name' => 'Digital Photography and Video Production', 'department' => 'EMC', 'year_level' => 1, 'semester' => 2],

            // EMC Subjects - 2nd Year
            ['code' => 'EMC201', 'name' => 'Animation Principles and Techniques', 'department' => 'EMC', 'year_level' => 2, 'semester' => 1],
            ['code' => 'EMC202', 'name' => 'Game Development Fundamentals', 'department' => 'EMC', 'year_level' => 2, 'semester' => 1],
            ['code' => 'EMC203', 'name' => 'Audio Design and Production', 'department' => 'EMC', 'year_level' => 2, 'semester' => 2],

            // EMC Subjects - 3rd Year
            ['code' => 'EMC301', 'name' => 'Advanced Game Programming', 'department' => 'EMC', 'year_level' => 3, 'semester' => 1],
            ['code' => 'EMC302', 'name' => 'Interactive Media Design', 'department' => 'EMC', 'year_level' => 3, 'semester' => 1],
            ['code' => 'EMC303', 'name' => 'Augmented and Virtual Reality Development', 'department' => 'EMC', 'year_level' => 3, 'semester' => 2],

            // EMC Subjects - 4th Year
            ['code' => 'EMC401', 'name' => 'EMC Capstone Project', 'department' => 'EMC', 'year_level' => 4, 'semester' => 1],
            ['code' => 'EMC402', 'name' => 'Digital Post-Production and Special Effects', 'department' => 'EMC', 'year_level' => 4, 'semester' => 1],
            ['code' => 'EMC403', 'name' => 'Multimedia Systems and Game Engines', 'department' => 'EMC', 'year_level' => 4, 'semester' => 2],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
} 