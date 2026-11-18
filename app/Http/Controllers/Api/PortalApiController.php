<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\LmsAssignment;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\TimetableSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PortalApiController extends Controller
{
    /**
     * Mobile Student Portal Data feed.
     */
    public function studentDashboard(Request $request): JsonResponse
    {
        $user = $request->user();
        $student = $user->student ?? Student::with(['course', 'feeAccounts.payments'])->first();

        if (! $student) {
            return response()->json([
                'success' => false,
                'message' => 'No student profile linked to this user.',
            ], 404);
        }

        $totalSessions = StudentAttendance::where('student_id', $student->id)->count();
        $presentSessions = StudentAttendance::where('student_id', $student->id)->where('status', 'Present')->count();
        $attendancePct = $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 1) : 100.0;

        $feeBalance = $student->feeAccounts->sum('balance_amount');
        $totalFee = $student->feeAccounts->sum('total_amount');
        $paidFee = $student->feeAccounts->sum('paid_amount');

        $timetable = TimetableSlot::with(['subject', 'faculty.user'])
            ->where('class_section_id', $student->class_section_id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->map(fn ($slot) => [
                'day' => $slot->day_of_week,
                'start_time' => substr($slot->start_time, 0, 5),
                'end_time' => substr($slot->end_time, 0, 5),
                'subject_code' => $slot->subject?->code,
                'subject_name' => $slot->subject?->name,
                'faculty' => $slot->faculty?->user?->name,
                'room_no' => $slot->room_no,
            ]);

        $assignments = LmsAssignment::with(['subject'])
            ->where('is_published', true)
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($a) => [
                'id' => $a->id,
                'title' => $a->title,
                'subject' => $a->subject?->name,
                'due_date' => $a->due_date,
                'max_marks' => $a->max_marks,
            ]);

        $announcements = Announcement::where('is_active', true)
            ->latest('published_at')
            ->take(5)
            ->get(['id', 'title', 'message', 'published_at']);

        return response()->json([
            'success' => true,
            'student' => [
                'id' => $student->id,
                'name' => $student->first_name.' '.$student->last_name,
                'unique_student_id' => $student->unique_student_id,
                'enrollment_no' => $student->enrollment_no,
                'course' => $student->course?->name,
                'current_semester' => $student->current_semester,
                'attendance_pct' => $attendancePct,
                'fee_summary' => [
                    'total_amount' => $totalFee,
                    'paid_amount' => $paidFee,
                    'balance_amount' => $feeBalance,
                ],
            ],
            'timetable' => $timetable,
            'assignments' => $assignments,
            'announcements' => $announcements,
        ]);
    }

    /**
     * Mobile Announcements & Notifications feed.
     */
    public function notifications(Request $request): JsonResponse
    {
        $announcements = Announcement::where('is_active', true)
            ->latest('published_at')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $announcements,
        ]);
    }

    /**
     * Weekly Timetable endpoint for mobile offline caching.
     */
    public function timetable(Request $request): JsonResponse
    {
        $user = $request->user();
        $student = $user->student ?? Student::first();

        $slots = TimetableSlot::with(['subject', 'faculty.user'])
            ->when($student, fn ($q) => $q->where('class_section_id', $student->class_section_id))
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        return response()->json([
            'success' => true,
            'slots' => $slots,
        ]);
    }
}
