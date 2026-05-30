@extends('layouts.master')

@section('title', 'Suspicious Activity Logs')

@section('content')
<h1 class="h3 mb-3">Suspicious Activity Logs</h1>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Student</th><th>Exam</th><th>Violation</th><th>Description</th><th>Timestamp</th></tr></thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->student->name ?? '-' }}</td>
                    <td>{{ $log->exam->title ?? '-' }}</td>
                    <td>{{ $log->violation_type }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->timestamp }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</div>
@endsection
