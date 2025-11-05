@extends('layouts.app')
@section('content')
<h2>Dashboard</h2>
<ul>
    <li>Total Projects (your): {{ $projects }}</li>
    <li>Total Tasks: {{ $tasks }}</li>
    <li>To Do: {{ $todo }}</li>
    <li>In Progress: {{ $inprogress }}</li>
    <li>Completed: {{ $completed }}</li>
</ul>

<h3>Recent Activity</h3>
<ul>
@foreach($logs as $log)
    <li>
        <strong>{{ $log->action }}</strong> — <small>{{ $log->created_at->diffForHumans() }}</small>
        @if($log->data)
            <pre>{{ json_encode($log->data, JSON_PRETTY_PRINT) }}</pre>
        @endif
    </li>
@endforeach
</ul>

<h3>Public Comments</h3>
<ul>
@foreach($comments as $c)
    <li><b>{{ $c->user->name }}</b>: {{ $c->content }} — <small>{{ $c->created_at->diffForHumans() }}</small></li>
@endforeach
</ul>

<h3>Add Public Comment</h3>
<form id="publicCommentForm">
    @csrf
    <textarea name="content" id="publicCommentText" rows="3" cols="50"></textarea><br>
    <button id="postPublicComment" type="button">Post Comment</button>
</form>

@push('scripts')
<script>
$('#postPublicComment').click(function(){
    $.post('{{ route('comment.store') }}',{
        _token: '{{ csrf_token() }}',
        content: $('#publicCommentText').val()
    }, function(resp){
        if (resp.user) {
            alert('Comment posted');
            location.reload();
        }
    });
});
</script>
@endpush

@endsection
