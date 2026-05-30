<h1>Exam Reminder</h1>
<p>Hello {{ $student->name }}, this is a reminder for {{ $exam->title }}.</p>
<p>Start Time: {{ $exam->start_time->format('d M Y H:i') }}</p>
<p>Room Code: {{ $exam->room_code }}</p>
