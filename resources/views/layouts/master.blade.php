<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $appTitle ?? 'Virtual Exam Hall')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7fb; }
        .sidebar { min-height: calc(100vh - 56px); background: #14213d; }
        .sidebar a { color: #dbe7ff; text-decoration: none; display: block; padding: .7rem 1rem; border-radius: .5rem; }
        .sidebar a:hover, .sidebar .active { background: #274c77; color: #fff; }
        .card-metric { border: 0; border-radius: .75rem; box-shadow: 0 .5rem 1.5rem rgba(15,23,42,.08); }
        .exam-shell { min-height: 100vh; background: #07111f; color: #e5edf7; }
        video, canvas { max-width: 100%; border-radius: .75rem; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">Virtual Exam Hall</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNav">
            <ul class="navbar-nav me-auto"></ul>
            <span class="navbar-text me-3">{{ auth()->user()->name ?? 'Guest' }}</span>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        @auth
            <aside class="col-md-3 col-xl-2 sidebar p-3">
                <div class="text-white-50 small mb-2">{{ $examHallTagline }}</div>
                <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.exams.index') }}">Manage Exams</a>
                    <a href="{{ route('admin.subjects.index') }}">Subjects</a>
                    <a href="{{ route('admin.students.index') }}">Students</a>
                    <a href="{{ route('admin.faculty.index') }}">Faculty</a>
                    <a href="{{ route('admin.reports') }}">Reports</a>
                    <a href="{{ route('admin.suspicious') }}">Suspicious Logs</a>
                    <a href="{{ route('admin.announcements') }}">Announcements</a>
                @elseif(auth()->user()->role === 'faculty')
                    <a href="{{ route('faculty.questions') }}">Question Bank</a>
                    <a href="{{ route('faculty.assign-exams') }}">Assigned Exams</a>
                    <a href="{{ route('faculty.attempts') }}">Monitor Attempts</a>
                    <a href="{{ route('faculty.reports') }}">Reports</a>
                @else
                    <a href="{{ route('student.history') }}">Exam History</a>
                    <a href="{{ route('student.results') }}">Results</a>
                    <a href="{{ route('proctoring.logs') }}">My Proctor Logs</a>
                @endif
            </aside>
        @endauth

        <main class="@auth col-md-9 col-xl-10 @else col-12 @endauth p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix these validation errors:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            @auth
                <section class="mt-4">
                    <h6 class="text-muted">Latest announcements shared to all views</h6>
                    <div class="row g-3">
                        @forelse($sharedAnnouncements as $announcement)
                            <div class="col-md-4">
                                <div class="card card-body h-100">
                                    <strong>{{ $announcement->title }}</strong>
                                    <small class="text-muted">{{ ucfirst($announcement->audience) }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No announcements yet.</p>
                        @endforelse
                    </div>
                </section>
            @endauth
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
