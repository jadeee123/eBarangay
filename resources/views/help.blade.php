@extends('layouts.dashboard')

@section('title', 'Need Help - eBarangay')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/help.css') }}">
@endpush

@section('content')
<div class="help-page">

    <div class="help-heading">
        <h1>Need Help?</h1>
        <p>
            We're here to assist you. You can reach out to the barangay office
            for any inquiries or concerns.
        </p>
    </div>

    <div class="help-grid">

        <section class="contact-card">
            <div class="contact-icon">
                <i class="bx bx-headphone"></i>
            </div>

            <h2>Barangay Contact</h2>
            <p class="contact-description">
                Feel free to contact us through the details below.
            </p>

            <div class="contact-details">

                <div class="contact-item">
                    <div class="detail-icon">
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div>
                        <h3>Email</h3>
                        <a href="mailto:barangay@example.com">
                            barangay@example.com
                        </a>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="detail-icon">
                        <i class="bx bx-map"></i>
                    </div>
                    <div>
                        <h3>Office Address</h3>
                        <p>Visit your local barangay office for assistance.</p>
                    </div>
                </div>

            </div>

            <a href="mailto:barangay@example.com" class="contact-button">
                <i class="bx bx-send"></i>
                Contact Barangay
            </a>
        </section>

        <section class="message-card">
            <div class="message-heading">
                <div class="message-icon">
                    <i class="bx bx-message-rounded-dots"></i>
                </div>
                <h2>We're Here to Help</h2>
            </div>

            <p class="message-intro">
                Have a question about your barangay service request?
            </p>

            <ul class="help-list">
                <li>
                    <i class="bx bx-check-circle"></i>
                    <span>Need assistance using eBarangay?</span>
                </li>
                <li>
                    <i class="bx bx-check-circle"></i>
                    <span>Send us a message and let us know how we can help.</span>
                </li>
            </ul>

            <div class="message-note">
                <i class="bx bx-info-circle"></i>
                <p>
                    Our contact email is available for your questions
                    and concerns.
                </p>
            </div>

            <a href="mailto:barangay@example.com" class="message-button">
                <i class="bx bx-send"></i>
                Send Message
            </a>
        </section>

    </div>
</div>
@endsection
