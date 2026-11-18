@extends('layouts.dashstaff')

@section('title', 'Announcements - eBarangay')
@section('page-heading', 'Announcements')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff/announcements.css') }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="announcements-page">

    <div class="page-heading">
        <div>
            <h1>Announcements</h1>
            <p>Create and manage barangay announcements for residents.</p>
        </div>

        <button type="button" class="primary-btn" id="openAddAnnouncement">
            <i class="bx bx-plus"></i>
            Add Announcement
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

    <div class="announcement-grid">
        @forelse ($announcements as $announcement)
            <article class="announcement-card">

                <div class="announcement-card-top">
                    <div class="announcement-card-icon">
                        <i class="bx bx-megaphone"></i>
                    </div>

                    <span class="announcement-status {{ $announcement->is_published ? 'published' : 'draft' }}">
                        {{ $announcement->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>

                <h3>{{ $announcement->title }}</h3>

                <p class="announcement-content">
                    {{ $announcement->content }}
                </p>

                <div class="announcement-meta">
                    @if ($announcement->published_at)
                        <span>
                            <i class="bx bx-calendar"></i>
                            {{ \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') }}
                        </span>
                    @else
                        <span>
                            <i class="bx bx-file"></i>
                            Not published yet
                        </span>
                    @endif
                </div>

                <div class="announcement-card-footer">
                    <button
                        type="button"
                        class="view-btn edit-announcement-btn"
                        data-id="{{ $announcement->id }}"
                        data-title="{{ $announcement->title }}"
                        data-content="{{ $announcement->content }}"
                        data-published="{{ $announcement->is_published ? '1' : '0' }}">
                        <i class="bx bx-edit"></i>
                        Edit
                    </button>

                    <form action="{{ route('staff.announcements.destroy', $announcement->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this announcement?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="delete-btn">
                            <i class="bx bx-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>

            </article>
        @empty
            <div class="empty-state">
                <i class="bx bx-megaphone"></i>
                <h3>No announcements yet</h3>
                <p>Create your first barangay announcement to get started.</p>
            </div>
        @endforelse
    </div>

    {{-- Add Announcement Modal --}}
    <div class="announcement-modal" id="addAnnouncementModal" aria-hidden="true">
        <div class="announcement-modal-content">
            <div class="modal-heading">
                <div>
                    <h2>Create Announcement</h2>
                    <p>Share important information with residents.</p>
                </div>

                <button type="button" class="close-modal" id="closeAddAnnouncement"
                        aria-label="Close">&times;</button>
            </div>

            <form action="{{ route('staff.announcements.store') }}" method="POST">
                @csrf

                <label for="announcementTitle">Announcement Title</label>
                <input type="text" id="announcementTitle" name="title"
                       value="{{ old('title') }}" maxlength="255"
                       placeholder="Enter announcement title" required>

                <label for="announcementContent">Announcement Details</label>
                <textarea id="announcementContent" name="content" rows="5"
                          maxlength="5000" placeholder="Write your announcement here..."
                          required>{{ old('content') }}</textarea>

                <label class="announcement-checkbox">
                    <input type="checkbox" name="is_published" value="1">
                    Publish immediately
                </label>

                <div class="modal-actions">
                    <button type="button" class="cancel-btn" id="cancelAddAnnouncement">
                        Cancel
                    </button>
                    <button type="submit" class="primary-btn">
                        Create Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Announcement Modal --}}
    <div class="announcement-modal" id="editAnnouncementModal" aria-hidden="true">
        <div class="announcement-modal-content">
            <div class="modal-heading">
                <div>
                    <h2>Edit Announcement</h2>
                    <p>Update the details or publication status.</p>
                </div>

                <button type="button" class="close-modal" id="closeEditAnnouncement"
                        aria-label="Close">&times;</button>
            </div>

            <form id="editAnnouncementForm"
            data-update-url="{{ url('/staff/announcements') }}"
            method="POST">

                <label for="editAnnouncementTitle">Announcement Title</label>
                <input type="text" id="editAnnouncementTitle" name="title"
                       maxlength="255" required>

                <label for="editAnnouncementContent">Announcement Details</label>
                <textarea id="editAnnouncementContent" name="content"
                          rows="5" maxlength="5000" required></textarea>

                <label class="announcement-checkbox">
                    <input type="checkbox" id="editAnnouncementPublished"
                           name="is_published" value="1">
                    Published (uncheck to unpublish)
                </label>

                <div class="modal-actions">
                    <button type="button" class="cancel-btn" id="cancelEditAnnouncement">
                        Cancel
                    </button>
                    <button type="submit" class="primary-btn">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/staff/announcements.js') }}" defer></script>
@endpush
