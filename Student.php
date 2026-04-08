<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_number',
        'address',
        'birthdate',
        'contact_number',
        'department', // IT or EMC
        'year_level',
        'semester',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The subjects that belong to the student.
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)
                    ->withPivot('grade')
                    ->withTimestamps();
    }

    /**
     * Calculate the Grade Weighted Average (GWA) for the student
     * 
     * @return array Contains 'gwa' (the calculated GWA) and 'status' (if it's complete)
     */
    public function calculateGWA(): array
    {
        // Get the subjects with their pivot data
        $subjects = $this->subjects;
        
        // If no subjects, return 0
        if ($subjects->count() === 0) {
            return [
                'gwa' => 0,
                'status' => false,
                'total_units' => 0,
                'graded_units' => 0
            ];
        }
        
        $totalUnits = 0;
        $totalGradePoints = 0;
        $gradedUnits = 0;
        
        foreach ($subjects as $subject) {
            // Make sure units is treated as a number and is at least 1
            $units = max(1, (int) $subject->units);
            $totalUnits += $units;
            
            // Only include subjects that have grades
            if (isset($subject->pivot) && 
                isset($subject->pivot->grade) && 
                $subject->pivot->grade !== null && 
                $subject->pivot->grade !== '') {
                
                $grade = (float) $subject->pivot->grade;
                $gradedUnits += $units;
                $totalGradePoints += ($grade * $units);
            }
        }
        
        // If no grades yet, return 0
        if ($gradedUnits <= 0) {
            return [
                'gwa' => 0,
                'status' => false,
                'total_units' => $totalUnits,
                'graded_units' => 0
            ];
        }
        
        $gwa = $totalGradePoints / $gradedUnits;
        
        return [
            'gwa' => round($gwa, 2),
            'status' => ($gradedUnits === $totalUnits), // true if all subjects have grades
            'total_units' => $totalUnits,
            'graded_units' => $gradedUnits
        ];
    }
    
    /**
     * Get the academic standing based on GWA
     * 
     * @param float $gwa The Grade Weighted Average
     * @return string The academic standing
     */
    public function getAcademicStanding(float $gwa): string
    {
        // Check if GWA is 0 or invalid (no grades yet)
        if ($gwa == 0 || $gwa === null) {
            return 'No Grades Yet';
        } elseif ($gwa <= 1.25) {
            return 'President\'s Lister';
        } elseif ($gwa <= 1.45) {
            return 'Dean\'s Lister';
        } elseif ($gwa <= 1.75) {
            return 'With Honors';
        } elseif ($gwa <= 3.0) {
            return 'Passed';
        } else {
            return 'Failed';
        }
    }
} 