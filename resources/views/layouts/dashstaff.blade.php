<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Staff Dashboard - eBarangay')</title>

    <link rel="stylesheet" href="{{ asset('css/staff/staff.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>

<div class="staff-layout" id="staffLayout">

    <!-- SIDEBAR -->
    <aside class="staff-sidebar" id="staffSidebar">

        <div class="staff-brand">
            <div class="logo">
                <img src="{{ asset('images/ebarangay.png') }}"
             alt="Barangay Cuambugan">
             </div>
             
             <div class="staff-brand-text">
                <h2>eBarangay</h2>
                <p>Barangay Cuambugan</p>
                <span>STAFF PORTAL</span>
            </div>
        </div>

        <div class="staff-nav-label">WORKSPACE</div>

        <nav class="staff-nav" aria-label="Staff navigation">

            <a href="{{ url('/dashstaff') }}"
            class="staff-nav-link {{ request()->is('dashstaff') ? 'active' : '' }}">
                <i class="bx bx-grid-alt"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/staff/requests/incoming') }}"
               class="staff-nav-link {{ request()->is('staff/requests/incoming') ? 'active' : '' }}">
                <i class="bx bx-list-check"></i>
                <span>Incoming Requests</span>
            </a>

            <a href="{{ url('/staff/requests') }}"
               class="staff-nav-link {{ request()->is('staff/requests') || request()->is('staff/requests/*') && !request()->is('staff/requests/incoming') ? 'active' : '' }}">
                <i class="bx bx-list-check"></i>
                <span>All Requests</span>
            </a>

            <a href="{{ route('staff.residents') }}"
            class="staff-nav-link {{ request()->is('staff/residents*') ? 'active' : '' }}">
            <i class="bx bx-group"></i>
            <span>Residents</span>
        </a>
                
            <div class="staff-nav-label">MANAGEMENT</div>
            
            <a href="{{ route('staff.announcements.index') }}"
            class="staff-nav-link {{ request()->is('staff/announcements*') ? 'active' : '' }}">
            <i class="bx bx-bell"></i>
            <span>Announcements</span>
        </a>

        <a href="{{ url('/staff/services') }}"
        class="staff-nav-link {{ request()->is('staff/services*') ? 'active' : '' }}">
        <i class="bx bx-briefcase-alt-2"></i>
        <span>Services</span>
    </a>

            <a href="{{ url('/staff/reports') }}"
               class="staff-nav-link {{ request()->is('staff/reports*') ? 'active' : '' }}">
                <i class="bx bx-bar-chart-alt-2"></i>
                <span>Reports</span>
            </a>

            <a href="{{ url('/staff/settings') }}"
               class="staff-nav-link {{ request()->is('staff/settings*') ? 'active' : '' }}">
                <i class="bx bx-cog"></i>
                <span>Settings</span>
            </a>

        </nav>

        <!-- STAFF ACCOUNT AND LOGOUT -->
        <div class="staff-sidebar-bottom">

            <div class="staff-account">
                <div class="staff-avatar">
                    <i class="bx bx-user"></i>
                </div>

                <div class="staff-account-info">
                    <strong>{{ auth()->user()->name ?? 'Staff Account' }}</strong>
                    <span>Barangay Staff</span>
                </div>
            </div>

            <form action="{{ route('logout') }}"
                  method="POST"
                  id="staffLogoutForm">
                @csrf

                <button type="button"
                        class="staff-logout-btn"
                        id="staffLogoutTrigger">
                    <i class="bx bx-log-out"></i>
                    <span>Log Out</span>
                </button>
            </form>

        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="staff-main">

        <!-- TOPBAR -->
        
<header class="staff-topbar">

    <!-- LEFT: PAGE HEADING -->
    <div class="staff-topbar-left">
        <button type="button"
                class="staff-menu-toggle"
                id="staffMenuToggle"
                aria-label="Toggle sidebar"
                aria-expanded="false">
            <i class="bx bx-menu"></i>
        </button>

    </div>

    <!-- RIGHT: NOTIFICATIONS AND STAFF ACCOUNT -->
    <div class="staff-topbar-right">

        <div class="staff-notification-wrapper">
            <button type="button"
                    class="staff-notification-btn"
                    id="staffNotificationToggle"
                    aria-label="Toggle notifications"
                    aria-expanded="false"
                    aria-controls="staffNotificationPanel">
                <i class="bx bx-bell"></i>

                @if (isset($staffUnreadNotifications) && $staffUnreadNotifications > 0)
                    <span class="staff-notification-badge">
                        {{ $staffUnreadNotifications }}
                    </span>
                @endif
            </button>

            <div class="staff-notification-panel"
                 id="staffNotificationPanel"
                 hidden>

                <div class="staff-notification-header">
                    <div>
                        <h3>Notifications</h3>
                        <p>Staff updates and alerts</p>
                    </div>
                </div>
               
@if (isset($staffNotifications) && $staffNotifications->isNotEmpty())
    @foreach ($staffNotifications as $notification)
        <div class="staff-notification-item"
             role="button"
             tabindex="0"
             style="cursor: pointer;"
             data-id="{{ $notification->id }}"
             data-reply-url="{{ route('contact-messages.reply', $notification->id) }}"
             data-name="{{ $notification->name }}"
             data-email="{{ $notification->email }}"
             data-subject="{{ $notification->subject }}"
             data-message="{{ $notification->full_message }}"
             data-date="{{ $notification->created_at }}">

            <div class="staff-notification-icon">
                <i class="bx bx-bell"></i>
            </div>

            <div class="staff-notification-content">
                <strong>{{ $notification->title }}</strong>

                <p>{{ $notification->message }}</p>

                @if (isset($notification->created_at))
                    <small>
                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                    </small>
                @endif
            </div>

        </div>
    @endforeach
@else
    <div class="staff-notification-empty">
        <i class="bx bx-bell-off"></i>
        <h4>No notifications yet</h4>
        <p>Staff alerts will appear here when available.</p>
    </div>
@endif

            </div>
        </div>

        <div class="staff-topbar-account">
            <div class="staff-topbar-account-info">
                <strong>STAFF</strong>
                <span>eBarangay Account</span>
            </div>
        </div>

    </div>
</header>

        <!-- PAGE CONTENT -->
        <div class="staff-content">

            @if (session('success'))
                <div class="staff-alert staff-alert-success" role="status">
                    <i class="bx bx-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="staff-alert staff-alert-error" role="alert">
                    <i class="bx bx-error-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="staff-alert staff-alert-error" role="alert">
                    <i class="bx bx-error-circle"></i>
                    <div>
                        <strong>Please check the following:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')

        </div>

    </main>
</div>

<!-- MOBILE SIDEBAR OVERLAY -->
<div class="staff-sidebar-overlay" id="staffSidebarOverlay" hidden></div>

<!-- LOGOUT CONFIRMATION -->
<div class="staff-modal" id="staffLogoutModal" hidden>
    <div class="staff-modal-content"
         role="dialog"
         aria-modal="true"
         aria-labelledby="staffLogoutTitle">

        <div class="staff-modal-icon">
            <i class="bx bx-log-out"></i>
        </div>

        <h2 id="staffLogoutTitle">Log Out?</h2>

        <p>Are you sure you want to log out of your staff account?</p>

        <div class="staff-modal-actions">
            <button type="button"
                    class="staff-btn staff-btn-secondary"
                    id="staffCancelLogout">
                Cancel
            </button>

            <button type="button"
                    class="staff-btn staff-btn-primary"
                    id="staffConfirmLogout">
                Yes, Log Out
            </button>
        </div>
    </div>
</div>


<!-- CONTACT MESSAGE DETAILS MODAL -->
<div class="staff-modal" id="staffMessageModal" hidden>
    <div class="staff-modal-content"
         role="dialog"
         aria-modal="true"
         aria-labelledby="staffMessageTitle">

        <h2 id="staffMessageTitle">Contact Message</h2>

        <p><strong>From:</strong> <span id="messageSender"></span></p>
        <p><strong>Email:</strong> <span id="messageEmail"></span></p>
        <p><strong>Subject:</strong> <span id="messageSubject"></span></p>
        <p><strong>Date:</strong> <span id="messageDate"></span></p>

        <hr>

        <p><strong>Message:</strong></p>
        <p id="messageFullText"></p>


<hr>

<h3>Reply to Resident</h3>

<form id="staffReplyForm" method="POST">
    @csrf

    <label for="replyMessage">Your Reply</label>

    <textarea
        id="replyMessage"
        name="reply_message"
        rows="5"
        maxlength="5000"
        placeholder="Type your reply to the resident..."
        required
    ></textarea>

    <button type="submit" class="staff-btn">
        Send Reply
    </button>
</form>


        <div class="staff-modal-actions">
            <button type="button"
                    class="staff-btn staff-btn-secondary"
                    id="closeMessageModal">
                Close
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/staff/staff.js') }}" defer></script>
@stack('scripts')

</body>
</html>
