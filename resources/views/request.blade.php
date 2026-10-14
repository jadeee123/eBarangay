@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/request.css') }}">
@endpush

@section('title', 'Dashboard - eBarangay')

@section('content')

<div class="submit-request-page">

<h2>Submit a Request</h2>
    <p>Choose a service and fill out the the form. Make sure your information is correct
        before submitting.</p>

        <div class="services-grid">
            <a href="{{ route('requests.create', ['service' => 'barangay-clearance']) }}" class="service-card">
                <div class="service-icon">📄</div>
                <h3>Barangay Clearance</h3>
                <p>Get a barangay clearance for various purposes.</p>
                <span>→</span>
            </a>

            <a href="{{ route('requests.create', ['service' => 'scholarship-application']) }}" class="service-card">
                <div class="service-icon">📄</div>
                <h3>Scholarship Application</h3>
                <p>Apply for educational assistance.</p>
                <span>→</span>
            </a>

            <a href="{{ route('requests.create', ['service' => 'certificate-indigency']) }}" class="service-card">
                <div class="service-icon">📄</div>
                <h3>Certificate of Indigency</h3>
                <p>Get certificate of indigency for financial assistance.</p>
                <span>→</span>
            </a>

            <a href="{{ route('requests.create', ['service' => 'business-clearance']) }}" class="service-card">
                <div class="service-icon">📄</div>
                <h3>Business Clearance</h3>
                <p>Request clearance for eligible businesses operating.</p>
                <span>→</span>
            </a>

            <a href="{{ route('requests.create', ['service' => 'other-services']) }}" class="service-card">
                <div class="service-icon">📄</div>
                <h3>Other Services</h3>
                <p>Other barangay services.</p>
                <span>→</span>
            </a>
        </div>
</div>
@endsection