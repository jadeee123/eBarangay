<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffAnnouncementController extends Controller
{
    private function checkStaff(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'staff',
            403
        );
    }

    public function index()
    {
        $this->checkStaff();

        $announcements = DB::table('announcements')
            ->orderByDesc('created_at')
            ->get();

        return view('staff.announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $this->checkStaff();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $publish = $request->boolean('is_published');

        DB::table('announcements')->insert([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $publish,
            'published_at' => $publish ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Announcement created successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->checkStaff();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $announcement = DB::table('announcements')
            ->where('id', $id)
            ->first();

        abort_unless($announcement, 404);

        $publish = $request->boolean('is_published');

        DB::table('announcements')
            ->where('id', $id)
            ->update([
                'title' => $validated['title'],
                'content' => $validated['content'],
                'is_published' => $publish,
                'published_at' => $publish
                    ? ($announcement->published_at ?? now())
                    : null,
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Announcement updated successfully.');
    }

    public function destroy($id)
    {
        $this->checkStaff();

        DB::table('announcements')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Announcement deleted.');
    }
}
