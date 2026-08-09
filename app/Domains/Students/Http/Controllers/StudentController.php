<?php

namespace App\Domains\Students\Http\Controllers;

use App\Domains\Students\Http\Requests\StoreStudentRequest;
use App\Domains\Students\Http\Requests\UpdateStudentRequest;
use App\Domains\Students\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Student::class, 'student');
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');

        $students = Student::query()
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            }))
            ->orderBy('last_name')
            ->paginate(12)
            ->withQueryString();

        return view('students.index', compact('students', 'search'));
    }

    public function create(): View
    {
        return view('students.create', [
            'departments' => ['Mass Communication', 'Political Science', 'Law', 'Education', 'Accounting'],
            'levels' => ['100', '200', '300', '400', '500'],
            'statuses' => ['active' => 'Active', 'inactive' => 'Inactive', 'alumni' => 'Alumni'],
        ]);
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        Student::create($request->validated());

        return redirect()->route('students.index')->with('success', 'Student record created successfully.');
    }

    public function show(Student $student): View
    {
        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        return view('students.edit', [
            'student' => $student,
            'departments' => ['Mass Communication', 'Political Science', 'Law', 'Education', 'Accounting'],
            'levels' => ['100', '200', '300', '400', '500'],
            'statuses' => ['active' => 'Active', 'inactive' => 'Inactive', 'alumni' => 'Alumni'],
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        $student->update($request->validated());

        return redirect()->route('students.show', $student)->with('success', 'Student profile updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student record removed.');
    }
}
