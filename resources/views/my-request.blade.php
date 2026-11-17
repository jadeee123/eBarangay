
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

        <button
            type="button"
            class="request-filter-btn"
            id="requestFilterBtn"
            aria-label="Show filters"
            title="Filter requests"
        >
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
                <option value="approved">Approved</option>
                <option value="cancelled">Cancelled</option>
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
                    @forelse ($requests as $request)
                        <tr
                            data-status="{{ strtolower($request->status) }}"
                            data-date="{{ $request->created_at ? \Carbon\Carbon::parse($request->created_at)->format('Y-m-d') : '' }}"
                            data-claim-date="{{ $request->claim_date ? 'yes' : 'no' }}"
                        >
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ ucwords(str_replace('-', ' ', $request->service_name)) }}
                            </td>

                            <td>
                                {{ $request->created_at ? \Carbon\Carbon::parse($request->created_at)->format('M d, Y') : 'N/A' }}
                            </td>

                            <td>
                                <span class="status-badge {{ strtolower($request->status) }}">
                                    {{ $request->status }}
                                </span>
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="view-request-btn"
                                    onclick="openRequestModal(this)"
                                    data-id="{{ $request->id }}"
                                    data-service="{{ $request->service_name }}"
                                    data-description="{{ $request->description }}"
                                    data-status="{{ $request->status }}"
                                    data-submitted="{{ $request->created_at }}"
                                    data-claim-date="{{ $request->claim_date ?? '' }}"
                                    data-feedback-rating="{{ $request->feedback_rating ?? '' }}"
                                    data-feedback-comment="{{ $request->feedback_comment ?? '' }}"
                                >
                                    View
                                </button>

                                @if (strtolower($request->status) === 'pending')
                                    <form
                                        action="{{ route('requests.cancel', $request->id) }}"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Are you sure you want to cancel this request?');"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="cancel-request-btn"
                                        >
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- The empty-state section below handles this case. --}}
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="empty-state" id="emptyState" @if($requests->isNotEmpty()) hidden @endif>
            <div class="empty-icon">
                <i class='bx bx-folder-open'></i>
            </div>

            <h3>No requests submitted yet</h3>
            <p>Your submitted requests will appear here.</p>

            <a
                href="{{ route('requests.create', ['service' => 'barangay-clearance']) }}"
                class="submit-request-btn"
            >
                <i class='bx bx-plus'></i>
                Submit a Request
            </a>
        </div>
    </div>

    <!-- Request Details Modal -->
    <div id="requestModal" class="request-modal" style="display: none;">
        <div class="request-modal-content">

            <div class="request-modal-header">
                <div>
                    <h2>Request Details</h2>
                    <p id="modalRequestId"></p>
                </div>

                <button
                    type="button"
                    class="close-request-modal"
                    onclick="closeRequestModal()"
                    aria-label="Close request details"
                >
                    &times;
                </button>
            </div>

            <div class="request-modal-body">

                <div class="request-detail-row">
                    <span>Service</span>
                    <strong id="modalService"></strong>
                </div>

                <div class="request-detail-row">
                    <span>Date Submitted</span>
                    <strong id="modalSubmitted"></strong>
                </div>

                <div class="request-detail-row">
                    <span>Status</span>
                    <strong id="modalStatus"></strong>
                </div>

                <div class="request-detail-row">
                    <span>Claim Date</span>
                    <strong id="modalClaimDate"></strong>
                </div>

                <div class="request-description">
                    <h3>Request Description</h3>
                    <p id="modalDescription"></p>
                </div>

                <div class="request-progress">
                    <h3>Request Progress</h3>

                    <div class="progress-step" id="stepSubmitted">
                        <span class="progress-dot"></span>
                        <div>
                            <strong>Request Submitted</strong>
                            <p>Your request has been submitted.</p>
                        </div>
                    </div>

                    <div class="progress-step" id="stepReview">
                        <span class="progress-dot"></span>
                        <div>
                            <strong>Under Review</strong>
                            <p>Barangay staff are reviewing your request.</p>
                        </div>
                    </div>

                    <div class="progress-step" id="stepClaim">
                        <span class="progress-dot"></span>
                        <div>
                            <strong id="claimStepTitle">Ready for Claim</strong>
                            <p id="modalClaimInstructions">
                                Your request is awaiting processing.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="request-feedback"
                    id="requestFeedbackSection"
                    style="display: none;"
                >
                    <h3>Rate Your Experience</h3>
                    <p>How was your experience with this barangay service?</p>

                    <form id="feedbackForm" method="POST" action="">
                        @csrf

                        <div class="star-rating">
                            @for ($star = 5; $star >= 1; $star--)
                                <input
                                    type="radio"
                                    id="rating{{ $star }}"
                                    name="rating"
                                    value="{{ $star }}"
                                    required
                                >
                                <label
                                    for="rating{{ $star }}"
                                    title="{{ $star }} stars"
                                >★</label>
                            @endfor
                        </div>

                        <div class="form-group">
                            <label for="feedbackComment">Comment (Optional)</label>
                            <textarea
                                id="feedbackComment"
                                name="comment"
                                rows="3"
                                maxlength="1000"
                                placeholder="Share your experience..."
                            ></textarea>
                        </div>

                        <button type="submit" class="submit-feedback-btn">
                            Submit Feedback
                        </button>
                    </form>

                    <p id="feedbackAlreadySubmitted" style="display: none;">
                        Thank you! You have already submitted feedback for this request.
                    </p>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/my-request.js') }}" defer></script>
@endpush
