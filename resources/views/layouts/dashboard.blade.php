<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'eBarangay')</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @stack('styles')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
          rel="stylesheet">
</head>
<body>

<div class="dashboard">

    <aside class="sidebar">

        <div class="logo">
            <img src="{{ asset('images/ebarangay.png') }}"
            alt="Barangay Cuambogan">
        </div>

        <nav class="sidebar-menu">
            <a href="{{ url('/dashboard') }}"
               class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bx bxs-home"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ url('/request') }}"
            class="{{ request()->is('request') ? 'active' : '' }}">
            <i class="bx bxs-file-plus"></i>
            <span>Submit Request</span>
           </a>

            <a href="{{ url('/my-requests') }}"
               class="{{ request()->is('my-requests') ? 'active' : '' }}">
                <i class="bx bx-list-ul"></i>
                <span>My Requests</span>
            </a>

            <a href="{{ url('/request-history') }}"
               class="{{ request()->is('request-history') ? 'active' : '' }}">
                <i class="bx bx-history"></i>
                <span>Request History</span>
            </a>

            <a href="{{ url('/profile') }}"
               class="{{ request()->is('profile') ? 'active' : '' }}">
                <i class="bx bx-user"></i>
                <span>Profile</span>
            </a>
            
            <div class="sidebar-help">
                <i class="bx bx-headphone"></i>
                <h3>Need Help?</h3>
                <p>Contact your barangay office for assistance.</p>
                
                <a href="{{ route('help') }}" class="contact-btn">
                    <i class="bx bx-phone"></i>
                    Barangay Contact
                </a>
            </div>
    </aside>

    <main class="main-content">

        <header class="topbar">
         
<header class="topbar">
    <div class="topbar-actions">

        <div class="notification-wrapper">
            <button
                type="button"
                class="notification-btn"
                id="notificationBtn"
                aria-label="Open notifications"
                aria-expanded="false"
                aria-controls="notificationPanel"
            >
                <i class="bx bx-bell notification-icon"></i>
            </button>

            <div
                class="notification-panel"
                id="notificationPanel"
                hidden
            >
                <div class="notification-header">
                    <h3>Notifications</h3>
                </div>

                <div class="notification-empty">
                    <i class="bx bx-bell-off"></i>
                    <h4>No notifications yet</h4>
                    <p>
                        You're all caught up! Updates about your
                        requests will appear here.
                    </p>
                </div>
            </div>
        </div>

        <div class="user-info">
            <strong>Resident</strong>
            <span>eBarangay Account</span>
        </div>

    </div>
</header>

        </header>

        <div class="dashboard-content">
            @yield('content')
        </div>

    </main>

</div>

<script src="{{ asset('js/notifications.js') }}" defer></script>

@stack('scripts')

</body>
</html>