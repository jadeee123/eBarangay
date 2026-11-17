
@extends('layouts.dashstaff')

@section('title', 'Services - eBarangay')
@section('page-heading', 'Services')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/services.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="services-page">

    <div class="page-heading">
        <div>
            <h1>Services</h1>
            <p>Manage available barangay services and their required documents.</p>
        </div>

        <button type="button" class="primary-btn" id="openAddService">
            <i class="fa-solid fa-plus"></i>
            Add Service
        </button>
    </div>

    @if (session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="service-grid">
        @forelse ($services as $service)
            <article class="service-card">
               <div class="service-card-icon">
                <i class="bx bx-file"></i></div>

                <h3>{{ $service->name }}</h3>

                <p>{{ $service->description ?: 'No description provided.' }}</p>

                <div class="service-requirements">
                    <strong>Required Documents</strong>

                    @if ($service->requirements)
                        <ul>
                            @foreach (preg_split('/\r\n|\r|\n/', $service->requirements) as $requirement)
                                @if (trim($requirement) !== '')
                                    <li>{{ $requirement }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p>No requirements added yet.</p>
                    @endif
                </div>

                <div class="service-card-footer">
                    <span class="service-status">
                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                    </span>

                    <a href="{{ route('staff.services.edit', $service->id) }}"
                       class="view-btn">
                        Manage
                    </a>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <i class="fa-solid fa-folder-open"></i>
                <h3>No services available</h3>
                <p>Add your first barangay service to get started.</p>
            </div>
        @endforelse
    </div>

    <div class="service-modal" id="addServiceModal" aria-hidden="true">
        <div class="service-modal-content">
            <div class="modal-heading">
                <div>
                    <h2>Add Service</h2>
                    <p>Enter the service details and required documents.</p>
                </div>

                <button type="button" id="closeAddService" class="close-modal"
                        aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('staff.services.store') }}" method="POST">
                @csrf

                <label for="name">Service Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}" required maxlength="255"
                       placeholder="e.g. Barangay Clearance">

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Describe this service">{{ old('description') }}</textarea>

                <label for="requirements">Required Documents</label>
                <textarea id="requirements" name="requirements" rows="5"
                          placeholder="Write one document per line&#10;Example:&#10;Valid ID&#10;Proof of Residency">{{ old('requirements') }}</textarea>

                <p class="form-hint">Enter each required document on a separate line.</p>

                <div class="modal-actions">
                    <button type="button" class="cancel-btn" id="cancelAddService">
                        Cancel
                    </button>
                    <button type="submit" class="primary-btn">
                        Save Service
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/staff/services.js') }}" defer></script>
@endpush
