@extends('layouts.master')

@section('title', 'Question Bank')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h3">Question Bank</h1>
    <a class="btn btn-primary" href="{{ route('faculty.questions.create') }}">Create Question</a>
</div>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Exam</th><th>Question</th><th>Type</th><th>Marks</th></tr></thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->exam->title ?? '-' }}</td>
                    <td>{{ Str::limit($question->question_text, 90) }}</td>
                    <td>{{ strtoupper($question->question_type) }}</td>
                    <td>{{ $question->marks }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $questions->links() }}
    </div>
</div>
@endsection
