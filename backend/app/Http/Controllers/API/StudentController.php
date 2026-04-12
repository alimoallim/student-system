<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index(): JsonResponse
    {
        $students = Student::with('user')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $students
        ]);
    }

    /**
     * Store a newly created student
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id|unique:students,user_id',
            'student_id' => 'required|string|unique:students,student_id',
            'major'      => 'nullable|string|max:255',
            'batch'      => 'nullable|string|max:50',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    /**
     * Display a specific student
     */
    public function show($id): JsonResponse
    {
        $student = Student::with('user')->find($id);

        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $student
        ]);
    }

    /**
     * Update student
     */
    public function update(Request $request, $id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $validated = $request->validate([
            'student_id' => 'sometimes|string|unique:students,student_id,' . $id,
            'major'      => 'nullable|string|max:255',
            'batch'      => 'nullable|string|max:50',
        ]);

        $student->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ]);
    }

    /**
     * Delete student
     */
    public function destroy($id): JsonResponse
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => false,
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'status' => true,
            'message' => 'Student deleted successfully'
        ]);
    }
}