@extends('layouts.master')

@section('title', 'Create Exam')

@section('content')
<h1 class="h3 mb-3">Create Exam</h1>
<div class="card card-metric">
    <div class="card-body">
        <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.exams.store') : route('exams.store') }}">
            @csrf
            @include('exams.form', ['exam' => null])
            <button class="btn btn-primary">Save Exam</button>
        </form>
    </div>
</div>
@endsection
