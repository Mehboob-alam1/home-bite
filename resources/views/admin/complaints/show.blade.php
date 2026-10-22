@extends('admin.layout')

@section('title', 'Complaint #'.$complaint->id)

@section('content')
    <h1 class="mb-4">Complaint #{{ $complaint->id }}</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="mb-3">
        <strong>User:</strong> {{ $complaint->user?->name }} ({{ $complaint->user?->email }})
    </div>
    <div class="mb-3">
        <strong>Subject:</strong> {{ $complaint->subject }}
    </div>
    <div class="mb-3">
        <strong>Message:</strong><br>
        {{ $complaint->message }}
    </div>
    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($complaint->status) }}
    </div>
    <div class="mb-3">
        <strong>Admin Reply:</strong><br>
        {{ $complaint->admin_reply ?? '—' }}
    </div>

    <form method="POST" action="{{ route('admin.complaints.update', $complaint) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                @foreach(['open' => 'Open', 'in_progress' => 'In Progress', 'closed' => 'Closed'] as $key => $label)
                    <option value="{{ $key }}" @selected($complaint->status === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Admin Reply</label>
            <textarea name="admin_reply" class="form-control" rows="3">{{ old('admin_reply', $complaint->admin_reply) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection

