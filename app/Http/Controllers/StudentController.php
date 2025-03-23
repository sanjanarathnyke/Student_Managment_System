<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Display a listing of the students.
     */
    public function index()
    {
        $students = $this->studentRepository->getAllStudents();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student in the database.
     */
    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15'
        ]);

        // Save student using repository
        $this->studentRepository->createStudent($request->all());

        // Redirect with success message
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit($id)
    {
        $student = $this->studentRepository->getStudentById($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in the database.
     */
    public function update(Request $request, $id)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'phone' => 'required|string|max:15'
        ]);

        // Update student using repository
        $this->studentRepository->updateStudent($id, $request->all());

        // Redirect with success message
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from the database.
     */
    public function destroy($id)
    {
        // Delete student using repository
        $this->studentRepository->deleteStudent($id);

        // Redirect with success message
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
