
@extends('layouts.dashboard')

@section('title', 'Request Form - eBarangay')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/request-form.css') }}">
@endpush

@section('content')

@php
    $services = [
        'barangay-clearance' => 'Barangay Clearance',
        'scholarship-application' => 'Scholarship Application',
        'certificate-indigency' => 'Certificate of Indigency',
        'business-clearance' => 'Business Clearance',
        'other-services' => 'Other Services',
    ];

    $selectedService = request('service', 'barangay-clearance');
@endphp

<div class="request-form-page">

    <div class="request-page-heading">
        <a href="{{ url('/request') }}" class="back-link">
            <i class="bx bx-arrow-back"></i>
            Back to Services
        </a>

        <h1>Request Form</h1>
        <p>Complete the information below to submit your barangay service request.</p>
    </div>

    <form class="request-form" id="requestForm">

        <section class="form-section selected-service">
            <div class="section-heading">
                <div class="section-icon">
                    <i class="bx bx-file"></i>
                </div>
                <div>
                    <h2>Selected Service</h2>
                    <p>Check the service you want to request.</p>
                </div>
            </div>

            <label for="service">Barangay Service <span>*</span></label>
            <select name="service" id="service" required>
                @foreach ($services as $value => $label)
                    <option value="{{ $value }}"
                        {{ $selectedService === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </section>

        <section class="form-section">
            <div class="section-heading">
                <div class="section-icon">
                    <i class="bx bx-user"></i>
                </div>
                <div>
                    <h2>Resident Information</h2>
                    <p>Provide your personal information.</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="full_name">Full Name <span>*</span></label>
                    <input type="text" id="full_name" name="full_name"
                        placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="birth_date">Date of Birth <span>*</span></label>
                    <input type="date" id="birth_date" name="birth_date" required>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number <span>*</span></label>
                    <input type="tel" id="contact_number" name="contact_number"
                        placeholder="e.g. 09XXXXXXXXX" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                        placeholder="Enter your email address">
                </div>

                <div class="form-group full-width">
                    <label for="address">Complete Address <span>*</span></label>
                    <textarea id="address" name="address" rows="3"
                        placeholder="House number, street, and barangay"
                        required></textarea>
                </div>
            </div>
        </section>

        <section class="form-section">
            <div class="section-heading">
                <div class="section-icon">
                    <i class="bx bx-detail"></i>
                </div>
                <div>
                    <h2>Request Details</h2>
                    <p>Tell us why you need this service.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="purpose">Purpose of Request <span>*</span></label>
                <input type="text" id="purpose" name="purpose"
                    placeholder="e.g. Employment, school requirement"
                    required>
            </div>

            <div class="form-group">
                <label for="details">Additional Information</label>
                <textarea id="details" name="details" rows="4"
                    placeholder="Enter any additional information (optional)"></textarea>
            </div>

            <div class="form-group">
                <label for="document">Supporting Document</label>
                <input type="file" id="document" name="document"
                    accept=".pdf,.jpg,.jpeg,.png">
                <small>Optional. Accepted formats: PDF, JPG, and PNG.</small>
            </div>
        </section>

        <div class="form-notice">
            <i class="bx bx-info-circle"></i>
            <p>Please check your information before submitting your request.</p>
        </div>

        <div class="form-actions">
            <a href="{{ url('/request') }}" class="cancel-btn">Cancel</a>
            <button type="submit" class="submit-btn">
                <i class="bx bx-send"></i>
                Submit Request
            </button>
        </div>

    </form>
</div>

@endsection
