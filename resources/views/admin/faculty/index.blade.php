@extends('layouts.master')

@section('title', 'Manage Faculty')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Manage Faculty</h1>
    <a class="btn btn-primary" href="{{ route('admin.faculty.create') }}">Create Faculty</a>
</div>
<div class="card card-metric">
    <div class="card-body table-responsive">
        <table class="table">
            <thead><tr><th>Name</th><th>Email</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($faculty as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->status }}</td>
                    <td>{{ $member->created_at->format('d M Y') }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ route('admin.faculty.edit', $member) }}">Edit</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $faculty->links() }}
    </div>
</div>
@endsection
