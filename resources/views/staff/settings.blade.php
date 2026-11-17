@extends('layouts.dashstaff')

@section('title', 'Staff Settings - eBarangay')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/settings.css') }}">
@endpush

@section('content')
@php
    $currentUser = auth()->user();
@endphp

<div class="staff-settings-page">

    <header class="settings-heading">
        <div>
            <h1>Settings</h1>
            <p>Manage your staff account and barangay preferences.</p>
        </div>
    </header>

    @if (session('success'))
        <div class="settings-alert success" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="settings-alert error" role="alert">
            <strong>Please correct the following:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-layout">

        <nav class="settings-nav" aria-label="Settings sections">
            <button type="button" class="settings-tab active"
                data-panel="profile" aria-selected="true">
                <i class="bx bx-user"></i>
                <span>Staff Profile</span>
            </button>

            <button type="button" class="settings-tab"
                data-panel="security" aria-selected="false">
                <i class="bx bx-lock-alt"></i>
                <span>Account &amp; Security</span>
            </button>

            <button type="button" class="settings-tab"
                data-panel="notifications" aria-selected="false">
                <i class="bx bx-bell"></i>
                <span>Notifications</span>
            </button>

            <button type="button" class="settings-tab"
                data-panel="barangay" aria-selected="false">
                <i class="bx bx-building-house"></i>
                <span>Barangay Information</span>
            </button>
        </nav>

        <div class="settings-content">

            {{-- STAFF PROFILE --}}
            <section class="settings-panel active" id="panel-profile">
                <div class="settings-panel-heading">
                    <h2>Staff Profile</h2>
                    <p>Manage the shared staff account information.</p>
                </div>

                <div class="staff-account-banner">
                    <div class="staff-avatar">
                        <i class="bx bx-shield-quarter"></i>
                    </div>
                    <div>
                        <h3>Barangay Staff Account</h3>
                        <span>Admin Staff</span>
                    </div>
                </div>

                <form method="POST"
                    action="{{ route('staff.settings.profile') }}">
                    @csrf
                    @method('PATCH')

                    <div class="settings-form-grid">
                        <div class="settings-field">
                            <label for="name">Account Name</label>
                            <input id="name" name="name" type="text"
                                value="{{ old('name', $currentUser->name) }}"
                                required>
                        </div>

                        <div class="settings-field">
                            <label for="email">Email Address</label>
                            <input id="email" name="email" type="email"
                                value="{{ old('email', $currentUser->email) }}"
                                required>
                        </div>
                    </div>

                    <div class="settings-form-actions">
                        <button type="submit" class="settings-save-btn">
                            Save Profile
                        </button>
                    </div>
                </form>
            </section>

            {{-- SECURITY --}}
            <section class="settings-panel" id="panel-security" hidden>
                <div class="settings-panel-heading">
                    <h2>Account &amp; Security</h2>
                    <p>Change the password used to access the staff account.</p>
                </div>

                <form method="POST"
                    action="{{ route('staff.settings.password') }}">
                    @csrf
                    @method('PATCH')

                    <div class="settings-field">
                        <label for="current_password">Current Password</label>
                        <input id="current_password" name="current_password"
                            type="password" autocomplete="current-password"
                            required>
                    </div>

                    <div class="settings-field">
                        <label for="password">New Password</label>
                        <input id="password" name="password" type="password"
                            minlength="8" autocomplete="new-password" required>
                    </div>

                    <div class="settings-field">
                        <label for="password_confirmation">
                            Confirm New Password
                        </label>
                        <input id="password_confirmation"
                            name="password_confirmation" type="password"
                            minlength="8" autocomplete="new-password" required>
                    </div>

                    <div class="settings-form-actions">
                        <button type="submit" class="settings-save-btn">
                            Update Password
                        </button>
                    </div>
                </form>
            </section>

            {{-- NOTIFICATIONS --}}
            <section class="settings-panel"
                id="panel-notifications" hidden>
                <div class="settings-panel-heading">
                    <h2>Notifications</h2>
                    <p>Choose which alerts the staff account should receive.</p>
                </div>

                <form method="POST"
                    action="{{ route('staff.settings.notifications') }}">
                    @csrf
                    @method('PATCH')

                    @foreach ([
                        'new_requests' => [
                            'title' => 'New requests',
                            'description' => 'Alerts for newly submitted resident requests.'
                        ],
                        'status_updates' => [
                            'title' => 'Request status updates',
                            'description' => 'Alerts when request statuses change.'
                        ],
                        'claim_reminders' => [
                            'title' => 'Claim schedule reminders',
                            'description' => 'Alerts for upcoming document claim dates.'
                        ]
                    ] as $key => $item)
                        <div class="settings-toggle-row">
                            <div>
                                <h3>{{ $item['title'] }}</h3>
                                <p>{{ $item['description'] }}</p>
                            </div>

                            <label class="settings-switch">
                                <input type="hidden"
                                    name="{{ $key }}" value="0">
                                <input type="checkbox" name="{{ $key }}"
                                    value="1"
                                    @checked(old($key, $settings[$key] ?? '1') == '1')>
                                <span class="settings-switch-slider"></span>
                            </label>
                        </div>
                    @endforeach

                    <div class="settings-form-actions">
                        <button type="submit" class="settings-save-btn">
                            Save Notifications
                        </button>
                    </div>
                </form>
            </section>

            
{{-- Barangay Information Panel --}}
<section class="settings-panel" id="panel-barangay" hidden>
    <div class="settings-panel-header">
        <h2>Barangay Information</h2>
        <p>
            Manage the contact details and service information
            displayed to residents.
        </p>
    </div>

    <form
        action="{{ route('staff.settings.barangay') }}"
        method="POST"
        class="settings-form"
    >
        @csrf
        @method('PATCH')

        {{-- Barangay Name --}}
        <div class="settings-field">
            <label for="barangay_name">Barangay Name</label>
            <input
                type="text"
                id="barangay_name"
                name="barangay_name"
                value="{{ old('barangay_name', $barangayInformation->barangay_name ?? '') }}"
                placeholder="Enter barangay name"
                required
            >
            @error('barangay_name')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>

        {{-- Contact Email --}}
        <div class="settings-field">
            <label for="contact_email">Contact Email</label>
            <input
                type="email"
                id="contact_email"
                name="contact_email"
                value="{{ old('contact_email', $barangayInformation->contact_email ?? '') }}"
                placeholder="Enter contact email"
            >
            @error('contact_email')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>

        {{-- Contact Number --}}
        <div class="settings-field">
            <label for="contact_number">Contact Number</label>
            <input
                type="text"
                id="contact_number"
                name="contact_number"
                value="{{ old('contact_number', $barangayInformation->contact_number ?? '') }}"
                placeholder="Enter contact number"
            >
            @error('contact_number')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>

        {{-- Office Hours --}}
        <div class="settings-field">
            <label for="office_hours">Office Hours</label>
            <input
                type="text"
                id="office_hours"
                name="office_hours"
                value="{{ old('office_hours', $barangayInformation->office_hours ?? '') }}"
                placeholder="e.g. Monday–Friday, 8:00 AM–5:00 PM"
            >
            @error('office_hours')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>

        {{-- Claim Instructions --}}
        <div class="settings-field">
            <label for="claim_instructions">Claim Instructions</label>
            <textarea
                id="claim_instructions"
                name="claim_instructions"
                rows="4"
                placeholder="Enter instructions for residents claiming documents"
            >{{ old('claim_instructions', $barangayInformation->claim_instructions ?? '') }}</textarea>
            @error('claim_instructions')
                <small class="error-message">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="settings-save-btn">
            Save Changes
        </button>
    </form>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/staff/settings.js') }}" defer></script>
@endpush
