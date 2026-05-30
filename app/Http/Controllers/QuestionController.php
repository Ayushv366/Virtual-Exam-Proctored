<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(): View
    {
        return view('questions.index', [
            'questions' => Question::query()->with('exam')->orderBy('sequence')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('questions.create', [
            'exams' => Exam::query()->where('faculty_id', auth()->id())->orderByDesc('id')->get(),
        ]);
    }

    public function store(QuestionRequest $request): RedirectResponse
    {
        Question::create($request->validated());

        return redirect()->route('questions.index')->with('success', 'Question added successfully.');
    }

    public function show(Question $question): View
    {
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question): View
    {
        return view('questions.edit', [
            'question' => $question,
            'exams' => Exam::query()->where('faculty_id', auth()->id())->orderByDesc('id')->get(),
        ]);
    }

    public function update(QuestionRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return back()->with('success', 'Question removed.');
    }
}
