<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Exception;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Get unique departments from the subjects table (available programs/courses)
        $departments = \App\Models\Subject::select('department')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');
        
        return view('auth.register', compact('departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'department' => ['required', 'string', 'max:100'],
                'year_level' => ['required', 'string', 'in:1,2,3,4,5'],
                'semester' => ['required', 'string', 'in:1st,2nd,Summer'],
                'address' => ['nullable', 'string', 'max:255'],
                'birthdate' => ['nullable', 'date', 'before:today'],
                'contact_number' => ['nullable', 'string', 'max:20'],
            ]);

            // Use database transaction to ensure both user and student are created
            DB::beginTransaction();

            try {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'student',
                    'is_verified' => false,
                ]);

                // Convert semester string to integer
                $semesterMap = [
                    '1st' => 1,
                    '2nd' => 2,
                    'Summer' => 3,
                ];
                
                $semesterValue = $semesterMap[$request->semester] ?? 1;

                // Auto-generate student number
                $studentNumber = $this->generateStudentNumber();

                // Create the student record
                $student = Student::create([
                    'user_id' => $user->id,
                    'student_number' => $studentNumber,
                    'department' => $request->department,
                    'year_level' => (int) $request->year_level,
                    'semester' => $semesterValue,
                    'address' => $request->address ?? 'Not Provided',
                    'birthdate' => $request->birthdate ?? '2000-01-01',
                    'contact_number' => $request->contact_number ?? 'Not Provided',
                ]);

                // If we got here, commit the transaction
                DB::commit();

                event(new Registered($user));

                Auth::login($user);

                // Redirect with success message
                return redirect()->route('dashboard')->with('success', 'Registration successful! Your student number is: ' . $studentNumber);
            } catch (Exception $e) {
                // Rollback the transaction
                DB::rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            // Log the error
            Log::error('Registration error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            // Redirect back with error
            return back()->withInput()->withErrors(['registration_error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate a new student number by incrementing the last one
     */
    private function generateStudentNumber(): string
    {
        // Get the last student number
        $lastStudent = Student::orderBy('student_number', 'desc')->first();
        
        if (!$lastStudent) {
            // If no students exist, start with STU-000001
            return 'STU-000001';
        }
        
        // Extract the numeric part from the last student number (e.g., STU-000053 -> 53)
        $lastNumber = (int) substr($lastStudent->student_number, 4);
        
        // Increment by 1
        $newNumber = $lastNumber + 1;
        
        // Format with leading zeros (6 digits)
        return 'STU-' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
}
