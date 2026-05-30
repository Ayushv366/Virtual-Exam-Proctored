@extends('layouts.master')

@section('title', 'Monitor Attempts')

@section('content')
<h1 class="h3 mb-3">Monitor Exam Attempts</h1>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Student</th><th>Exam</th><th>Status</th><th>Score</th></tr></thead>
            <tbody>
            @foreach($attempts as $attempt)
                <tr><td>{{ $attempt->student_name }}</td><td>{{ $attempt->exam_title }}</td><td>{{ $attempt->status }}</td><td>{{ $attempt->score ?? '-' }}</td></tr>
            @endforeach
            </tbody>
        </table>
        {{ $attempts->links() }}
    </div>
</div>
@endsection
