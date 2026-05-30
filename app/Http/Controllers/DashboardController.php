<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Exam;
use App\Models\ProctorLog;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user?->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'faculty' => redirect()->route('faculty.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    }

    public function adminDashboard(): View
    {
        return view('admin.dashboard', [
            'studentsCount' => User::query()->where('role', 'student')->count(),
            'facultyCount' => User::query()->where('role', 'faculty')->count(),
            'examsCount' => Exam::query()->count(),
            'activeExamsCount' => Exam::query()->where('is_active', true)->count(),
            'suspiciousLogsCount' => ProctorLog::query()->count(),
            'latestAnnouncements' => Announcement::query()->latest()->take(5)->get(),
        ]);
    }

    public function facultyDashboard(): View
    {
        return view('faculty.dashboard', [
            'exams' => auth()->user()?->createdExams()->latest()->paginate(5),
            'resultsCount' => Result::query()->count(),
        ]);
    }

    public function studentDashboard(): View
    {
        $user = auth()->user();

        return view('student.dashboard', [
            'upcomingExams' => Exam::query()->where('is_active', true)->orderBy('start_time')->paginate(5),
            'results' => $user?->results()->latest()->paginate(5),
            'violationsCount' => $user?->proctorLogs()->count() ?? 0,
        ]);
    }
}
