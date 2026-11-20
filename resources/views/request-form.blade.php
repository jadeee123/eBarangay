
@extends('layouts.dashboard')

@section('title', 'Request Form - eBarangay')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/request-form.css') }}">
@endpush

@section('content')

@php
    $selectedService = request('service', 'barangay-clearance');

    $serviceSlugs = [
        'Barangay Clearance' => 'barangay-clearance',
        'Scholarship Application' => 'scholarship-application',
        'Certificate of Indigency' => 'certificate-indigency',
        'Business Clearance' => 'business-clearance',
        'Other Services' => 'other-services',
    ];
@endphp

<div class="request-form-page">

    <div class="request-page-heading">
        <a href="{{ url('/request') }}" class="back-link">
            <i class="bx bx-arrow-back"></i>
            Back to Services
        </a>

        <h1>Request Form</h1>
        <p>Complete the information below to submit your barangay service request.</p>
    </div>

    <form class="request-form" id="requestForm"
          action="{{ route('requests.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        <section class="form-section selected-service">
            <div class="section-heading">
                <div class="section-icon">
                    <i class="bx bx-file"></i>
                </div>
                <div>
                    <h2>Selected Service</h2>
                    <p>Check the service you want to request.</p>
                </div>
            </div>

            <label for="service">Barangay Service <span>*</span></label>

            <select name="service" id="service" required>
                @foreach ($services as $service)
                    @php
                        $serviceValue = $serviceSlugs[$service->name]
                            ?? \Illuminate\Support\Str::slug($service->name);
                    @endphp

                    <option value="{{ $serviceValue }}"
                        {{ $selectedService === $serviceValue ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>

            <div class="service-requirements" id="serviceRequirements">
                <h3>Required Documents</h3>

                @foreach ($services as $service)
                    @php
                        $serviceValue = $serviceSlugs[$service->name]
                            ?? \Illuminate\Support\Str::slug($service->name);

                        $requirements = preg_split(
                            '/\r\n|\r|\n/',
                            $service->requirements ?? '',
                            -1,
                            PREG_SPLIT_NO_EMPTY
                        );
                    @endphp

                    <div class="requirements-list"
                         data-service="{{ $serviceValue }}"
                         @if ($selectedService !== $serviceValue) hidden @endif>

                        @if (count($requirements))
                            <ul>
                                @foreach ($requirements as $requirement)
                                    <li>{{ trim($requirement) }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>No requirements listed for this service yet.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <section class="form-section">
            <div class="section-heading">
                <div class="section-icon">
                    <i class="bx bx-user"></i>
                </div>
                <div>
                    <h2>Resident Information</h2>
                    <p>Provide your personal information.</p>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="full_name">Full Name <span>*</span></label>
                    <input type="text" id="full_name" name="full_name"
                           value="{{ old('full_name') }}"
                           placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number <span>*</span></label>
                    <input type="tel" id="contact_number" name="contact_number"
                           value="{{ old('contact_number') }}"
                           placeholder="e.g. 09XXXXXXXXX" required>
                </div>

                <div class="form-group">
                    <label for="gender">Gender <span>*</span></label>
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="Enter your email address">
                </div>

                <div class="form-group">
                    <label for="birth_date">Date of Birth <span>*</span></label>
                    <input type="date" id="birth_date" name="birth_date"
                           value="{{ old('birth_date') }}"
                           required>
                </div>

                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age"
                           placeholder="Age will calculate automatically"
                           value="{{ old('age') }}"
                           readonly>
                </div>

                <div class="form-group full-width">
                    <label for="address">Complete Address <span>*</span></label>
                    <textarea id="address" name="address" rows="3"
                              placeholder="House number, street, and barangay"
                              required>{{ old('address') }}</textarea>
                </div>
            </div>
        </section>

        <section class="form-section">
            <div class="section-heading">
                <div class="section-icon">
                    <i class="bx bx-detail"></i>
                </div>
                <div>
                    <h2>Request Details</h2>
                    <p>Tell us why you need this service.</p>
                </div>
            </div>

            <div class="form-group">
                <label for="purpose">Purpose of Request <span>*</span></label>
                <input type="text" id="purpose" name="purpose"
                       value="{{ old('purpose') }}"
                       placeholder="e.g. Employment, school requirement"
                       required>
            </div>

            <div class="form-group">
                <label for="details">Additional Information</label>
                <textarea id="details" name="details" rows="4"
                          placeholder="Enter any additional information (optional)">{{ old('details') }}</textarea>
            </div>

            <div class="form-group">
                <label for="document">Supporting Documents</label>
                <input type="file" id="document" name="document"
                       accept=".pdf,.jpg,.jpeg,.png">
                <small>Optional. Accepted formats: PDF, JPG, and PNG.</small>
            </div>
        </section>

        <div class="form-notice">
            <i class="bx bx-info-circle"></i>
            <p>Please check your information before submitting your request.</p>
        </div>

        <div class="form-actions">
            <a href="{{ url('/request') }}" class="cancel-btn">Cancel</a>

            <button type="submit" class="submit-btn">
                <i class="bx bx-send"></i>
                Submit Request
            </button>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Automatically calculate the resident's age.
    const birthDate = document.getElementById('birth_date');
    const ageInput = document.getElementById('age');

    function calculateAge() {
        if (!birthDate.value) {
            ageInput.value = '';
            return;
        }

        const birth = new Date(birthDate.value + 'T00:00:00');
        const today = new Date();

        let age = today.getFullYear() - birth.getFullYear();

        if (
            today.getMonth() < birth.getMonth() ||
            (today.getMonth() === birth.getMonth() &&
             today.getDate() < birth.getDate())
        ) {
            age--;
        }

        ageInput.value = age >= 0 ? age : '';
    }

    birthDate.addEventListener('input', calculateAge);
    birthDate.addEventListener('change', calculateAge);

    calculateAge();

    // Show the requirements for the selected service.
    const serviceSelect = document.getElementById('service');
    const requirementLists = document.querySelectorAll('.requirements-list');

    function updateRequirements() {
        const selectedService = serviceSelect.value;

        requirementLists.forEach(function (list) {
            list.hidden = list.dataset.service !== selectedService;
        });
    }

    serviceSelect.addEventListener('change', updateRequirements);

    updateRequirements();
});
</script>

@endsection
