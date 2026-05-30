@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="h3 mb-4">Admin Dashboard</h1>
<div class="row g-3">
    @foreach([
        'Students' => $studentsCount,
        'Faculty' => $facultyCount,
        'Total Exams' => $examsCount,
        'Active Exams' => $activeExamsCount,
        'Suspicious Logs' => $suspiciousLogsCount,
    ] as $label => $value)
        <div class="col-md">
            <div class="card card-metric">
                <div class="card-body">
                    <div class="text-muted">{{ $label }}</div>
                    <div class="display-6 fw-semibold">{{ $value }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="mt-4">
    <a class="btn btn-primary" href="{{ route('admin.exams.create') }}">Create Exam</a>
    <a class="btn btn-outline-secondary" href="{{ route('admin.announcements') }}">Send Announcement</a>
</div>
@endsection
