@extends('layouts.master')

@section('title', 'Manage Exams')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Manage Exams</h1>
    @if(auth()->user()?->role === 'admin')
        <a class="btn btn-primary" href="{{ route('admin.exams.create') }}">Create Exam</a>
    @endif
</div>
<div class="card card-metric"><div class="card-body">@include('exams.partials.table', ['exams' => $exams])</div></div>
@endsection
