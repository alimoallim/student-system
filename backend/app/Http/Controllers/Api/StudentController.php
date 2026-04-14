<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->paginate(10);
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],

            'student_id' => ['required', 'string', 'max:255', 'unique:students,student_id'],
            'major' => ['nullable', 'string', 'max:255'],
            'batch' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'student_id' => $data['student_id'],
            'major' => $data['major'] ?? null,
            'batch' => $data['batch'] ?? null,
        ]);

        return response()->json($student->load('user'), 201);
    }

    public function show($id)
    {
        $student = Student::with('user', 'courses')->findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($student->user_id),
            ],

            'student_id' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('students', 'student_id')->ignore($student->id),
            ],

            'major' => ['nullable', 'string', 'max:255'],
            'batch' => ['nullable', 'string', 'max:255'],

            'password' => ['sometimes', 'required', 'string', 'min:8'],
        ]);

        // update user fields
        if (isset($data['name'])) $student->user->name = $data['name'];
        if (isset($data['email'])) $student->user->email = $data['email'];
        if (isset($data['password'])) $student->user->password = Hash::make($data['password']);
        $student->user->save();

        // update student fields
        if (isset($data['student_id'])) $student->student_id = $data['student_id'];
        if (array_key_exists('major', $data)) $student->major = $data['major'];
        if (array_key_exists('batch', $data)) $student->batch = $data['batch'];

        $student->save();

        return response()->json($student->load('user'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // deletes student; user will remain unless you want cascade behavior
        $student->delete();

        return response()->json(['message' => 'Student deleted']);
    }
}