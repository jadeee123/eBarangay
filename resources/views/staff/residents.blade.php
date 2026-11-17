@extends('layouts.dashstaff')

@section('title', 'Residents - eBarangay')
@section('page-heading', 'Residents')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/residents.css') }}">
@endpush

@section('content')
<section class="residents-page">

    <div class="residents-heading">
        <div>
            <h2>Residents</h2>
            <p>View registered residents in the eBarangay system.</p>
        </div>
    </div>

    <section class="residents-panel">

        <div class="residents-toolbar">
            <div class="residents-search">
                <i class="bx bx-search"></i>
                <input
                    type="search"
                    id="residentSearch"
                    placeholder="Search by name or email..."
                    aria-label="Search residents"
                >
            </div>

            <span class="residents-count">
                {{ $residents->count() }}
                {{ $residents->count() === 1 ? 'Resident' : 'Residents' }}
            </span>
        </div>

        <div class="residents-table-wrap">
            <table class="residents-table">
                <thead>
                    <tr>
                        <th>Resident ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Date Registered</th>
                    </tr>
                </thead>

                <tbody id="residentsTable">
                    @forelse ($residents as $resident)
                        <tr>
                            <td>
                                RES-{{ str_pad($resident->id, 4, '0', STR_PAD_LEFT) }}
                            </td>

                            <td>{{ $resident->name }}</td>

                            <td>{{ $resident->email }}</td>

                            <td>{{ $resident->contact_number ?? '—' }}</td>

                            <td>
                                {{ $resident->created_at
                                    ? \Carbon\Carbon::parse($resident->created_at)->format('M d, Y')
                                    : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr id="residentsEmptyRow">
                            <td colspan="5">
                                <div class="residents-empty">
                                    <i class="bx bx-group"></i>
                                    <h3>No residents found</h3>
                                    <p>Registered accounts will appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="residentsSearchEmpty" hidden>
                        <td colspan="5">
                            <div class="residents-empty">
                                <i class="bx bx-search"></i>
                                <h3>No matching residents</h3>
                                <p>Try searching with another name or email.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/staff/residents.js') }}" defer></script>
@endpush
