@extends('admin.layout')

@section('title', 'Commission')

@section('content')
    <h1 class="mb-4">Commission Settings</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.commission.update') }}" class="col-md-4">
        @csrf
        <div class="mb-3">
            <label class="form-label">Commission Rate (0 – 1)</label>
            <input type="number" step="0.01" min="0" max="1"
                   name="commission_rate"
                   value="{{ old('commission_rate', $rate) }}"
                   class="form-control" required>
            <div class="form-text">Example: 0.10 = 10%</div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection

