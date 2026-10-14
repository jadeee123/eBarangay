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
                 alt="eBarangay Logo">
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

            <a href="#">
                <i class="bx bx-cog"></i>
                <span>Settings</span>
            </a>
        </nav>

        <div class="sidebar-help">
            <i class="bx bx-headphone"></i>
            <h3>Need Help?</h3>
            <p>Contact your barangay office for assistance.</p>
            <a href="mailto:barangay@example.com" class="contact-btn">
                <i class="bx bxs-phone"></i>
                Barangay Contact
            </a>
        </div>

    </aside>

    <main class="main-content">

        <header class="topbar">

            <div class="search-box">
                <i class="bx bx-search"></i>
                <input type="search"
                       placeholder="Search services or requests...">
            </div>

            <div class="user-info">
                <i class="bx bx-bell notification-icon"></i>
                <div>
                    <strong>Resident</strong>
                    <span>eBarangay Account</span>
                </div>
                <i class="bx bx-chevron-down"></i>
            </div>

        </header>

        <div class="dashboard-content">
            @yield('content')
        </div>

    </main>

</div>

</body>
</html>