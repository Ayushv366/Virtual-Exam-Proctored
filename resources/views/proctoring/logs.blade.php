@extends('layouts.master')

@section('title', 'Proctoring Logs')

@section('content')
<h1 class="h3 mb-3">My Proctoring Logs</h1>
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card card-metric">
            <div class="card-body table-responsive">
                <h2 class="h5">Violation Logs</h2>
                <table class="table">
                    <thead><tr><th>Exam</th><th>Type</th><th>Description</th><th>Time</th></tr></thead>
                    <tbody>
                    @foreach($violations as $log)
                        <tr><td>{{ $log->exam->title ?? '-' }}</td><td>{{ $log->violation_type }}</td><td>{{ $log->description }}</td><td>{{ $log->timestamp }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $violations->links() }}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-metric">
            <div class="card-body">
                <h2 class="h5">Camera Logs (MongoDB)</h2>
                @forelse($cameraLogs as $log)
                    <div class="border-bottom py-2">
                        <strong>{{ $log->captured_at }}</strong>
                        <div class="text-muted">{{ $log->image_path }}</div>
                    </div>
                @empty
                    <p class="text-muted">No camera snapshots yet.</p>
                @endforelse
                {{ method_exists($cameraLogs, 'links') ? $cameraLogs->links() : '' }}
            </div>
        </div>
    </div>
</div>
@endsection
