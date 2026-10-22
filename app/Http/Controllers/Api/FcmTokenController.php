<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $data = $request->validate([
            'token' => ['required', 'string'],
        ]);

        FcmToken::updateOrCreate(
            ['token' => $data['token']],
            ['user_id' => $user->id],
        );

        return response()->json(['status' => 'ok']);
    }
}

