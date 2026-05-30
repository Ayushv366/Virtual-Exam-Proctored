@extends('layouts.master')

@section('title', 'Exam Reports')

@section('content')
<h1 class="h3 mb-3">Exam Reports</h1>
<div class="card card-metric mb-3">
    <div class="card-body table-responsive">
        <h2 class="h5">Results</h2>
        <table class="table">
            <thead><tr><th>Student</th><th>Exam</th><th>Percentage</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($results as $result)
                <tr><td>{{ $result->student_name }}</td><td>{{ $result->exam_title }}</td><td>{{ $result->percentage }}%</td><td>{{ $result->status }}</td></tr>
            @endforeach
            </tbody>
        </table>
        {{ $results->links() }}
    </div>
</div>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <h2 class="h5">Suspicious Activity</h2>
        <table class="table">
            <thead><tr><th>Student</th><th>Exam</th><th>Type</th><th>Time</th></tr></thead>
            <tbody>
            @foreach($proctorLogs as $log)
                <tr><td>{{ $log->student->name ?? '-' }}</td><td>{{ $log->exam->title ?? '-' }}</td><td>{{ $log->violation_type }}</td><td>{{ $log->timestamp }}</td></tr>
            @endforeach
            </tbody>
        </table>
        {{ $proctorLogs->links() }}
    </div>
</div>
@endsection
