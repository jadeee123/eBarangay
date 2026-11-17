
@extends('layouts.dashstaff')

@section('title', 'Resident Details - eBarangay')
@section('page-heading', 'Resident Details')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff/residents.css') }}">
@endpush

@section('content')
<section class="residents-page">
    <div class="residents-heading">
        <div>
            <h2>Resident Details</h2>
            <p>Registered account information.</p>
        </div>

        <a class="resident-view-btn" href="{{ route('staff.residents') }}">
            <i class="bx bx-arrow-back"></i> Back to Residents
        </a>
    </div>

    <section class="residents-panel resident-details">
        <p><strong>Resident ID:</strong>
            RES-{{ str_pad($resident->id, 3, '0', STR_PAD_LEFT) }}
        </p>

        <p><strong>Full Name:</strong> {{ $resident->name }}</p>
        <p><strong>Email:</strong> {{ $resident->email }}</p>
        <p><strong>Contact Number:</strong> {{ $resident->contact_number ?? 'Not provided' }}</p>
        <p><strong>Date Registered:</strong>
            {{ $resident->created_at
                ? \Carbon\Carbon::parse($resident->created_at)->format('F d, Y')
                : '—' }}
        </p>
        <p><strong>Account Status:</strong>
            {{ $resident->verification_status ?? 'Pending' }}
        </p>
    </section>
</section>
@endsection
