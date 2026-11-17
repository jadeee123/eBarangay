
@extends('layouts.dashboard')

@section('title', 'Announcements - eBarangay')

@section('content')
<section class="panel announcements dashboard-announcements">

    <div class="panel-heading">
        <h2>
            <i class="bx bxs-megaphone"></i>
            All Announcements
        </h2>

        <a href="{{ route('dashboard') }}">
            Back to Dashboard
        </a>
    </div>

    @forelse ($announcements as $announcement)
        <article class="announcement-item">
            <h3>{{ $announcement->title }}</h3>

            <p>{{ $announcement->content }}</p>

            <small>
                Published:
                {{ \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y h:i A') }}
            </small>
        </article>
    @empty
        <p>No announcements available yet.</p>
    @endforelse

</section>
@endsection
