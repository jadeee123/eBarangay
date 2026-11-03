@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/my-request.css') }}">
@endpush

@section('title', 'My Requests - eBarangay')

@section('content')
<div class="my-request-page">

    <div class="page-heading">
        <h2>My Requests</h2>
        <p>View and manage your submitted requests.</p>
    </div>

    <div class="request-toolbar">
        <div class="request-tabs">
            <button type="button" class="request-tab active" data-status="active">
                Active Requests
            </button>

            <button type="button" class="request-tab" data-status="completed">
                Completed Requests
            </button>
        </div>

        <div class="request-search">
            <i class='bx bx-search'></i>
            <input
                type="search"
                id="requestSearch"
                placeholder="Search your requests..."
                aria-label="Search your requests"
            >
        </div>

        <button type="button" class="request-filter-btn" id="requestFilterBtn"
                aria-label="Show filters" title="Filter requests">
            <i class='bx bx-filter-alt'></i>
        </button>
    </div>

    <div class="request-filter-panel" id="requestFilterPanel" hidden>
        <div class="filter-field">
            <label for="dateFrom">Date From</label>
            <input type="date" id="dateFrom">
        </div>

        <div class="filter-field">
            <label for="dateTo">Date To</label>
            <input type="date" id="dateTo">
        </div>

        <div class="filter-field">
            <label for="statusFilter">Status</label>
            <select id="statusFilter">
                <option value="all">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>

        <button type="button" class="clear-filters-btn" id="clearFilters">
            <i class='bx bx-reset'></i>
            Clear Filters
        </button>
    </div>

    <div class="request-table-card">
        <div class="table-responsive">
            <table class="request-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="requestTable">
                    {{-- Requests will appear here when connected to Laravel and Supabase. --}}
                </tbody>
            </table>
        </div>

        <div class="empty-state" id="emptyState">
            <div class="empty-icon">
                <i class='bx bx-folder-open'></i>
            </div>

            <h3>No requests submitted yet</h3>
            <p>Your submitted requests will appear here.</p>

            <a href="{{ route('requests.create', ['service' => 'barangay-clearance']) }}"
               class="submit-request-btn">
                <i class='bx bx-plus'></i>
                Submit a Request
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/my-request.js') }}" defer></script>
@endpush
