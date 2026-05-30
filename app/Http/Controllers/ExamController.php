<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Mail\ExamReminderMail;
use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        return view('exams.index', [
            'exams' => Exam::query()->with(['subject', 'faculty'])->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('exams.create', [
            'subjects' => Subject::query()->orderBy('name')->get(),
            'facultyMembers' => User::query()->where('role', 'faculty')->orderBy('name')->get(),
        ]);
    }

    public function store(ExamRequest $request): RedirectResponse
    {
        Exam::create($request->validated());

        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam): View
    {
        return view('exams.show', [
            'exam' => $exam->load(['subject', 'faculty', 'questions', 'students']),
        ]);
    }

    public function edit(Exam $exam): View
    {
        return view('exams.edit', [
            'exam' => $exam,
            'subjects' => Subject::query()->orderBy('name')->get(),
            'facultyMembers' => User::query()->where('role', 'faculty')->orderBy('name')->get(),
        ]);
    }

    public function update(ExamRequest $request, Exam $exam): RedirectResponse
    {
        $exam->update($request->validated());

        if ($exam->is_active) {
            $exam->students()->each(function (User $student) use ($exam): void {
                Mail::to($student->email)->send(new ExamReminderMail($student, $exam));
            });
        }

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam): RedirectResponse
    {
        $exam->delete();

        return back()->with('success', 'Exam deleted.');
    }

    public function assignStudent(Request $request, Exam $exam): RedirectResponse
    {
        StudentExam::firstOrCreate([
            'student_id' => $request->integer('student_id'),
            'exam_id' => $exam->id,
        ]);

        return back()->with('success', 'Student assigned to exam.');
    }
}
