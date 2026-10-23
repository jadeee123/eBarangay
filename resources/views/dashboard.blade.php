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
        <p>Approved</p>
        <small>Requests accepted</small>
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

<section class="dashboard-requests panel">

    <div class="panel-heading">
        <div>
            <h2>Track Your Requests</h2>
            <p class="section-description">
                Check your request status and scheduled claim dates.
            </p>
        </div>

        <a href="{{ url('/my-requests') }}">
            View All <i class="bx bx-right-arrow-alt"></i>
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Service</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                    <th>Claim Date</th>
                </tr>
            </thead>

            <tbody>
                {{-- Temporary empty state until database requests are connected --}}
                <tr>
                    <td colspan="5" class="empty-state">
                        <i class="bx bx-file-blank"></i>
                        <p>No requests submitted yet.</p>
                        <small>
                            Your submitted requests and claim dates will appear here.
                        </small>
                        <a href="{{ url('/request') }}" class="submit-request-btn">
                            <i class="bx bx-plus"></i>
                            Submit a Request
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</section>

<section class="panel announcements dashboard-announcements">

    <div class="panel-heading">
        <h2>
            <i class="bx bxs-megaphone"></i>
            Latest Announcements
        </h2>

        <a href="#">
            View All <i class="bx bx-right-arrow-alt"></i>
        </a>
    </div>

    <p>No announcements available yet.</p>

</section>

@endsection
