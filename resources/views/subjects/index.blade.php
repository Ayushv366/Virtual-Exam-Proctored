@extends('layouts.master')

@section('title', 'Manage Subjects')

@section('content')
<h1 class="h3 mb-3">Manage Subjects</h1>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card card-metric">
            <div class="card-body">
                <h2 class="h5">Add Subject</h2>
                <form method="POST" action="{{ route('admin.subjects.store') }}">
                    @csrf
                    <label class="form-label">Name</label>
                    <input class="form-control mb-2" name="name" value="{{ old('name') }}" required>
                    <label class="form-label">Code</label>
                    <input class="form-control mb-2" name="code" value="{{ old('code') }}" required>
                    <label class="form-label">Description</label>
                    <textarea class="form-control mb-2" name="description">{{ old('description') }}</textarea>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card card-metric">
            <div class="card-body table-responsive">
                <table class="table">
                    <thead><tr><th>Name</th><th>Code</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        <tr><td>{{ $subject->name }}</td><td>{{ $subject->code }}</td><td>{{ $subject->is_active ? 'Active' : 'Inactive' }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $subjects->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
