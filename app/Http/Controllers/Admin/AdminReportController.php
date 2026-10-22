<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function sales(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $query = Order::with('user')->where('status', 'completed');

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->orderByDesc('created_at')->paginate(20);
        $totalAmount = $query->clone()->sum('total_amount');
        $totalCommission = $query->clone()->sum('commission_amount');

        return view('admin.reports.sales', [
            'orders' => $orders,
            'totalAmount' => $totalAmount,
            'totalCommission' => $totalCommission,
            'from' => $from,
            'to' => $to,
        ]);
    }
}

