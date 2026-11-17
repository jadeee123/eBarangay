<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function residents()
{
    $residents = \Illuminate\Support\Facades\DB::table('users')
        ->select('id', 'name', 'email', 'created_at')
        ->orderBy('name')
        ->get();

    return view('staff.residents', compact('residents'));
}
}
