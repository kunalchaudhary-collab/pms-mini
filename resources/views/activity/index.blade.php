@extends('layouts.app')
@section('content')
    <h2>Activity Logs</h2>
    <form method="GET">
        <input name="search" placeholder="Search action" value="{{ request('search') }}">
        <button>Search</button>
    </form>
    @forelse ($logs as $log)
        <div style="border-bottom:1px solid #ddd;padding:6px 0;">
            <p>{{ $log->action }}</p> — <small>{{ $log->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p class="no-data">No recent activity found.</p>
    @endforelse
@endsection
