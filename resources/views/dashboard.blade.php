@extends('layouts.dashboard')

@section('title', 'request - eBarangay')

@section('content')

    <section class="summary-cards">

        <article class="summary-card">
            <div class="card-icon yellow">
                <i class="bx bx-file"></i>
            </div>
            <h2>0</h2>
            <p>Total Requests</p>
            <small>All your submitted requests</small>
        </article>

        <article class="summary-card">
            <div class="card-icon gray">
                <i class="bx bx-time-five"></i>
            </div>
            <h2>0</h2>
            <p>Pending</p>
            <small>Waiting for verification</small>
        </article>

        <article class="summary-card">
            <div class="card-icon yellow">
                <i class="bx bx-check-circle"></i>
            </div>
            <h2>0</h2>
            <p>Completed</p>
            <small>Processed requests</small>
        </article>

        <article class="summary-card">
            <div class="card-icon gray">
                <i class="bx bx-calendar"></i>
            </div>
            <h2>0</h2>
            <p>Claim Dates</p>
            <small>Scheduled claims</small>
        </article>

    </section>

    <section class="content-grid">

        <div class="left-column">

            <section class="panel">
                <div class="panel-heading">
                    <h2>Recent Requests</h2>
                    <a href="{{ url('/my-requests') }}">
                        View All
                        <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Date Submitted</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Claim Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td colspan="5" class="empty-state">
                                    No requests submitted yet.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel announcements">
                <div class="panel-heading">
                    <h2>
                        <i class="bx bxs-megaphone"></i>
                        Latest Announcements
                    </h2>

                    <a href="#">
                        View All
                        <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>

                <p>No announcements available yet.</p>
            </section>

        </div>

        <div class="right-column">
        
            <section class="panel">
                <h2>Quick Actions</h2>

                <div class="quick-actions">

                    <a href="{{ url('/submit-request') }}"
                       class="action-card highlighted">
                        <i class="bx bx-file"></i>
                        <span>Submit a Request</span>
                        <i class="bx bx-right-arrow-alt"></i>
                    </a>

                    <a href="{{ url('/my-requests') }}"
                       class="action-card">
                        <i class="bx bx-list-ul"></i>
                        <span>View My Requests</span>
                        <i class="bx bx-right-arrow-alt"></i>
                    </a>

                    <a href="{{ url('/my-requests') }}"
                       class="action-card">
                        <i class="bx bx-time-five"></i>
                        <span>Track Status</span>
                        <i class="bx bx-right-arrow-alt"></i>
                    </a>

                    <a href="{{ url('/my-requests') }}"
                       class="action-card">
                        <i class="bx bx-calendar"></i>
                        <span>View Claim Dates</span>
                        <i class="bx bx-right-arrow-alt"></i>
                    </a>

                </div>
            </section>

            <section class="panel profile-panel">
                <h2>My Profile</h2>

                <div class="profile-details">
                    <i class="bx bx-user-circle profile-avatar"></i>

                    <div>
                        <strong>Resident Name</strong>
                        <p>Resident</p>
                    </div>
                </div>

                <div class="profile-item">
                    <i class="bx bx-envelope"></i>

                    <div>
                        <span>Email</span>
                        <p>your-email@example.com</p>
                    </div>
                </div>

                <a href="{{ url('/profile') }}" class="edit-profile">
                    <i class="bx bx-edit"></i>
                    Edit Profile
                </a>
            </section>

        </div>

    </section>

@endsection
