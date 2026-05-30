@extends('layouts.master')

@section('title', 'Manage Students')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Manage Students</h1>
    <a class="btn btn-primary" href="{{ route('admin.students.create') }}">Create Student</a>
</div>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Last Login</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->status }}</td>
                    <td>{{ $student->last_login_at ?? '-' }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.students.edit', $student) }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $students->links() }}
    </div>
</div>
@endsection
