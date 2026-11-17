<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffRequestController extends Controller
{
    public function incoming()
    {
        $requests = DB::table('requests')
            ->leftJoin('users', 'users.id', '=', 'requests.user_id')
            ->select(
                'requests.id',
                'requests.service_name',
                'requests.status',
                'requests.created_at',
                'users.name as resident_name'
            )
            ->whereRaw('LOWER(requests.status) = ?', ['pending'])
            ->orderByDesc('requests.created_at')
            ->get();

        $pendingCount = $requests->count();

        return view('staff.incoming', compact(
            'requests',
            'pendingCount'
        ));
    }


    public function allRequests()
{
    $requests = DB::table('requests')
        ->leftJoin('users', 'users.id', '=', 'requests.user_id')
        ->select(
            'requests.id',
            'requests.service_name',
            'requests.status',
            'requests.created_at',
            'users.name as resident_name'
        )
        ->orderByDesc('requests.created_at')
        ->get();

    return view('staff.all-requests', compact('requests'));
}


public function show($id)
{
    $request = DB::table('requests')
        ->leftJoin('users', 'requests.user_id', '=', 'users.id')
        ->select('requests.*', 'users.name as resident_name')
        ->where('requests.id', $id)
        ->first();

    if (!$request) {
        abort(404, 'Request not found.');
    }

    return view('staff.request-details', compact('request'));
}



public function updateStatus(Request $request, $id)
{
    $validated = $request->validate([
        'status' => ['required', 'in:Pending,Processing,Approved,Completed,Rejected'],
        'claim_date' => ['nullable', 'date'],
    ]);

    // Find the request and its owner
    $residentRequest = DB::table('requests')
        ->where('id', $id)
        ->first();

    if (!$residentRequest) {
        abort(404, 'Request not found.');
    }

    // Check whether anything actually changed
    $statusChanged = $residentRequest->status !== $validated['status'];

    $newClaimDate = $validated['claim_date'] ?? null;
    $oldClaimDate = $residentRequest->claim_date;

    $claimDateChanged = $oldClaimDate !== $newClaimDate;

    // Update the request
    DB::table('requests')
        ->where('id', $id)
        ->update([
            'status' => $validated['status'],
            'claim_date' => $newClaimDate,
            'updated_at' => now(),
        ]);

    // Notify the resident when the status or claim date changes
    if ($statusChanged || $claimDateChanged) {
        $message = "Your {$residentRequest->service_name} request has been updated.";

        if ($statusChanged) {
            $message .= " New status: {$validated['status']}.";
        }

        if ($claimDateChanged && $newClaimDate) {
            $message .= ' Claim date: ' .
                \Carbon\Carbon::parse($newClaimDate)->format('F j, Y') . '.';
        } elseif ($claimDateChanged) {
            $message .= ' Your claim date has been removed.';
        }

        DB::table('resident_notifications')->insert([
            'user_id' => $residentRequest->user_id,
            'request_id' => $residentRequest->id,
            'title' => 'Request Updated',
            'message' => $message,
            'type' => 'request_status',
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()
        ->route('staff.requests.show', $id)
        ->with('success', 'Request status and claim date updated successfully.');
}
}