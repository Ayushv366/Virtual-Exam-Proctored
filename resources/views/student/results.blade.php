@extends('layouts.master')

@section('title', 'My Results')

@section('content')
<h1 class="h3 mb-3">My Results</h1>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Exam</th><th>Marks</th><th>Percentage</th><th>Status</th><th>Remarks</th></tr></thead>
            <tbody>
            @foreach($results as $result)
                <tr>
                    <td>{{ $result->exam->title ?? '-' }}</td>
                    <td>{{ $result->obtained_marks }}/{{ $result->total_marks }}</td>
                    <td>{{ $result->percentage }}%</td>
                    <td>{{ ucfirst($result->status) }}</td>
                    <td>{{ $result->remarks }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $results->links() }}
    </div>
</div>
@endsection
