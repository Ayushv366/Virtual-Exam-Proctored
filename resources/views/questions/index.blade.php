@extends('layouts.master')

@section('title', 'Questions')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Questions</h1>
    <a class="btn btn-primary" href="{{ route('questions.create') }}">Create Question</a>
</div>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Exam</th><th>Question</th><th>Type</th><th>Marks</th><th></th></tr></thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->exam->title ?? '-' }}</td>
                    <td>{{ Str::limit($question->question_text, 80) }}</td>
                    <td>{{ $question->question_type }}</td>
                    <td>{{ $question->marks }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ route('questions.show', $question) }}">View</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $questions->links() }}
    </div>
</div>
@endsection
