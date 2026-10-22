<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('user', 'order');

        return view('admin.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $data = $request->validate([
            'status' => ['required', 'in:open,in_progress,closed'],
            'admin_reply' => ['nullable', 'string'],
        ]);

        $complaint->update($data);

        return redirect()
            ->route('admin.complaints.show', $complaint)
            ->with('status', 'Complaint updated.');
    }
}

