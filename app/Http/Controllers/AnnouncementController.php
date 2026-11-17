<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcement = DB::table('announcements')
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->first();

        return view('dashboard', compact('announcement'));
    }
}