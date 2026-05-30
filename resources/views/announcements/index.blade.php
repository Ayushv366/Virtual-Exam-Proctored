@extends('layouts.master')

@section('title', 'Announcements')

@section('content')
<h1 class="h3 mb-3">Send Announcements</h1>
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card card-metric">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.announcements.store') }}">
                    @csrf
                    <label class="form-label">Title</label>
                    <input class="form-control mb-2" name="title" value="{{ old('title') }}" required>
                    <label class="form-label">Audience</label>
                    <select class="form-select mb-2" name="audience">
                        <option value="all">All</option>
                        <option value="students">Students</option>
                        <option value="faculty">Faculty</option>
                    </select>
                    <label class="form-label">Publish At</label>
                    <input class="form-control mb-2" type="datetime-local" name="publish_at" value="{{ old('publish_at') }}">
                    <label class="form-label">Message</label>
                    <textarea class="form-control mb-2" name="message" rows="4" required>{{ old('message') }}</textarea>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                    <button class="btn btn-primary">Publish</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card card-metric">
            <div class="card-body">
                @foreach($announcements as $announcement)
                    <div class="border-bottom py-2">
                        <strong>{{ $announcement->title }}</strong>
                        <span class="badge bg-info">{{ $announcement->audience }}</span>
                        <p class="mb-0">{{ $announcement->message }}</p>
                    </div>
                @endforeach
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
