@extends('layouts.master')

@section('title', 'Faculty Dashboard')

@section('content')
<h1 class="h3 mb-4">Faculty Dashboard</h1>
<div class="card card-metric">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h2 class="h5">My Exams</h2>
            <a class="btn btn-sm btn-primary" href="{{ route('faculty.questions.create') }}">Add Question</a>
        </div>
        @include('exams.partials.table', ['exams' => $exams])
    </div>
</div>
@endsection
