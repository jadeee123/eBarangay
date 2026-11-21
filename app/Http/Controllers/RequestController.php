<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class RequestController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'service' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'age' => ['required', 'integer', 'min:0', 'max:120'],
            'gender' => 'required|in:Male,Female',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:1000',
            'purpose' => 'required|string|max:255',
            'details' => 'nullable|string|max:2000',
            'documents' => 'nullable|array|max:3',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);
      
$documentPaths = [];

if ($request->hasFile('documents')) {
    foreach ($request->file('documents') as $file) {
        $filename = \Illuminate\Support\Str::uuid()
            . '.' . $file->extension();

        $path = 'supporting-documents/' . $filename;

        $url = rtrim(env('SUPABASE_URL'), '/')
            . '/storage/v1/object/ebarangay-documents/'
            . $path;

$response = Http::withHeaders([
    'apikey' => env('SUPABASE_SECRET_KEY'),
    'Content-Type' => $file->getMimeType(),
    'x-upsert' => 'false',
])->withBody(
    file_get_contents($file->getRealPath()),
    $file->getMimeType()
)->post($url);

        if ($response->failed()) {
            \Illuminate\Support\Facades\Log::error(
                'Supabase document upload failed',
                [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]
            );

            abort(
                500,
                'Supporting document upload failed. Please try again.'
            );
        }

        $documentPaths[] = $path;
    }
}


        DB::table('requests')->insert([
            'user_id' => Auth::id(),
            'service_name' => $validated['service'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'description' => $validated['purpose']
                . (!empty($validated['details'])
                    ? "\n" . $validated['details']
                    : ''),
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
            'full_name' => $validated['full_name'],
            'birth_date' => $validated['birth_date'],
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'],
            'purpose' => $validated['purpose'],
            'documents' => json_encode($documentPaths),
        ]);

        return redirect()
            ->route('requests.index')
            ->with('success', 'Your request was submitted successfully.');
    }

    public function index(Request $request)
{
    $requests = DB::table('requests')
    ->leftJoin('request_feedback', 'requests.id', '=', 'request_feedback.request_id')
    ->where('requests.user_id', Auth::id())
    ->select(
        'requests.*',
        'request_feedback.rating as feedback_rating',
        'request_feedback.comment as feedback_comment'
    )
    ->orderByDesc('requests.created_at')
    ->get();

    $filter = $request->query('filter', 'all');

    return view('my-request', compact('requests', 'filter'));
}

public function history()
{
    $requests = DB::table('requests')
        ->where('user_id', Auth::id())
        ->whereIn('status', ['Completed', 'Rejected'])
        ->orderByDesc('created_at')
        ->get();
    
    return view('request-history', compact('requests'));
}

public function dashboard()
{
    $userId = Auth::id();

    $unreadNotifications = DB::table('resident_notifications')
    ->where('user_id', $userId)
    ->where('is_read', false)
    ->count();

    $announcements = DB::table('announcements')
    ->where('is_published', true)
    ->whereNotNull('published_at')
    ->orderByDesc('published_at')
    ->limit(3)
    ->get();

    $totalRequests = DB::table('requests')
        ->where('user_id', $userId)
        ->count();

    $pendingRequests = DB::table('requests')
        ->where('user_id', $userId)
        ->where('status', 'Pending')
        ->count();

    $approvedRequests = DB::table('requests')
        ->where('user_id', $userId)
        ->where('status', 'Approved')
        ->count();

    $claimDates = DB::table('requests')
        ->where('user_id', $userId)
        ->whereNotNull('claim_date')
        ->count();

    $recentRequests = DB::table('requests')
        ->where('user_id', $userId)
        ->orderByDesc('created_at')
        ->limit(3)
        ->get();

    $dashboardNotifications = DB::table('resident_notifications')
    ->where('user_id', $userId)
    ->orderByDesc('created_at')
    ->limit(5)
    ->get();

    return view('dashboard', compact(
    'totalRequests',
    'pendingRequests',
    'approvedRequests',
    'claimDates',
    'recentRequests',
    'unreadNotifications',
    'dashboardNotifications',
    'announcements'
));
}

public function cancel($id)
{
    $requestRecord = \Illuminate\Support\Facades\DB::table('requests')
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->first();

    if (!$requestRecord) {
        abort(404, 'Request not found.');
    }

    if (strtolower($requestRecord->status) !== 'pending') {
        return back()->with(
            'error',
            'Only pending requests can be cancelled.'
        );
    }

    \Illuminate\Support\Facades\DB::table('requests')
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->whereRaw('LOWER(status) = ?', ['pending'])
        ->update([
            'status' => 'Cancelled',
            'updated_at' => now(),
        ]);

    return back()->with(
        'success',
        'Your request has been cancelled successfully.'
    );
}

}
