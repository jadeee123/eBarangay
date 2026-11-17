
@extends('layouts.dashstaff')

@section('title', 'Incoming Requests - eBarangay')
@section('page-heading', 'Incoming Requests')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/incoming.css') }}">
@endpush

@section('content')

<section class="incoming-page">

    <!-- PAGE INTRODUCTION -->
    <div class="incoming-heading">
        <div>
            <h2>Incoming Requests</h2>
            <p>Review newly submitted barangay service requests.</p>
        </div>
    </div>

    <!-- PENDING REQUESTS -->
    <section class="incoming-panel">

        <div class="incoming-panel-heading">
            <div>
                <h3>Pending Review</h3>
                <p>Requests waiting for staff review.</p>
            </div>

            <span class="incoming-count">
                {{ $pendingCount }} {{ $pendingCount === 1 ? 'Request' : 'Requests' }}
            </span>
        </div>

        <!-- SEARCH -->
        <div class="incoming-toolbar">
            <div class="incoming-search">
                <i class="bx bx-search"></i>
                <input
                    type="search"
                    id="incomingSearch"
                    placeholder="Search resident, service, or request ID..."
                    aria-label="Search incoming requests"
                >
            </div>
        </div>

        <!-- REQUESTS TABLE -->
        <div class="incoming-table-wrap">
            <table class="incoming-table">
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

                <tbody id="incomingRequestTable">

                    @forelse ($requests as $request)
                        <tr>
                            <td class="incoming-request-id">
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
                                <span class="incoming-status">
                                    {{ ucfirst($request->status ?? 'Pending') }}
                                </span>
                            </td>

                            <td>
                                <a
                                    class="incoming-review-btn"
                                    href="{{ url('/staff/requests/' . $request->id) }}"
                                >
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr id="incomingEmptyRow">
                            <td colspan="6">
                                <div class="incoming-empty">
                                    <i class="bx bx-inbox"></i>
                                    <h4>No pending requests</h4>
                                    <p>New requests awaiting review will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="incomingSearchEmpty" hidden>
                        <td colspan="6">
                            <div class="incoming-empty">
                                <i class="bx bx-search-alt"></i>
                                <h4>No matching requests</h4>
                                <p>Try another resident name, service, or request ID.</p>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <p class="incoming-table-note">
            Showing pending requests only.
        </p>

    </section>

</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/staff/incoming.js') }}" defer></script>
@endpush
