<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function editCommission()
    {
        $rate = Setting::get('commission_rate', '0.10');

        return view('admin.settings.commission', compact('rate'));
    }

    public function updateCommission(Request $request)
    {
        $data = $request->validate([
            'commission_rate' => ['required', 'numeric', 'min:0', 'max:1'],
        ]);

        Setting::set('commission_rate', (string) $data['commission_rate']);

        return redirect()
            ->route('admin.settings.commission')
            ->with('status', 'Commission updated.');
    }
}

