<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Authenticate user and issue API Bearer Token.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::with(['role', 'student.course', 'employee.department'])->where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials provided.'],
            ]);
        }

        if ($user->status !== 'Active') {
            return response()->json([
                'success' => false,
                'message' => 'Account is inactive. Please contact college administration.',
            ], 403);
        }

        $deviceName = $validated['device_name'] ?? 'dpcc-mobile-app';
        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role?->name,
                'role_slug' => $user->role?->slug,
                'student_profile' => $user->student ? [
                    'id' => $user->student->id,
                    'unique_student_id' => $user->student->unique_student_id,
                    'course' => $user->student->course?->name,
                    'course_code' => $user->student->course?->code,
                    'current_semester' => $user->student->current_semester,
                ] : null,
                'employee_profile' => $user->employee ? [
                    'id' => $user->employee->id,
                    'employee_code' => $user->employee->employee_code,
                    'designation' => $user->employee->designation,
                    'department' => $user->employee->department?->name,
                ] : null,
            ],
        ]);
    }

    /**
     * Retrieve authenticated user profile with roles.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load(['role', 'student.course', 'employee.department']);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'status' => $user->status,
                'role' => $user->role?->name,
                'role_slug' => $user->role?->slug,
                'student' => $user->student,
                'employee' => $user->employee,
            ],
        ]);
    }

    /**
     * Revoke current access token (logout).
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Signed out successfully from mobile device.',
        ]);
    }
}
