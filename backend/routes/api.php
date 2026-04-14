<?php
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('students', StudentController::class);
Route::apiResource('instructors', InstructorController::class);
Route::apiResource('courses', CourseController::class);

Route::get('enrollments', [EnrollmentController::class, 'index']);
Route::post('enrollments', [EnrollmentController::class, 'store']);
Route::get('enrollments/{id}', [EnrollmentController::class, 'show']);
Route::delete('enrollments/{id}', [EnrollmentController::class, 'destroy']);
Route::get('students/{studentId}/courses', [EnrollmentController::class, 'studentCourses']);