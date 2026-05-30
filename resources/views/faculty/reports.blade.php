@extends('layouts.master')

@section('title', 'Faculty Reports')

@section('content')
<h1 class="h3 mb-3">Student Reports</h1>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Student</th><th>Exam</th><th>Marks</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($results as $result)
                <tr>
                    <td>{{ $result->student->name ?? '-' }}</td>
                    <td>{{ $result->exam->title ?? '-' }}</td>
                    <td>{{ $result->obtained_marks }}/{{ $result->total_marks }}</td>
                    <td>{{ ucfirst($result->status) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $results->links() }}
    </div>
</div>
@endsection
