<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Interfaces\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    public function getAllStudents()
    {
        return Student::all();
    }

    public function getStudentById($id)
    {
        return Student::findOrFail($id);
    }

    public function createStudent(array $data)
    {
        return Student::create($data);
    }

    public function updateStudent($id, array $data)
    {
        $student = Student::findOrFail($id);
        $student->update($data);
        return $student;
    }

    public function deleteStudent($id)
    {
        Student::destroy($id);
    }
}
