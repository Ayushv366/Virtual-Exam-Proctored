@extends('layouts.master')

@section('title', 'Student Registration')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-metric">
            <div class="card-body p-4">
                <h1 class="h3">Student Registration</h1>
                <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input class="form-control" type="password" name="password_confirmation" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Profile Image</label>
                            <input class="form-control" type="file" name="profile_image" accept="image/*">
                        </div>
                    </div>
                    <button class="btn btn-success mt-3">Create Student Account</button>
                    <a class="btn btn-link mt-3" href="{{ route('login') }}">Back to login</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
