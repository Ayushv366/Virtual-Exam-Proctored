<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Title</label>
        <input class="form-control" name="title" value="{{ old('title', $exam->title ?? '') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Subject</label>
        <select class="form-select" name="subject_id" required>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" @selected(old('subject_id', $exam->subject_id ?? '') == $subject->id)>{{ $subject->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Faculty</label>
        <select class="form-select" name="faculty_id" required>
            @foreach($facultyMembers as $faculty)
                <option value="{{ $faculty->id }}" @selected(old('faculty_id', $exam->faculty_id ?? '') == $faculty->id)>{{ $faculty->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Start Time</label>
        <input class="form-control" type="datetime-local" name="start_time" value="{{ old('start_time', isset($exam) ? $exam->start_time?->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">End Time</label>
        <input class="form-control" type="datetime-local" name="end_time" value="{{ old('end_time', isset($exam) ? $exam->end_time?->format('Y-m-d\TH:i') : '') }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Duration</label>
        <input class="form-control" type="number" name="duration_minutes" value="{{ old('duration_minutes', $exam->duration_minutes ?? 60) }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Total</label>
        <input class="form-control" type="number" name="total_marks" value="{{ old('total_marks', $exam->total_marks ?? 100) }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Passing</label>
        <input class="form-control" type="number" name="passing_marks" value="{{ old('passing_marks', $exam->passing_marks ?? 40) }}" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Room Code</label>
        <input class="form-control" name="room_code" value="{{ old('room_code', $exam->room_code ?? 'ROOM'.random_int(100,999)) }}" required>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $exam->is_active ?? true))>
            <label class="form-check-label">Activate exam</label>
        </div>
    </div>
    <div class="col-12">
        <label class="form-label">Instructions</label>
        <textarea class="form-control" name="instructions" rows="3">{{ old('instructions', $exam->instructions ?? '') }}</textarea>
    </div>
</div>
<hr>
