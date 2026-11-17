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
    @forelse ($requests as $request)
        <tr
            data-status="{{ strtolower($request->status) }}"
            data-date="{{ \Carbon\Carbon::parse($request->created_at)->format('Y-m-d') }}"
        >
            <td>{{ $loop->iteration }}</td>

            <td>{{ $request->service_name }}</td>

            <td>
                {{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}
            </td>

            <td>
                <span class="status-badge {{ strtolower($request->status) }}">
                    {{ $request->status }}
                </span>
            </td>

            <td>
                {{ $request->claim_date
                    ? \Carbon\Carbon::parse($request->claim_date)->format('M d, Y')
                    : '—' }}
            </td>

            <td>
                
<button
    type="button"
    class="history-view-btn"
    data-service="{{ $request->service_name }}"
    data-description="{{ $request->description }}"
    data-date="{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y') }}"
    data-status="{{ $request->status }}"
    data-claim-date="{{ $request->claim_date
        ? \Carbon\Carbon::parse($request->claim_date)->format('M d, Y')
        : 'Not assigned yet' }}"
>
    View
</button>

            </td>
        </tr>
    @empty
        {{-- No rows are rendered when there is no history. --}}
    @endforelse
</tbody>

            </table>
        </div>

       <div
       class="history-empty-state"
       id="historyEmptyState"
        @if ($requests->isNotEmpty()) hidden @endif>
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

<div class="history-modal" id="historyDetailsModal" hidden>
    <div class="history-modal-content">
        <button type="button" class="history-modal-close" id="closeHistoryModal" aria-label="Close">
            &times;
        </button>

        <h2>Request Details</h2>

        <div class="history-detail-row">
            <strong>Service:</strong>
            <span id="detailService"></span>
        </div>

        <div class="history-detail-row">
            <strong>Description:</strong>
            <span id="detailDescription"></span>
        </div>

        <div class="history-detail-row">
            <strong>Date Submitted:</strong>
            <span id="detailDate"></span>
        </div>

        <div class="history-detail-row">
            <strong>Status:</strong>
            <span id="detailStatus"></span>
        </div>

        <div class="history-detail-row">
            <strong>Claim Date:</strong>
            <span id="detailClaimDate"></span>
        </div>
    </div>
</div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/request-history.js') }}" defer></script>
@endpush
