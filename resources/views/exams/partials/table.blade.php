<div class="table-responsive">
    <table class="table align-middle">
        <thead>
        <tr>
            <th>Title</th>
            <th>Subject</th>
            <th>Faculty</th>
            <th>Start</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($exams as $exam)
            <tr>
                <td>{{ $exam->title }}</td>
                <td>{{ $exam->subject->name ?? '-' }}</td>
                <td>{{ $exam->faculty->name ?? '-' }}</td>
                <td>{{ optional($exam->start_time)->format('d M Y H:i') }}</td>
                <td><span class="badge bg-{{ $exam->is_active ? 'success' : 'secondary' }}">{{ $exam->is_active ? 'Active' : 'Inactive' }}</span></td>
                <td>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('exams.show', $exam) }}">View</a>
                    @if(auth()->user()?->role === 'admin')
                        <form class="d-inline" method="POST" action="{{ route('admin.exams.toggle', $exam) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-outline-warning">Toggle</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted">No exams found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ method_exists($exams, 'links') ? $exams->links() : '' }}
