<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::with('user')->paginate(10);
        return view('students.index', compact('students'));
    }

    public function show(Student $student): View
    {
        $this->authorize('view', $student);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        $this->authorize('update', $student);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $this->authorize('update', $student);
        
        $validated = $request->validate([
            'address' => ['required', 'string'],
            'contact_number' => ['required', 'string'],
            'birthdate' => ['required', 'date'],
        ]);

        $student->update($validated);

        return redirect()->route('students.show', $student)
            ->with('success', 'Profile updated successfully.');
    }

    public function verificationList(): View
    {
        $this->middleware('admin');
        
        $unverifiedStudents = Student::with('user')
            ->whereHas('user', function($query) {
                $query->where('is_verified', false);
            })
            ->paginate(10);

        return view('students.verification', compact('unverifiedStudents'));
    }

    public function verify(Student $student)
    {
        $this->middleware('admin');
        
        $student->user->update(['is_verified' => true]);

        return redirect()->route('students.verification')
            ->with('success', 'Student verified successfully.');
    }
} 