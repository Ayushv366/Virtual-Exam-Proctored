@extends('layouts.master')

@section('title', 'Assigned Exams')

@section('content')
<h1 class="h3 mb-3">Assigned Exams</h1>
<div class="card card-metric"><div class="card-body">@include('exams.partials.table', ['exams' => $exams])</div></div>
@endsection
