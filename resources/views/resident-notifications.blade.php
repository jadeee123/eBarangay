@extends('layouts.dashboard')

@section('title', 'Notifications - eBarangay')

@section('content')
<div class="notifications-page">
    <h2>Notifications</h2>
    <p>Updates about your submitted barangay requests.</p>

    <p>
        Unread notifications:
        <strong>{{ $unreadCount }}</strong>
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @forelse ($notifications as $notification)
        <div class="notification-item"
             style="{{ $notification->is_read ? 'opacity: 0.7;' : '' }}">

            <h3>{{ $notification->title }}</h3>

            <p>{{ $notification->message }}</p>

            <small>
                {{ \Carbon\Carbon::parse($notification->created_at)->format('M d, Y h:i A') }}
            </small>

            @if (!$notification->is_read)
                <form
                    action="{{ route('resident-notifications.read', $notification->id) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit">Mark as Read</button>
                </form>
            @else
                <p>Already read</p>
            @endif
        </div>

        <hr>
    @empty
        <p>No notifications yet.</p>
        <p>Your request status updates and claim dates will appear here.</p>
    @endforelse
</div>
@endsection