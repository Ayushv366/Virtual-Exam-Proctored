@extends('layouts.master')

@section('title', 'Login - Virtual Exam Hall')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-lg-5">
        <div class="card card-metric">
            <div class="card-body p-4">
                <h1 class="h3 mb-1">Secure Exam Login</h1>
                <p class="text-muted">Use role based credentials to enter the virtual exam hall.</p>
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email', 'admin@vexam.test') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" value="password" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button class="btn btn-primary w-100">Login</button>
                </form>
                <hr>
                <p class="mb-0">New student? <a href="{{ route('register') }}">Register here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
