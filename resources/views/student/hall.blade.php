@extends('layouts.master')

@section('title', 'Virtual Exam Hall')

@section('content')
<div class="exam-shell p-4 rounded">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">{{ $exam->title }}</h1>
            <div class="text-info">{{ $exam->subject->name ?? '-' }} | Room {{ $exam->room_code }}</div>
        </div>
        <div>
            <span class="badge bg-warning text-dark me-2">Violations: <span id="violationCount">{{ session('violation_count', 0) }}</span></span>
            <span class="badge bg-success fs-6" id="timer">{{ $exam->duration_minutes }}:00</span>
            <button class="btn btn-outline-light btn-sm ms-2" id="fullscreenBtn" type="button">Fullscreen</button>
        </div>
    </div>

    <div class="alert alert-info">
        Proctoring is active: tab switching, fullscreen exits, mouse inactivity, copy-paste, right click, restricted keys, and webcam snapshots are monitored.
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('student.exam.submit', $exam) }}" id="examForm">
                @csrf
                @foreach($exam->questions as $question)
                    <div class="card bg-dark text-light border-secondary mb-3">
                        <div class="card-body">
                            <h2 class="h6">{{ $question->sequence }}. {{ $question->question_text }}</h2>
                            @if($question->question_type === 'mcq')
                                @foreach(($question->options ?? []) as $option)
                                    @if($option)
                                        <label class="form-check">
                                            <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}">
                                            <span class="form-check-label">{{ $option }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            @else
                                <textarea class="form-control" name="answers[{{ $question->id }}]" rows="4" placeholder="Type your answer"></textarea>
                            @endif
                        </div>
                    </div>
                @endforeach
                <button class="btn btn-success btn-lg">Submit Exam</button>
            </form>
        </div>
        <div class="col-lg-4">
            <div class="card bg-dark text-light border-secondary">
                <div class="card-body">
                    <h2 class="h5">Webcam Proctor</h2>
                    <video id="webcam" autoplay muted playsinline></video>
                    <canvas id="snapshotCanvas" class="d-none"></canvas>
                    <p class="small text-info mt-2">Snapshots are sent to the MongoDB-backed camera log collection when MongoDB is available.</p>
                    <div id="warningBox" class="alert alert-warning d-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const examId = @json($exam->id);
    const studentId = @json($student->id);
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const warningBox = document.getElementById('warningBox');
    const violationCount = document.getElementById('violationCount');
    let seconds = {{ $exam->duration_minutes }} * 60;
    let inactiveSeconds = 0;

    function warn(message) {
        warningBox.textContent = message;
        warningBox.classList.remove('d-none');
        setTimeout(() => warningBox.classList.add('d-none'), 5000);
    }

    async function logViolation(type, description) {
        const response = await fetch('{{ route('proctoring.violation') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json'},
            body: JSON.stringify({student_id: studentId, exam_id: examId, violation_type: type, description})
        });
        if (response.ok) {
            const payload = await response.json();
            violationCount.textContent = payload.violation_count;
            warn(payload.warning);
        }
    }

    document.getElementById('fullscreenBtn').addEventListener('click', () => {
        document.documentElement.requestFullscreen?.();
    });

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) logViolation('tab_switch', 'Student switched browser tab or minimized the window.');
    });

    document.addEventListener('fullscreenchange', () => {
        if (!document.fullscreenElement) logViolation('fullscreen_exit', 'Student exited fullscreen mode.');
    });

    document.addEventListener('contextmenu', event => {
        event.preventDefault();
        logViolation('right_click', 'Right click was blocked during exam.');
    });

    document.addEventListener('copy', event => {
        event.preventDefault();
        logViolation('copy_blocked', 'Copy action was attempted.');
    });

    document.addEventListener('paste', event => {
        event.preventDefault();
        logViolation('paste_blocked', 'Paste action was attempted.');
    });

    document.addEventListener('keydown', event => {
        const key = event.key.toLowerCase();
        if (event.key === 'F12' || (event.ctrlKey && ['c', 'v'].includes(key)) || (event.ctrlKey && event.shiftKey && key === 'i') || (event.altKey && key === 'tab')) {
            event.preventDefault();
            logViolation('restricted_key', `Restricted shortcut attempted: ${event.key}`);
        }
    });

    ['mousemove', 'keydown', 'click'].forEach(name => document.addEventListener(name, () => inactiveSeconds = 0));

    setInterval(() => {
        inactiveSeconds += 10;
        if (inactiveSeconds >= 60) {
            logViolation('mouse_inactivity', 'No mouse or keyboard activity detected for 60 seconds.');
            inactiveSeconds = 0;
        }
    }, 10000);

    setInterval(() => {
        seconds--;
        const minutes = Math.floor(seconds / 60);
        const remainder = String(seconds % 60).padStart(2, '0');
        document.getElementById('timer').textContent = `${minutes}:${remainder}`;
        if (seconds <= 0) document.getElementById('examForm').submit();
    }, 1000);

    async function startCamera() {
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('snapshotCanvas');
        try {
            video.srcObject = await navigator.mediaDevices.getUserMedia({video: true, audio: false});
            setInterval(() => {
                if (!video.videoWidth) return;
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                canvas.toBlob(blob => {
                    const data = new FormData();
                    data.append('student_id', studentId);
                    data.append('exam_id', examId);
                    data.append('image', blob, `snapshot-${Date.now()}.jpg`);
                    fetch('{{ route('proctoring.snapshot') }}', {method: 'POST', headers: {'X-CSRF-TOKEN': csrf, 'Accept': 'application/json'}, body: data});
                }, 'image/jpeg', .7);
            }, 30000);
        } catch (error) {
            logViolation('camera_denied', 'Webcam permission was denied or unavailable.');
        }
    }

    startCamera();
})();
</script>
@endpush
