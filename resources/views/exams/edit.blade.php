@extends('layouts.master')

@section('title', 'Edit Exam')

@section('content')
<h1 class="h3 mb-3">Edit Exam</h1>
<div class="card card-metric">
    <div class="card-body">
        <form method="POST" action="{{ route('exams.update', $exam) }}">
            @csrf
            @method('PUT')
            @include('exams.form', ['exam' => $exam])
            <button class="btn btn-primary">Update Exam</button>
        </form>
    </div>
</div>
@endsection
