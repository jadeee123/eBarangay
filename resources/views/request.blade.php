@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/request.css') }}">
@endpush

@section('title', 'Submit Request - eBarangay')

@section('content')

<div class="submit-request-page">

<h2>Submit a Request</h2>
    <p>Choose a service and fill out the the form. Make sure your information is correct
        before submitting.</p>
        
        <div class="services-grid">

            @foreach ($services as $service)
                <a href="{{ route('requests.create', ['service' => $service->name]) }}"
                   class="service-card">

                    <div class="service-icon">
                        <i class="bx bx-file"></i>
                    </div>

                    <h3>{{ $service->name }}</h3>

                    <p>{{ $service->description ?: 'Barangay service request.' }}</p>

                    <span>→</span>
                </a>
            @endforeach

        </div>
</div>
@endsection
