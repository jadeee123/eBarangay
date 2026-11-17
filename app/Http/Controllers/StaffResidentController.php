<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StaffResidentController extends Controller
{

public function residents()
{
    $residents = DB::table('users')
        ->select('id', 'name', 'email', 'created_at')
        ->orderBy('name')
        ->get();

    return view('staff.residents', compact('residents'));
}
}