<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $data = $request->validate([
            'order_id' => ['nullable', 'integer', 'exists:orders,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        $complaint = Complaint::create([
            'user_id' => $user->id,
            'order_id' => $data['order_id'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => 'open',
        ]);

        return response()->json($complaint, 201);
    }

    public function myComplaints(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $complaints = Complaint::where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json($complaints);
    }
}

