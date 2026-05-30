@extends('layouts.master')

@section('title', $title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $title }}</h1>
    <a class="btn btn-outline-secondary" href="{{ $role === 'student' ? route('admin.students.index') : route('admin.faculty.index') }}">Back</a>
</div>

<div class="card card-metric">
    <div class="card-body">
        <form method="POST" action="{{ $submitRoute }}">
            @csrf
            @if($user)
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="active" @selected(old('status', $user->status ?? 'active') === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $user->status ?? '') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <input class="form-control" value="{{ ucfirst($role) }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ $user ? 'New Password (optional)' : 'Password' }}</label>
                    <input class="form-control" type="password" name="password" @required(! $user)>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation" @required(! $user)>
                </div>
            </div>

            <button class="btn btn-primary mt-3">{{ $user ? 'Update' : 'Create' }} {{ ucfirst($role) }}</button>
        </form>
    </div>
</div>
@endsection
