@extends('admin.layout')

@section('title', 'Sales Report')

@section('content')
    <h1 class="mb-4">Sales Report</h1>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">From</label>
            <input type="date" name="from" value="{{ $from }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">To</label>
            <input type="date" name="to" value="{{ $to }}" class="form-control">
        </div>
        <div class="col-md-3 align-self-end">
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
    </form>

    <div class="mb-3">
        <strong>Total Sales:</strong> {{ $totalAmount }}<br>
        <strong>Total Commission:</strong> {{ $totalCommission }}
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Buyer</th>
            <th>Total</th>
            <th>Commission</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user?->name }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->commission_amount }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
@endsection

