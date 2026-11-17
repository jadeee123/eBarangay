@extends('layouts.dashstaff')

@section('title', 'Staff Dashboard - eBarangay')
@section('page-heading', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/dashboard.css') }}">
@endpush

@section('content')

@php
    $totalRequests = $totalRequests ?? 0;
    $pendingRequests = $pendingRequests ?? 0;
    $processingRequests = $processingRequests ?? 0;
    $completedRequests = $completedRequests ?? 0;
    $maleResidents = $maleResidents ?? 0;
    $femaleResidents = $femaleResidents ?? 0;
@endphp

<section class="staff-dashboard">

    <!-- WELCOME -->
    <section class="dashboard-welcome">
        <div>
            <span class="dashboard-eyebrow">STAFF OVERVIEW</span>
            <h2>Good day, Staff!</h2>
            <p>Here's an overview of your barangay service requests.</p>
        </div>
    </section>

    <!-- REQUEST STATISTICS -->
    <section class="dashboard-stats">

        <button type="button" class="dashboard-stat active"
                data-filter="all">
            <span class="stat-icon"><i class="bx bx-file"></i></span>
            <span class="stat-label">Total Requests</span>
            <strong>{{ $totalRequests }}</strong>
            <small>All submitted requests</small>
        </button>

        <button type="button" class="dashboard-stat"
                data-filter="pending">
            <span class="stat-icon"><i class="bx bx-time-five"></i></span>
            <span class="stat-label">Pending</span>
            <strong>{{ $pendingRequests }}</strong>
            <small>Awaiting review</small>
        </button>

        <button type="button" class="dashboard-stat"
                data-filter="processing">
            <span class="stat-icon"><i class="bx bx-loader-circle"></i></span>
            <span class="stat-label">Processing</span>
            <strong>{{ $processingRequests }}</strong>
            <small>Currently in progress</small>
        </button>

        <button type="button" class="dashboard-stat"
                data-filter="completed">
            <span class="stat-icon"><i class="bx bx-check-circle"></i></span>
            <span class="stat-label">Completed</span>
            <strong>{{ $completedRequests }}</strong>
            <small>Finished requests</small>
        </button>

    </section>

    <!-- MAIN DASHBOARD GRID -->
    <div class="dashboard-grid">

        <div class="dashboard-left">

            <!-- FREQUENT SERVICES -->
            <section class="dashboard-panel">
                <div class="panel-heading">
                    <div>
                        <h3>Frequently Requested</h3>
                        <p>Most requested barangay services</p>
                    </div>
                </div>

                <div class="service-list">
                    @forelse(($frequentServices ?? collect()) as $service)
                        <div class="service-item">
                            <div class="service-info">
                                <span>{{ $service->service_name }}</span>
                                <strong>{{ $service->total }}</strong>
                            </div>

                            <div class="service-progress">
                                <div class="service-progress-fill"
                                     style="width: {{ min(100, max(0, (float) ($service->percentage ?? 0))) }}%">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-empty">
                            <i class="bx bx-bar-chart-alt-2"></i>
                            <h4>No service data yet</h4>
                            <p>Service statistics will appear when requests are submitted.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- RECENT REQUESTS -->
            <section class="dashboard-panel">
                <div class="panel-heading">
                    <div>
                        <h3>Recent Service Requests</h3>
                        <p>Review and manage resident requests.</p>
                    </div>

                    <a class="dashboard-view-all"
                       href="{{ url('/staff/requests') }}">
                        View All <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>

                <div class="dashboard-table-wrap">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Resident</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="staffRequestTable">
                            @forelse(($recentRequests ?? collect()) as $request)
                                @php
                                    $requestStatus = strtolower($request->status ?? 'pending');
                                    $residentName = $request->resident_name
                                        ?? optional($request->user)->name
                                        ?? 'Resident';
                                @endphp

                                <tr data-status="{{ $requestStatus }}">
                                    <td>
                                        #SR-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}
                                    </td>

                                    <td>{{ $residentName }}</td>

                                    <td>
                                        {{ ucwords(str_replace('-', ' ', $request->service_name ?? '')) }}
                                    </td>

                                    <td>
                                        <span class="request-status status-{{ preg_replace('/[^a-z0-9-]/', '', $requestStatus) }}">
                                            {{ ucfirst($request->status ?? 'Pending') }}
                                        </span>
                                    </td>

                                    <td>
                                        <a class="request-view-link"
                                           href="{{ url('/staff/requests/' . $request->id) }}">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="dashboard-empty-row">
                                    <td colspan="5">
                                        <div class="dashboard-empty">
                                            <i class="bx bx-inbox"></i>
                                            <h4>No requests yet</h4>
                                            <p>New resident requests will appear here.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <p id="staffFilterEmpty" class="filter-empty" hidden>
                        No requests match this status.
                    </p>
                </div>
            </section>

        </div>

        <aside class="dashboard-right">

            <!-- QUICK ACTIONS -->
            <section class="dashboard-panel">
                <div class="panel-heading">
                    <div>
                        <h3>Quick Actions</h3>
                        <p>Common staff tasks</p>
                    </div>
                </div>

                <div class="quick-action-list">

                    <a href="{{ url('/staff/requests/incoming') }}"
                       class="quick-action">
                        <span class="quick-action-icon">
                            <i class="bx bx-inbox"></i>
                        </span>
                        <span>
                            <strong>Review Requests</strong>
                            <small>Check submitted requests</small>
                        </span>
                        <i class="bx bx-chevron-right quick-arrow"></i>
                    </a>

                    <a href="{{ url('/staff/requests') }}"
                       class="quick-action">
                        <span class="quick-action-icon">
                            <i class="bx bx-edit"></i>
                        </span>
                        <span>
                            <strong>Update Status</strong>
                            <small>Manage request progress</small>
                        </span>
                        <i class="bx bx-chevron-right quick-arrow"></i>
                    </a>

                    <a href="{{ url('/staff/documents') }}"
                       class="quick-action">
                        <span class="quick-action-icon">
                            <i class="bx bx-calendar"></i>
                        </span>
                        <span>
                            <strong>Claim Schedule</strong>
                            <small>View scheduled claims</small>
                        </span>
                        <i class="bx bx-chevron-right quick-arrow"></i>
                    </a>

                    <a href="{{ url('/staff/reports') }}"
                       class="quick-action">
                        <span class="quick-action-icon">
                            <i class="bx bx-bar-chart-alt-2"></i>
                        </span>
                        <span>
                            <strong>View Reports</strong>
                            <small>Check service activity</small>
                        </span>
                        <i class="bx bx-chevron-right quick-arrow"></i>
                    </a>

                </div>
            </section>

          
{{-- AGE REPORT --}}
<section class="dashboard-panel">
    <div class="panel-heading">
        <div>
            <h3>Age Report</h3>
            <p>Residents grouped by age</p>
        </div>
    </div>

    @if (($age0to17 + $age18to30 + $age31to59 + $age60Plus) > 0)
        <div class="gender-chart-container">
            <canvas id="staffAgeChart"
                    aria-label="Resident age report"
                    role="img"></canvas>
        </div>

        <div class="gender-legend">
            <div>
                <span class="legend-dot male-dot"></span>
                <span>0–17 years</span>
                <strong>{{ $age0to17 }}</strong>
            </div>

            <div>
                <span class="legend-dot female-dot"></span>
                <span>18–30 years</span>
                <strong>{{ $age18to30 }}</strong>
            </div>

            <div>
                <span class="legend-dot male-dot"></span>
                <span>31–59 years</span>
                <strong>{{ $age31to59 }}</strong>
            </div>

            <div>
                <span class="legend-dot female-dot"></span>
                <span>60+ years</span>
                <strong>{{ $age60Plus }}</strong>
            </div>
        </div>
    @else
        <div class="dashboard-empty">
            <i class="bx bx-pie-chart-alt-2"></i>
            <h4>No age data yet</h4>
            <p>The report will appear when resident age data is available.</p>
        </div>
    @endif
</section>


        </aside>
    </div>

    <!-- STAFF REMINDER -->
    <section class="dashboard-reminder">
        <i class="bx bx-info-circle"></i>
        <div>
            <h3>Staff Reminder</h3>
            <p>
                Review submitted information and required documents
                before updating a request's status.
            </p>
        </div>
    </section>

</section>
@endsection

@push('scripts')
    @if (($maleResidents + $femaleResidents) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif

    <script src="{{ asset('js/staff/dashboard.js') }}" defer></script>
@endpush
