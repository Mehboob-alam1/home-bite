@extends('admin.layout')

@section('title', 'Complaints')

@section('content')
    <h1 class="mb-4">Complaints</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Created</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($complaints as $complaint)
            <tr>
                <td>{{ $complaint->id }}</td>
                <td>{{ $complaint->user?->name }}</td>
                <td>{{ $complaint->subject }}</td>
                <td>{{ ucfirst($complaint->status) }}</td>
                <td>{{ $complaint->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-primary">
                        View
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $complaints->links() }}
@endsection

