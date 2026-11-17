@extends('layouts.dashstaff')

@section('title', 'All Requests - eBarangay')
@section('page-heading', 'All Service Requests')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/all-requests.css') }}">
@endpush

@section('content')

<section class="all-requests-page">

    <div class="all-requests-heading">
        <div>
            <h2>All Service Requests</h2>
            <p>View and manage all submitted barangay service requests.</p>
        </div>

        <button type="button" id="showAllBtn" class="show-all-btn">
            Show All
        </button>
    </div>

    <section class="all-requests-panel">

        <div class="all-requests-toolbar">

            <div class="all-requests-search">
                <i class="bx bx-search"></i>
                <input
                    type="search"
                    id="requestSearch"
                    placeholder="Search ID, resident, or service..."
                    aria-label="Search service requests"
                >
            </div>

            <select id="requestStatusFilter" aria-label="Filter by status">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="approved">Approved</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
            </select>

        </div>

        <div class="all-requests-table-wrap">
            <table class="all-requests-table">

                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Resident</th>
                        <th>Service</th>
                        <th>Date Submitted</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="allRequestsTable">

                    @forelse ($requests as $request)
                        <tr>
                            <td class="request-id">
                                #SR-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}
                            </td>

                            <td>
                                {{ $request->resident_name ?? 'Resident' }}
                            </td>

                            <td>
                                {{ ucwords(str_replace('-', ' ', $request->service_name ?? '')) }}
                            </td>

                            <td>
                                {{ $request->created_at
                                    ? \Carbon\Carbon::parse($request->created_at)->format('M d, Y')
                                    : '—' }}
                            </td>

                            <td>
                                <span class="request-status"
                                      data-status="{{ strtolower($request->status ?? 'pending') }}">
                                    {{ ucfirst($request->status ?? 'Pending') }}
                                </span>
                            </td>

                            <td>
                                <a class="request-view-btn"
                                   href="{{ url('/staff/requests/' . $request->id) }}">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr id="allRequestsEmpty">
                            <td colspan="6">
                                <div class="all-requests-empty">
                                    <i class="bx bx-inbox"></i>
                                    <h3>No service requests yet</h3>
                                    <p>Submitted resident requests will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noMatchingRequests" hidden>
                        <td colspan="6">
                            <div class="all-requests-empty">
                                <i class="bx bx-search-alt"></i>
                                <h3>No matching requests</h3>
                                <p>Try a different search or status filter.</p>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <p class="all-requests-note">
            Request records are loaded from the database.
        </p>

    </section>

</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/staff/all-requests.js') }}" defer></script>
@endpush
