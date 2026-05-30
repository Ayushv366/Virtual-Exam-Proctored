@extends('layouts.master')

@section('title', $exam->title)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-3">
    <div>
        <h1 class="h3">{{ $exam->title }}</h1>
        <p class="text-muted">{{ $exam->subject->name ?? '-' }} | Room {{ $exam->room_code }}</p>
    </div>
    <a class="btn btn-outline-primary" href="{{ route('exams.edit', $exam) }}">Edit</a>
</div>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-metric">
            <div class="card-body">
                <h2 class="h5">Questions</h2>
                @foreach($exam->questions as $question)
                    <div class="border-bottom py-2">
                        <strong>{{ $question->sequence }}. {{ $question->question_text }}</strong>
                        <div class="text-muted">{{ strtoupper($question->question_type) }} | {{ $question->marks }} marks</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-metric">
            <div class="card-body">
                <h2 class="h5">Schedule</h2>
                <p>Start: {{ $exam->start_time->format('d M Y H:i') }}</p>
                <p>End: {{ $exam->end_time->format('d M Y H:i') }}</p>
                <p>Faculty: {{ $exam->faculty->name ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
