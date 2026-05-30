@extends('layouts.master')

@section('title', 'Student Dashboard')

@section('content')
<h1 class="h3 mb-4">Student Dashboard</h1>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card card-metric">
            <div class="card-body">
                <h2 class="h5">Available Virtual Exam Halls</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Exam</th><th>Subject</th><th>Start</th><th>Action</th></tr></thead>
                        <tbody>
                        @foreach($upcomingExams as $exam)
                            <tr>
                                <td>{{ $exam->title }}</td>
                                <td>{{ $exam->subject->name ?? '-' }}</td>
                                <td>{{ $exam->start_time->format('d M Y H:i') }}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="{{ route('student.hall', $exam) }}">Join Hall</a>
                                    <form class="d-inline" method="POST" action="{{ route('student.exams.remind', $exam) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary">Email Reminder</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $upcomingExams->links() }}
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-metric mb-3">
            <div class="card-body">
                <h2 class="h6">Upload Profile Image</h2>
                <form method="POST" action="{{ route('student.profile.image') }}" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control mb-2" type="file" name="profile_image" accept="image/*" required>
                    <button class="btn btn-outline-secondary w-100">Upload</button>
                </form>
            </div>
        </div>
        <div class="card card-metric">
            <div class="card-body">
                <div class="text-muted">Proctoring violations</div>
                <div class="display-6">{{ $violationsCount }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
