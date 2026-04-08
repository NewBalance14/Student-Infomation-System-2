<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    /**
     * Show the form for creating a new enrollment.
     */
    public function create(Student $student): View
    {
        $availableSubjects = Subject::where('department', $student->department)
            ->where('year_level', $student->year_level)
            ->whereNotIn('id', $student->subjects->pluck('id'))
            ->get();

        return view('enrollments.create', compact('student', 'availableSubjects'));
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        try {
            $subjects = $request->input('subjects', []);
            
            // Attach each selected subject to the student
            foreach ($subjects as $subjectId) {
                // Check if the student is already enrolled in this subject
                if (!$student->subjects->contains($subjectId)) {
                    $student->subjects()->attach($subjectId);
                }
            }
            
            return redirect()->route('students.show', $student->id)
                ->with('success', 'Student enrolled in selected subjects successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to enroll student: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified enrollment from storage.
     */
    public function destroy(Student $student, Subject $subject)
    {
        try {
            $student->subjects()->detach($subject->id);
            return redirect()->route('students.show', $student->id)
                ->with('success', 'Student unenrolled from subject successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to unenroll student: ' . $e->getMessage());
        }
    }
} 