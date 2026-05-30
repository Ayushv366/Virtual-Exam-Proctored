<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Http\Requests\ExamRequest;
use App\Models\Announcement;
use App\Models\Exam;
use App\Models\ProctorLog;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return app(DashboardController::class)->adminDashboard();
    }

    public function manageStudents(Request $request): View
    {
        $students = User::query()
            ->where('role', 'student')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    public function createStudent(): View
    {
        return view('admin.users.form', [
            'user' => null,
            'role' => 'student',
            'title' => 'Create Student',
            'submitRoute' => route('admin.students.store'),
        ]);
    }

    public function storeStudent(Request $request): RedirectResponse
    {
        $this->storeRoleUser($request, 'student');

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function editStudent(User $user): View
    {
        abort_unless($user->role === 'student', 404);

        return view('admin.users.form', [
            'user' => $user,
            'role' => 'student',
            'title' => 'Edit Student',
            'submitRoute' => route('admin.students.update', $user),
        ]);
    }

    public function updateStudent(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'student', 404);
        $this->updateRoleUser($request, $user, 'student');

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function manageFaculty(): View
    {
        $faculty = User::query()->where('role', 'faculty')->latest()->paginate(10);

        return view('admin.faculty.index', compact('faculty'));
    }

    public function createFaculty(): View
    {
        return view('admin.users.form', [
            'user' => null,
            'role' => 'faculty',
            'title' => 'Create Faculty',
            'submitRoute' => route('admin.faculty.store'),
        ]);
    }

    public function storeFaculty(Request $request): RedirectResponse
    {
        $this->storeRoleUser($request, 'faculty');

        return redirect()->route('admin.faculty.index')->with('success', 'Faculty created successfully.');
    }

    public function editFaculty(User $user): View
    {
        abort_unless($user->role === 'faculty', 404);

        return view('admin.users.form', [
            'user' => $user,
            'role' => 'faculty',
            'title' => 'Edit Faculty',
            'submitRoute' => route('admin.faculty.update', $user),
        ]);
    }

    public function updateFaculty(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'faculty', 404);
        $this->updateRoleUser($request, $user, 'faculty');

        return redirect()->route('admin.faculty.index')->with('success', 'Faculty updated successfully.');
    }

    public function manageSubjects(): View
    {
        $subjects = Subject::query()->latest()->paginate(10);

        return view('subjects.index', compact('subjects'));
    }

    public function storeSubject(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:subjects,code'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        Subject::create($data + ['is_active' => $request->boolean('is_active', true)]);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject saved successfully.');
    }

    public function createExam(): View
    {
        return view('exams.create', [
            'subjects' => Subject::query()->where('is_active', true)->orderBy('name')->get(),
            'facultyMembers' => User::query()->where('role', 'faculty')->orderBy('name')->get(),
        ]);
    }

    public function storeExam(ExamRequest $request): RedirectResponse
    {
        Exam::create($request->validated());

        return redirect()->route('admin.exams.index')->with('success', 'Exam created successfully.');
    }

    public function exams(): View
    {
        return view('exams.index', [
            'exams' => Exam::query()->with(['subject', 'faculty'])->latest()->paginate(10),
        ]);
    }

    public function toggleExam(Exam $exam): RedirectResponse
    {
        $exam->update(['is_active' => ! $exam->is_active, 'published_at' => $exam->is_active ? null : now()]);

        return back()->with('success', 'Exam status updated.');
    }

    public function reports(): View
    {
        return view('admin.reports', [
            'proctorLogs' => ProctorLog::query()->with(['student', 'exam'])->latest()->paginate(15),
            'results' => DB::table('results')
                ->join('users', 'results.student_id', '=', 'users.id')
                ->join('exams', 'results.exam_id', '=', 'exams.id')
                ->select('users.name as student_name', 'exams.title as exam_title', 'results.percentage', 'results.status')
                ->orderByDesc('results.id')
                ->paginate(15),
        ]);
    }

    public function announcements(): View
    {
        return view('announcements.index', [
            'announcements' => Announcement::query()->with('creator')->latest()->paginate(10),
        ]);
    }

    public function storeAnnouncement(AnnouncementRequest $request): RedirectResponse
    {
        Announcement::create($request->validated() + ['created_by' => $request->user()->id]);

        return redirect()->route('admin.announcements')->with('success', 'Announcement published.');
    }

    public function suspiciousActivity(): View
    {
        return view('admin.suspicious-activity', [
            'logs' => ProctorLog::query()->with(['student', 'exam'])->latest()->paginate(20),
        ]);
    }

    private function storeRoleUser(Request $request, string $role): User
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'status' => $data['status'],
            'email_verified_at' => now(),
        ]);
    }

    private function updateRoleUser(Request $request, User $user, string $role): void
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $role,
            'status' => $data['status'],
        ];

        if (! empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);
    }
}
