<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffReportsController extends Controller
{
    
public function index(\Illuminate\Http\Request $request)
{
    $period = (int) $request->query('period', 30);

    if (!in_array($period, [7, 30, 90], true)) {
        $period = 30;
    }

    $startDate = now()->subDays($period - 1)->startOfDay();

    // Request trends by day
    $requestTrends = \Illuminate\Support\Facades\DB::table('requests')
        ->selectRaw("TO_CHAR(created_at, 'YYYY-MM-DD') as day, COUNT(*) as total")
        ->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', now())
        ->groupByRaw("TO_CHAR(created_at, 'YYYY-MM-DD')")
        ->orderBy('day')
        ->get();

    // Request totals grouped by service
    $topServices = \Illuminate\Support\Facades\DB::table('requests')
        ->select('service_name')
        ->selectRaw('COUNT(*) as total')
        ->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', now())
        ->groupBy('service_name')
        ->orderByDesc('total')
        ->get();

    $totalRequests = \Illuminate\Support\Facades\DB::table('requests')
        ->where('created_at', '>=', $startDate)
        ->where('created_at', '<=', now())
        ->count();

    return view('staff.reports', compact(
        'period',
        'requestTrends',
        'topServices',
        'totalRequests'
    ));
}

 public function export()
    {
        $filename = 'ebarangay-requests-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Request ID',
                'Resident ID',
                'Service',
                'Status',
                'Claim Date',
                'Date Submitted',
            ]);

            DB::table('requests')
                ->select(
                    'id',
                    'user_id',
                    'service_name',
                    'status',
                    'claim_date',
                    'created_at'
                )
                ->orderBy('created_at', 'desc')
                ->chunk(500, function ($requests) use ($handle) {
                    foreach ($requests as $request) {
                        fputcsv($handle, [
                            $request->id,
                            $request->user_id,
                            $request->service_name,
                            $request->status,
                            $request->claim_date,
                            $request->created_at,
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
