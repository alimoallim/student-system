<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')->paginate(10);
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => ['required', 'string', 'max:255', 'unique:courses,course_code'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'credits' => ['nullable', 'integer', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],

            'instructor_id' => ['required', 'exists:instructors,id'],

            'enrollment_start_at' => ['nullable', 'date'],
            'enrollment_end_at' => ['nullable', 'date', 'after_or_equal:enrollment_start_at'],
        ]);

        $course = Course::create($data);
        return response()->json($course->load('instructor'), 201);
    }

    public function show($id)
    {
        return response()->json(
            Course::with('instructor', 'students')->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'course_code' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('courses', 'course_code')->ignore($course->id),
            ],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'credits' => ['nullable', 'integer', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],

            'instructor_id' => ['nullable', 'exists:instructors,id'],

            'enrollment_start_at' => ['nullable', 'date'],
            'enrollment_end_at' => ['nullable', 'date', 'after_or_equal:enrollment_start_at'],
        ]);

        $course->update($data);
        return response()->json($course->load('instructor'));
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}