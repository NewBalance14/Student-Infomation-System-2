<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GradeController extends Controller
{
    private array $validGrades = [1.0, 1.25, 1.50, 1.75, 2.0, 2.25, 2.50, 2.75, 3.0, 5.0];

    public function edit(Student $student, Subject $subject): View
    {
        $enrollment = $student->subjects()->findOrFail($subject->id);
        return view('grades.edit', compact('student', 'subject', 'enrollment'));
    }

    public function update(Request $request, Student $student, Subject $subject)
    {
        $validated = $request->validate([
            'grade' => ['required', 'numeric', 'in:' . implode(',', $this->validGrades)],
        ]);

        $student->subjects()->updateExistingPivot($subject->id, [
            'grade' => $validated['grade'],
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Grade updated successfully.');
    }
} 