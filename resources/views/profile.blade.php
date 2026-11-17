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

            <!-- account settings -->
            <button type="button"
                    class="settings-menu-item {{ request('panel') === 'notifications' || request('panel') === 'privacy' ? '' : 'active' }}"
                    data-panel="account">
                <i class='bx bx-user'></i>
                <span>Account Settings</span>
                <i class='bx bx-chevron-right menu-arrow'></i>
            </button>

            <!-- notif settings -->
            <button type="button"
                    class="settings-menu-item {{ request('panel') === 'notifications' ? 'active' : '' }}"
                    data-panel="notifications">
                <i class='bx bx-bell'></i>
                <span>Notification Settings</span>
                <i class='bx bx-chevron-right menu-arrow'></i>
            </button>

           <!-- privacy & security -->
            <button type="button"
                    class="settings-menu-item {{ request('panel') === 'privacy' ? 'active' : '' }}"
                    data-panel="privacy">
                <i class='bx bx-lock-alt'></i>
                <span>Privacy &amp; Security</span>
                <i class='bx bx-chevron-right menu-arrow'></i>
            </button>

        </div>

        <div class="settings-content">

            <section class="settings-panel {{ request('panel') === 'notifications' || request('panel') === 'privacy' ? '' : 'active' }}"
                     id="account-panel"
                     {{ request('panel') === 'notifications' || request('panel') === 'privacy' ? 'hidden' : '' }}>

                <h3>Account Settings</h3>
                <p class="panel-description">
                    Manage your personal account information.
                </p>

                <form id="accountForm"
                       action="{{ route('profile.update') }}"
                      method="POST">
                    @csrf

                    <div class="profile-form-group">
                        <label for="fullName">Full Name</label>
                        <input
                            type="text"
                            id="fullName"
                            name="full_name"
                            value="{{ old('full_name', auth()->user()->name) }}"
                            placeholder="Enter your full name">
                    </div>

                    <div class="profile-form-group">
                        <label for="emailAddress">Email Address</label>
                        <input
                            type="email"
                            id="emailAddress"
                            name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            placeholder="Enter your email address">
                    </div>

                    <button type="submit" class="save-settings-btn">
                        Save Changes
                    </button>

                   @if (session('account_success'))
                   <p class="settings-message" id="accountMessage" role="status">
                    {{ session('account_success') }}
                </p>
                @else
                <p class="settings-message" id="accountMessage" role="status"></p>
                @endif
                </form>
            </section>

            <section class="settings-panel {{ request('panel') === 'notifications' ? 'active' : '' }}"
                     id="notifications-panel"
                     {{ request('panel') === 'notifications' ? '' : 'hidden' }}>

                <h3>Notification Settings</h3>
                <p class="panel-description">
                    Choose which notifications you want to receive.
                </p>

                <form id="notificationForm"
                      action="{{ route('notification-settings.update', ['panel' => 'notifications']) }}"
                      method="POST">
                    @csrf

                    <label class="settings-option">
                        <span>
                            <strong>Request Updates</strong>
                            <small>Receive updates about your submitted requests.</small>
                        </span>

                        <input
                            type="checkbox"
                            name="request_updates"
                            value="1"
                            {{ ($notificationSettings->request_updates ?? true) ? 'checked' : '' }}>
                    </label>

                    <label class="settings-option">
                        <span>
                            <strong>Claim Date Reminders</strong>
                            <small>Get reminders when your documents are ready to claim.</small>
                        </span>

                        <input
                            type="checkbox"
                            name="claim_reminders"
                            value="1"
                            {{ ($notificationSettings->claim_reminders ?? true) ? 'checked' : '' }}>
                    </label>

                    <label class="settings-option">
                        <span>
                            <strong>Account Notifications</strong>
                            <small>Receive important account-related notifications.</small>
                        </span>

                        <input
                            type="checkbox"
                            name="account_notifications"
                            value="1"
                            {{ ($notificationSettings->account_notifications ?? true) ? 'checked' : '' }}>
                    </label>

                    <button type="submit" class="save-settings-btn">
                        Save Changes
                    </button>

                    @if (session('notification_success'))
                        <p class="settings-message"
                           id="notificationMessage"
                           role="status"
                           aria-live="polite">
                            {{ session('notification_success') }}
                        </p>
                    @else
                        <p class="settings-message"
                           id="notificationMessage"
                           role="status"
                           aria-live="polite"></p>
                    @endif
                </form>
            </section>

            <section class="settings-panel {{ request('panel') === 'privacy' ? 'active' : '' }}"
                     id="privacy-panel"
                     {{ request('panel') === 'privacy' ? '' : 'hidden' }}>

                <h3>Privacy &amp; Security</h3>
                <p class="panel-description">
                    Manage your account password and security.
                </p>

                <form id="privacyForm"
                action="{{ route('password.update') }}"
                method="POST">
                @csrf

                    <div class="profile-form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password"
                        id="confirmPassword"
                        name="new_password_confirmation">
                    </div>

                    <div class="profile-form-group">
                        <label for="newPassword">New Password</label>
                        <input
                            type="password"
                            id="newPassword"
                            name="new_password"
                            placeholder="Enter new password"
                            autocomplete="new-password">
                    </div>

                    <div class="profile-form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input
                            type="password"
                            id="confirmPassword"
                            name="confirm_password"
                            placeholder="Confirm new password"
                            autocomplete="new-password">
                    </div>

                    <button type="submit" class="save-settings-btn">
                        Update Password
                    </button>

                    @if (session('password_success'))
                    <p class="settings-message" id="privacyMessage" role="status">
                        {{ session('password_success') }}
                    </p>
                    @else

                    <p class="settings-message" id="privacyMessage" role="status"></p>
                    @endif
                </form>
            </section>

        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/profile.js') }}" defer></script>
@endpush
