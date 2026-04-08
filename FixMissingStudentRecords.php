<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Student;

class FixMissingStudentRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:fix-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix missing student records for users with student role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for users without student records...');
        
        // Find all users with 'student' role who don't have a student record
        $usersWithoutStudentRecords = User::where('role', 'student')
            ->doesntHave('student')
            ->get();
        
        if ($usersWithoutStudentRecords->isEmpty()) {
            $this->info('✓ All student users have corresponding student records.');
            return Command::SUCCESS;
        }
        
        $this->warn("Found {$usersWithoutStudentRecords->count()} users without student records:");
        
        foreach ($usersWithoutStudentRecords as $user) {
            $this->line("  - User ID: {$user->id}, Name: {$user->name}, Email: {$user->email}");
        }
        
        $this->newLine();
        
        if (!$this->confirm('Do you want to create default student records for these users?', true)) {
            $this->info('Operation cancelled.');
            return Command::SUCCESS;
        }
        
        $created = 0;
        
        foreach ($usersWithoutStudentRecords as $user) {
            try {
                // Generate a default student number if not exists
                $studentNumber = 'STU-' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
                
                $student = Student::create([
                    'user_id' => $user->id,
                    'student_number' => $studentNumber,
                    'department' => 'IT', // Default department
                    'year_level' => 1,    // Default year level as integer
                    'semester' => 1,      // Default semester as integer
                    'address' => 'Not Provided',
                    'birthdate' => '2000-01-01',
                    'contact_number' => 'Not Provided',
                ]);
                
                $this->info("✓ Created student record for: {$user->name} (Student #: {$studentNumber})");
                $created++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to create student record for User ID {$user->id}: {$e->getMessage()}");
            }
        }
        
        $this->newLine();
        $this->info("Successfully created {$created} student records.");
        $this->warn("Note: Default values were used. Users should update their information via their profile.");
        
        return Command::SUCCESS;
    }
}

