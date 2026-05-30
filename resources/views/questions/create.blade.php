@extends('layouts.master')

@section('title', 'Create Question')

@section('content')
<h1 class="h3 mb-3">Create Question</h1>
<div class="card card-metric">
    <div class="card-body">
        <form method="POST" action="{{ auth()->user()->role === 'faculty' ? route('faculty.questions.store') : route('questions.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Exam</label>
                    <select class="form-select" name="exam_id" required>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" @selected(old('exam_id') == $exam->id)>{{ $exam->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select class="form-select" name="question_type">
                        <option value="mcq">MCQ</option>
                        <option value="subjective">Subjective</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sequence</label>
                    <input class="form-control" type="number" name="sequence" value="{{ old('sequence', 1) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Question Text</label>
                    <textarea class="form-control" name="question_text" rows="3" required>{{ old('question_text') }}</textarea>
                </div>
                @foreach(['A','B','C','D'] as $option)
                    <div class="col-md-6">
                        <label class="form-label">Option {{ $option }}</label>
                        <input class="form-control" name="options[]" value="{{ old('options.'.($loop->index)) }}">
                    </div>
                @endforeach
                <div class="col-md-6">
                    <label class="form-label">Correct Answer</label>
                    <input class="form-control" name="correct_answer" value="{{ old('correct_answer') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Marks</label>
                    <input class="form-control" type="number" name="marks" value="{{ old('marks', 1) }}" required>
                </div>
            </div>
            <button class="btn btn-primary mt-3">Save Question</button>
        </form>
    </div>
</div>
@endsection
