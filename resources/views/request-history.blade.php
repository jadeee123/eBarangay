@extends('layouts.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/request-history.css') }}">
@endpush

@section('title', 'Request History - eBarangay')

@section('content')
<div class="request-history-page">

    <div class="page-heading">
        <div>
            <h2>Request History</h2>
            <p>View all your past requests and their final status.</p>
        </div>
    </div>

    <div class="history-toolbar">
        <div class="history-search">
            <i class='bx bx-search'></i>
            <input
                type="search"
                id="historySearch"
                placeholder="Search by service or date..."
                aria-label="Search request history"
            >
        </div>

        <button
            type="button"
            class="history-filter-btn"
            id="historyFilterBtn"
            aria-label="Filter request history"
            title="Filter by status"
        >
            <i class='bx bx-filter-alt'></i>
        </button>

        <select
            id="historyStatusFilter"
            class="history-status-filter"
            aria-label="Filter by status"
            hidden
        >
            <option value="all">All statuses</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>

    <div class="history-table-card">
        <div class="table-responsive">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Claim Date</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="historyTable">
                    {{-- Request history will be loaded from the database later. --}}
                </tbody>
            </table>
        </div>

        <div class="history-empty-state" id="historyEmptyState">
            <div class="empty-icon">
                <i class='bx bx-folder-open'></i>
            </div>

            <h3>No request history yet</h3>
            <p>Your completed or closed requests will appear here.</p>
        </div>

        <div class="history-pagination" id="historyPagination" hidden>
            <button type="button" disabled aria-label="Previous page">
                <i class='bx bx-chevron-left'></i>
            </button>

            <button
                type="button"
                class="current-page"
                aria-current="page"
            >1</button>

            <button type="button" disabled aria-label="Next page">
                <i class='bx bx-chevron-right'></i>
            </button>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/request-history.js') }}" defer></script>
@endpush
