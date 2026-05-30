@extends('layouts.master')

@section('title', 'Question Details')

@section('content')
<h1 class="h3 mb-3">Question Details</h1>
<div class="card card-metric">
    <div class="card-body">
        <p><strong>Exam:</strong> {{ $question->exam->title ?? '-' }}</p>
        <p><strong>Type:</strong> {{ strtoupper($question->question_type) }}</p>
        <p><strong>Question:</strong> {{ $question->question_text }}</p>
        @if($question->options)
            <p><strong>Options:</strong> {{ implode(', ', array_filter($question->options)) }}</p>
        @endif
        <p><strong>Correct Answer:</strong> {{ $question->correct_answer }}</p>
        <a class="btn btn-outline-primary" href="{{ route('questions.edit', $question) }}">Edit</a>
    </div>
</div>
@endsection
