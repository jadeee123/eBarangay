<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestFeedbackController extends Controller
{
    public function store(Request $request, $requestId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $serviceRequest = DB::table('requests')
            ->where('id', $requestId)
            ->where('user_id', Auth::id())
            ->where('status', 'Completed')
            ->first();

        if (!$serviceRequest) {
            return back()->with(
                'error',
                'Feedback is only available for your completed requests.'
            );
        }

        $existingFeedback = DB::table('request_feedback')
            ->where('request_id', $requestId)
            ->exists();

        if ($existingFeedback) {
            return back()->with(
                'error',
                'You have already submitted feedback for this request.'
            );
        }

        DB::table('request_feedback')->insert([
            'request_id' => $requestId,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with(
            'success',
            'Thank you for your feedback!'
        );
    }
}
