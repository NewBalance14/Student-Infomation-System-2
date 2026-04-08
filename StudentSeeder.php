<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        // Create 50 students
        for ($i = 1; $i <= 50; $i++) {
            $user = User::create([
                'name' => "Student $i",
                'email' => "student$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'student',
                'is_verified' => true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_number' => '2024' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'address' => "Address $i",
                'birthdate' => now()->subYears(rand(18, 25)),
                'contact_number' => '09' . rand(100000000, 999999999),
                'department' => rand(0, 1) ? 'IT' : 'EMC',
                'year_level' => rand(1, 4),
                'semester' => rand(1, 2),
            ]);
        }
    }
} 