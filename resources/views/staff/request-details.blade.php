
@extends('layouts.dashstaff')

@section('title', 'Review Request - eBarangay')
@section('page-heading', 'Review Request')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/incoming.css') }}">
@endpush

@section('content')

<section class="incoming-page">

    <div class="incoming-heading">
        <div>
            <h2>Request Details</h2>
            <p>Review the resident's submitted information and documents.</p>
        </div>

        <a href="{{ url('/staff/requests/incoming') }}">
            Back to Incoming Requests
        </a>
    </div>

    <section class="incoming-panel">

        <div class="incoming-panel-heading">
            <div>
                <h3>
                    Request #SR-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}
                </h3>
                <p>Submitted information from the resident</p>
            </div>

            <span class="incoming-status">
                {{ ucfirst($request->status ?? 'Pending') }}
            </span>
        </div>

        <hr>

        <h3>Personal Information</h3>

        <p><strong>Full Name:</strong>
            {{ $request->full_name ?? $request->resident_name ?? 'Not provided' }}
        </p>

        <p><strong>Date of Birth:</strong>
            {{ $request->birth_date ?? 'Not provided' }}
        </p>

        <p><strong>Gender:</strong>
            {{ $request->gender ?? 'Not provided' }}
        </p>

        <p><strong>Contact Number:</strong>
            {{ $request->contact_number ?? 'Not provided' }}
        </p>

        <p><strong>Email Address:</strong>
            {{ $request->email ?? 'Not provided' }}
        </p>

        <p><strong>Home Address:</strong>
            {{ $request->address ?? 'Not provided' }}
        </p>

        <hr>

        <h3>Request Information</h3>

        <p><strong>Service Requested:</strong>
            {{ ucwords(str_replace('-', ' ', $request->service_name ?? '')) }}
        </p>

        <p><strong>Purpose:</strong>
            {{ $request->purpose ?? 'Not provided' }}
        </p>

        <p><strong>Additional Details:</strong></p>

        <p>
            {{ $request->details ?? $request->description ?? 'No additional details provided.' }}
        </p>

        <p><strong>Date Submitted:</strong>
            {{ $request->created_at
                ? \Carbon\Carbon::parse($request->created_at)->format('F d, Y h:i A')
                : 'Not available' }}
        </p>

        <p><strong>Claim Date:</strong>
            {{ $request->claim_date
                ? \Carbon\Carbon::parse($request->claim_date)->format('F d, Y')
                : 'Not scheduled' }}
        </p>

        <hr>

        <h3>Supporting Document</h3>

        @if (!empty($request->document))
            <p>
                Document reference: {{ $request->document }}
            </p>
        @else
            <p>No document recorded for this request.</p>
        @endif

        <hr>

        <h3>Update Request Status</h3>

        <form
            method="POST"
            action="{{ route('staff.requests.updateStatus', $request->id) }}"
        >
            @csrf
            @method('PATCH')

            <label for="status">Request Status</label>


<label for="claim_date">Claim Date</label>

<input
    type="date"
    name="claim_date"
    id="claim_date"
    value="{{ old('claim_date', $request->claim_date ? \Carbon\Carbon::parse($request->claim_date)->format('Y-m-d') : '') }}"
>

<label for="status">Request Status</label>


            <select name="status" id="status" required>
                @foreach (['Pending', 'Processing', 'Approved', 'Completed', 'Rejected'] as $status)
                    <option
                        value="{{ $status }}"
                        {{ strtolower($request->status ?? 'pending') === strtolower($status) ? 'selected' : '' }}
                    >
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="incoming-review-btn">
                Save Status
            </button>
        </form>

    </section>

</section>
@endsection
