
@extends('layouts.dashstaff')

@section('title', 'Manage Service - eBarangay')
@section('page-heading', 'Manage Service')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/services.css') }}">
@endpush

@section('content')
<div class="services-page">
    <div class="page-heading">
        <div>
            <h1>Manage Service</h1>
            <p>Edit the service details and required documents.</p>
        </div>

        <a href="{{ route('staff.services.index') }}" class="view-btn">
            Back to Services
        </a>
    </div>

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <section class="service-card">
        <form action="{{ route('staff.services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="name">Service Name</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $service->name) }}" required maxlength="255">

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $service->description) }}</textarea>

            <label for="requirements">Required Documents</label>
            <textarea id="requirements" name="requirements" rows="6"
                      placeholder="One document per line">{{ old('requirements', $service->requirements) }}</textarea>

            <label for="is_active">Service Status</label>
            <select id="is_active" name="is_active" required>
                <option value="1" @selected((string) old('is_active', (int) $service->is_active) === '1')>Active</option>
                <option value="0" @selected((string) old('is_active', (int) $service->is_active) === '0')>Inactive</option>
            </select>

            <div class="modal-actions">
                <a href="{{ route('staff.services.index') }}" class="view-btn">Cancel</a>
                <button type="submit" class="primary-btn">Save Changes</button>
            </div>
        </form>
    </section>
</div>
@endsection
