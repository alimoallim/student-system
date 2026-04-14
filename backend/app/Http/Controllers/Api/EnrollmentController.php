<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student.user', 'course.instructor'])->paginate(10);
        return response()->json($enrollments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        // Optional: you can check capacity here before creating.
        // Capacity rule isn't enforced by schema, so you must implement it in controller.

        // Prevent duplicates (unique(student_id, course_id))
        $enrollment = Enrollment::create([
            'student_id' => $data['student_id'],
            'course_id' => $data['course_id'],
        ]);

        return response()->json(
            $enrollment->load(['student.user', 'course.instructor']),
            201
        );
    }

    public function show($id)
    {
        return response()->json(
            Enrollment::with(['student.user', 'course.instructor'])->findOrFail($id)
        );
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted']);
    }

    // Helpful: list courses for a student
    public function studentCourses($studentId)
    {
        $student = Student::with('courses')->findOrFail($studentId);
        return response()->json($student->courses);
    }
}