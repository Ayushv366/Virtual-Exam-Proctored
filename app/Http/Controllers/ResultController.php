<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResultRequest;
use App\Mail\ResultNotificationMail;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ResultController extends Controller
{
    public function index(): View
    {
        return view('results.index', [
            'results' => Result::query()->with(['student', 'exam'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('results.create', [
            'students' => User::query()->where('role', 'student')->orderBy('name')->get(),
        ]);
    }

    public function store(ResultRequest $request): RedirectResponse
    {
        $result = Result::create($request->validated());
        Mail::to($result->student->email)->send(new ResultNotificationMail($result->student, $result));

        return redirect()->route('results.index')->with('success', 'Result stored and notification email sent.');
    }

    public function show(Result $result): View
    {
        return view('results.show', [
            'result' => $result->load(['student', 'exam']),
        ]);
    }

    public function edit(Result $result): View
    {
        return view('results.edit', [
            'result' => $result,
            'students' => User::query()->where('role', 'student')->orderBy('name')->get(),
        ]);
    }

    public function update(ResultRequest $request, Result $result): RedirectResponse
    {
        $result->update($request->validated());

        return redirect()->route('results.index')->with('success', 'Result updated successfully.');
    }

    public function destroy(Result $result): RedirectResponse
    {
        $result->delete();

        return back()->with('success', 'Result deleted.');
    }
}
