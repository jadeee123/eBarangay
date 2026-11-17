@extends('layouts.dashboard')

@section('title', 'Dashboard - eBarangay')

@section('content')

<section class="summary-cards">

    <a href="{{ route('requests.index', ['filter' => 'all']) }}" class="summary-card-link">
        <article class="summary-card">
            <div class="card-icon yellow">
                <i class="bx bx-file"></i>
            </div>
            <h2>{{ $totalRequests }}</h2>
            <p>Requests</p>
            <small>All your submitted requests</small>
        </article>
    </a>

    <a href="{{ route('requests.index', ['filter' => 'pending']) }}" class="summary-card-link">
        <article class="summary-card">
            <div class="card-icon gray">
                <i class="bx bx-time-five"></i>
            </div>
            <h2>{{ $pendingRequests }}</h2>
            <p>Pending</p>
            <small>Waiting for verification</small>
        </article>
    </a>

    <a href="{{ route('requests.index', ['filter' => 'approved']) }}" class="summary-card-link">
        <article class="summary-card">
            <div class="card-icon yellow">
                <i class="bx bx-check-circle"></i>
            </div>
            <h2>{{ $approvedRequests }}</h2>
            <p>Approved</p>
            <small>Requests accepted</small>
        </article>
    </a>

    <a href="{{ route('requests.index', ['filter' => 'claim-dates']) }}" class="summary-card-link">
        <article class="summary-card">
            <div class="card-icon gray">
                <i class="bx bx-calendar"></i>
            </div>
            <h2>{{ $claimDates }}</h2>
            <p>Claim Dates</p>
            <small>Scheduled claims</small>
        </article>
    </a>

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
    @forelse ($recentRequests as $request)
        <tr>
            <td>#{{ $request->id }}</td>

            <td>
                {{ ucwords(str_replace('-', ' ', $request->service_name)) }}
            </td>

            <td>
                {{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}
            </td>

            <td>
                <span class="status-badge {{ strtolower($request->status) }}">
                    {{ $request->status }}
                </span>
            </td>

            <td>
                @if ($request->claim_date)
                    {{ \Carbon\Carbon::parse($request->claim_date)->format('M d, Y') }}
                @else
                    Not assigned
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="empty-state">
                <i class="bx bx-file-blank"></i>
                <p>No requests submitted yet.</p>
                <small>
                    Your submitted requests and claim dates will appear here.
                </small>
                <a href="{{ route('requests.create', ['service' => 'barangay-clearance']) }}"
                   class="submit-request-btn">
                    <i class="bx bx-plus"></i>
                    Submit a Request
                </a>
            </td>
        </tr>
    @endforelse
</tbody>

        </table>
    </div>

    <div class="dashboard-submit-action">
        <a href="{{ route('requests.create', ['service' => 'barangay-clearance']) }}"
           class="submit-request-btn">
            <i class="bx bx-plus"></i>
            Submit a Request
        </a>
    </div>
</section>

<section class="panel announcements dashboard-announcements">

    <div class="panel-heading">
        <h2>
            <i class="bx bxs-megaphone"></i>
            Latest Announcements
        </h2>

        <a href="{{ route('announcements.index') }}">
            View All <i class="bx bx-right-arrow-alt"></i>
        </a>
    </div>

    <div class="announcement-list">
        @forelse ($announcements as $announcement)
            <article class="announcement-item">
                <h3>{{ $announcement->title }}</h3>
                <p>{{ $announcement->content }}</p>

                <small>
                    Published:
                    {{ \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y h:i A') }}
                </small>
            </article>
        @empty
            <p class="announcement-empty">
                No announcements available yet.
            </p>
        @endforelse
    </div>

</section>

@endsection
