<h1>Result Notification</h1>
<p>Hello {{ $student->name }}, your result for {{ $result->exam->title }} is published.</p>
<p>Marks: {{ $result->obtained_marks }} / {{ $result->total_marks }}</p>
<p>Status: {{ ucfirst($result->status) }}</p>
