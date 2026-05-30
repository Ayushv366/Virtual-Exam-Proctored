@extends('layouts.master')

@section('title', 'Exam History')

@section('content')
<h1 class="h3 mb-3">Exam History</h1>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Exam</th><th>Subject</th><th>Status</th><th>Submitted</th></tr></thead>
            <tbody>
            @foreach($history as $exam)
                <tr>
                    <td>{{ $exam->title }}</td>
                    <td>{{ $exam->subject->name ?? '-' }}</td>
                    <td>{{ $exam->pivot->status }}</td>
                    <td>{{ $exam->pivot->submitted_at ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $history->links() }}
    </div>
</div>
@endsection
