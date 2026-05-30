<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Result;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function dashboard(): View
    {
        return app(DashboardController::class)->facultyDashboard();
    }

    public function questionBanks(): View
    {
        $questions = Question::query()->with('exam')->latest()->paginate(12);

        return view('faculty.questions.index', compact('questions'));
    }

    public function createQuestion(): View
    {
        return view('questions.create', [
            'exams' => Exam::query()->where('faculty_id', auth()->id())->orderByDesc('id')->get(),
        ]);
    }

    public function storeQuestion(QuestionRequest $request): RedirectResponse
    {
        Question::create($request->validated());

        return redirect()->route('faculty.questions')->with('success', 'Question saved successfully.');
    }

    public function assignExams(): View
    {
        return view('faculty.assign-exams', [
            'exams' => Exam::query()->where('faculty_id', auth()->id())->latest()->paginate(10),
        ]);
    }

    public function monitorAttempts(): View
    {
        return view('faculty.attempts', [
            'attempts' => DB::table('student_exams')
                ->join('users', 'student_exams.student_id', '=', 'users.id')
                ->join('exams', 'student_exams.exam_id', '=', 'exams.id')
                ->select('users.name as student_name', 'exams.title as exam_title', 'student_exams.status', 'student_exams.score')
                ->orderByDesc('student_exams.id')
                ->paginate(15),
        ]);
    }

    public function reports(): View
    {
        return view('faculty.reports', [
            'results' => Result::query()->with(['student', 'exam'])->latest()->paginate(15),
            'subjects' => Subject::query()->count(),
        ]);
    }
}
