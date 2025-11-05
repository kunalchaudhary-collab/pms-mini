@extends('layouts.app')
@section('content')
<h2>Activity Logs</h2>
<form method="GET">
    <input name="search" placeholder="Search action" value="{{ request('search') }}">
    <button>Search</button>
</form>
@foreach($logs as $log)
    <div style="border-bottom:1px solid #ddd;padding:6px 0;">
        <b>{{ $log->action }}</b> — <small>{{ $log->created_at->diffForHumans() }}</small>
        @if($log->data)
            <pre>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>
@endforeach

{{ $logs->links() }}
@endsection
