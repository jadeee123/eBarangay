
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
                        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=Brgy.Cuambugan@gmail.com"
                           target="_blank"
                           rel="noopener noreferrer">
                            Brgy.Cuambugan@gmail.com
                        </a>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="detail-icon">
                        <i class="bx bx-map"></i>
                    </div>

                    <div>
                        <h3>Office Location</h3>
                        <p>Bgry. Cuambugan, Tagum City</p>
                    </div>
                </div>

            </div>
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

            <!-- Button to open the pop-up -->
            <button type="button"
                    class="message-button"
                    id="openContactForm">
                <i class="bx bx-send"></i>
                Send Message
            </button>

        </section>

    </div>
</div>

<!-- Contact Form Pop-up -->
<div class="contact-modal" id="contactModal"
     aria-hidden="true">

    <div class="contact-modal-content"
         role="dialog"
         aria-modal="true"
         aria-labelledby="contactModalTitle">

        <button type="button"
                class="contact-modal-close"
                id="closeContactForm"
                aria-label="Close form">
            &times;
        </button>

        <h2 id="contactModalTitle">Send Us a Message</h2>
        <p class="contact-modal-intro">
            Tell us how we can help you.
        </p>

        @if (session('success'))
            <div class="contact-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('mail_error'))
        <div class="contact-errors">
            {{ session('mail_error') }}
        </div>
        @endif

        @if ($errors->any())
            <div class="contact-errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('contact-messages.store') }}"
              method="POST">
            @csrf

            <div class="form-group">
                <label for="contact_name">Your Name</label>
                <input type="text"
                       id="contact_name"
                       name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       required>
            </div>

            <div class="form-group">
                <label for="contact_email">Your Email</label>
                <input type="email"
                       id="contact_email"
                       name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       required>
            </div>

            <div class="form-group">
                <label for="contact_subject">Subject</label>
                <input type="text"
                       id="contact_subject"
                       name="subject"
                       value="{{ old('subject') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="contact_message">Your Message</label>
                <textarea id="contact_message"
                          name="message"
                          rows="4"
                          required>{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="message-button">
                <i class="bx bx-send"></i>
                Submit Message
            </button>
        </form>

    </div>
</div>
<!-- test -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('contactModal');
    const openButton = document.getElementById('openContactForm');
    const closeButton = document.getElementById('closeContactForm');

    function openModal() {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    }

    openButton.addEventListener('click', openModal);
    closeButton.addEventListener('click', closeModal);

    // Close when clicking outside the form
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close with the Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('show')) {
            closeModal();
        }
    });

    // Reopen the form if validation errors or a success message exist
    @if ($errors->any() || session('success') || session('mail_error'))
    openModal();
    @endif
});
</script>

@endsection
