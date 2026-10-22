<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $userCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');

        $latestUsers = User::latest()->take(5)->get();
        $latestProducts = Product::latest()->take(5)->get();
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'userCounts' => $userCounts,
            'latestUsers' => $latestUsers,
            'latestProducts' => $latestProducts,
            'latestOrders' => $latestOrders,
        ]);
    }
}

