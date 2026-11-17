@extends('layouts.dashstaff')

@section('title', 'Reports & Analytics - eBarangay')
@section('page-heading', 'Reports & Analytics')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/reports.css') }}">
@endpush

@section('content')
<div class="reports-page">

    <div class="reports-heading">
        <div>
            <h1>Reports &amp; Analytics</h1>
            <p>View insights and reports of barangay services.</p>
        </div>

        <form method="GET" action="{{ route('staff.reports') }}">
            <label class="sr-only" for="reportPeriod">Date range</label>
            <select id="reportPeriod" name="period" onchange="this.form.submit()">
                <option value="7" @selected($period === 7)>Last 7 Days</option>
                <option value="30" @selected($period === 30)>Last 30 Days</option>
                <option value="90" @selected($period === 90)>Last 90 Days</option>
            </select>
        </form>
    </div>

    <div class="reports-summary">
        <span>Total Requests in Period</span>
        <strong>{{ number_format($totalRequests) }}</strong>
    </div>

    <div class="analytics-grid">

        {{-- Request Trends --}}
        <section class="analytics-card trends-card">
            <div class="analytics-card-heading">
                <div>
                    <h2>Request Trends</h2>
                    <p>Daily requests submitted</p>
                </div>
            </div>

            <div class="trend-chart-container">
                <canvas
                    id="requestTrendsChart"
                    data-period="{{ $period }}"
                    data-trends="{{ $requestTrends->toJson() }}"
                    aria-label="Daily request trends"
                    role="img">
                </canvas>
            </div>
        </section>

        {{-- Top Services --}}
        <section class="analytics-card services-card">
            <div class="analytics-card-heading">
                <div>
                    <h2>Top Services</h2>
                    <p>Requests by service</p>
                </div>
            </div>

            <div class="services-chart-layout">
                <div class="donut-chart-container">
                    <canvas
                        id="topServicesChart"
                        data-services="{{ $topServices->toJson() }}"
                        aria-label="Request distribution by service"
                        role="img">
                    </canvas>
                </div>

                <div id="serviceLegend" class="service-legend"></div>
            </div>

            <p id="noServicesMessage" class="no-data-message"
               @if ($topServices->isNotEmpty()) hidden @endif>
                No service requests recorded in this period.
            </p>
        </section>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/staff/reports.js') }}" defer></script>
@endpush
