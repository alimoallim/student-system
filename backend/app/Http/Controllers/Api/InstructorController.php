<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::with('courses')->paginate(10);
        return response()->json($instructors);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'instructor_id' => ['required', 'string', 'max:255', 'unique:instructors,instructor_id'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:instructors,email'],
            'department' => ['nullable', 'string', 'max:255'],
        ]);

        $instructor = Instructor::create($data);
        return response()->json($instructor, 201);
    }

    public function show($id)
    {
        return response()->json(
            Instructor::with('courses')->findOrFail($id)
        );
    }

    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);

        $data = $request->validate([
            'instructor_id' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('instructors', 'instructor_id')->ignore($instructor->id),
            ],
            'full_name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('instructors', 'email')->ignore($instructor->id),
            ],
            'department' => ['nullable', 'string', 'max:255'],
        ]);

        $instructor->update($data);
        return response()->json($instructor);
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();

        return response()->json(['message' => 'Instructor deleted']);
    }
}