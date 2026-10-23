@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('title', 'Profile - eBarangay')

@section('content')
<div class="profile-page">

    <div class="page-heading">
        <h2>Settings</h2>
        <p>Customize your account and notification preferences.</p>
    </div>

    <div class="settings-layout">

        <div class="settings-menu">

            <button type="button" class="settings-menu-item active"
                    data-panel="account">
                <i class='bx bx-user'></i>
                <span>Account Settings</span>
                <i class='bx bx-chevron-right menu-arrow'></i>
            </button>

            <button type="button" class="settings-menu-item"
                    data-panel="notifications">
                <i class='bx bx-bell'></i>
                <span>Notification Settings</span>
                <i class='bx bx-chevron-right menu-arrow'></i>
            </button>

            <button type="button" class="settings-menu-item"
                    data-panel="privacy">
                <i class='bx bx-lock-alt'></i>
                <span>Privacy &amp; Security</span>
                <i class='bx bx-chevron-right menu-arrow'></i>
            </button>

            <button type="button" class="settings-menu-item"
                    data-panel="appearance">
                <i class='bx bx-palette'></i>
                <span>Appearance</span>
                <i class='bx bx-chevron-right menu-arrow'></i>
            </button>

        </div>

        <div class="settings-content">

            <section class="settings-panel active" id="account-panel">
                <h3>Account Settings</h3>
                <p class="panel-description">
                    Manage your personal account information.
                </p>

               <form id="accountForm" action="{{ url('/profile') }}" method="POST">
    @csrf

                    <div class="profile-form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="full_name"
                               placeholder="Enter your full name">
                    </div>

                    <div class="profile-form-group">
                        <label for="emailAddress">Email Address</label>
                        <input type="email" id="emailAddress" name="email"
                               placeholder="Enter your email address">
                    </div>

                    <button type="submit" class="save-settings-btn">
                        Save Changes
                    </button>

                    <p class="settings-message" id="accountMessage"
                       role="status" aria-live="polite"></p>
                </form>
            </section>

            <section class="settings-panel" id="notifications-panel" hidden>
                <h3>Notification Settings</h3>
                <p class="panel-description">
                    Choose which notifications you want to receive.
                </p>

                <form id="notificationForm">

                    <label class="settings-option">
                        <span>
                            <strong>Request Updates</strong>
                            <small>Receive updates about your submitted requests.</small>
                        </span>
                        <input type="checkbox" name="request_updates">
                    </label>

                    <label class="settings-option">
                        <span>
                            <strong>Claim Date Reminders</strong>
                            <small>Get reminders when your documents are ready to claim.</small>
                        </span>
                        <input type="checkbox" name="claim_reminders">
                    </label>

                    <label class="settings-option">
                        <span>
                            <strong>Account Notifications</strong>
                            <small>Receive important account-related notifications.</small>
                        </span>
                        <input type="checkbox" name="account_notifications">
                    </label>

                    <button type="submit" class="save-settings-btn">
                        Save Changes
                    </button>

                    <p class="settings-message" id="notificationMessage"
                       role="status" aria-live="polite"></p>
                </form>
            </section>

            <section class="settings-panel" id="privacy-panel" hidden>
                <h3>Privacy &amp; Security</h3>
                <p class="panel-description">
                    Manage your account password and security.
                </p>

                <form id="privacyForm">

                    <div class="profile-form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" id="currentPassword"
                               name="current_password"
                               placeholder="Enter current password"
                               autocomplete="current-password">
                    </div>

                    <div class="profile-form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword"
                               name="new_password"
                               placeholder="Enter new password"
                               autocomplete="new-password">
                    </div>

                    <div class="profile-form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" id="confirmPassword"
                               name="confirm_password"
                               placeholder="Confirm new password"
                               autocomplete="new-password">
                    </div>

                    <button type="submit" class="save-settings-btn">
                        Update Password
                    </button>

                    <p class="settings-message" id="privacyMessage"
                       role="status" aria-live="polite"></p>
                </form>
            </section>

        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/profile.js') }}" defer></script>
@endpush
