<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffServicesController extends Controller
{
    
public function index()
{
    $services = \Illuminate\Support\Facades\DB::table('services')
        ->orderBy('name')
        ->get();

    return view('staff.services', compact('services'));
}

public function store(\Illuminate\Http\Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'requirements' => 'nullable|string',
    ]);

    \Illuminate\Support\Facades\DB::table('services')->insert([
        'name' => $validated['name'],
        'description' => $validated['description'] ?? null,
        'requirements' => $validated['requirements'] ?? null,
        'is_active' => true,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('staff.services.index')
        ->with('success', 'Service added successfully.');
}

public function edit($id)
{
    $service = \Illuminate\Support\Facades\DB::table('services')
        ->where('id', $id)
        ->first();

    abort_if(!$service, 404);

    return view('staff.services-edit', compact('service'));
}

public function update(\Illuminate\Http\Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'requirements' => 'nullable|string',
        'is_active' => 'required|boolean',
    ]);

    \Illuminate\Support\Facades\DB::table('services')
        ->where('id', $id)
        ->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'is_active' => $validated['is_active'],
            'updated_at' => now(),
        ]);

    return redirect()->route('staff.services.index')
        ->with('success', 'Service updated successfully.');
}

}
