@extends('layouts.app')
@section('content')
<h2>{{ $project->title }}</h2>
<p>{{ $project->description }}</p>

<h3>Tasks</h3>
<p><a href="{{ route('tasks.create') }}">Create Task</a></p>
<ul>
@foreach($project->tasks as $task)
    <li>
        <b>{{ $task->title }}</b> — Status: 
        <select class="task-status" data-id="{{ $task->id }}">
            <option value="todo" {{ $task->status=='todo'?'selected':'' }}>To Do</option>
            <option value="inprogress" {{ $task->status=='inprogress'?'selected':'' }}>In Progress</option>
            <option value="completed" {{ $task->status=='completed'?'selected':'' }}>Completed</option>
        </select>
        — Assigned: {{ $task->assignee?->name ?? 'N/A' }}
        — <a href="{{ route('tasks.edit',$task) }}">Edit</a>
        <form action="{{ route('tasks.destroy',$task) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button>Delete</button>
        </form>
    </li>
@endforeach
</ul>

<h3>Comments</h3>
<div id="comments">
@foreach($project->comments as $c)
    <div><b>{{ $c->user->name }}</b>: {{ $c->content }} — <small>{{ $c->created_at->diffForHumans() }}</small></div>
@endforeach
</div>

<h4>Add Comment</h4>
<form id="projectCommentForm">
    @csrf
    <textarea id="commentText" rows="3" cols="50"></textarea><br>
    <button id="postComment" type="button">Post Comment</button>
</form>

@push('scripts')
<script>
$('.task-status').change(function(){
    var id = $(this).data('id');
    var status = $(this).val();
    $.post('/tasks/'+id+'/status', {_token:'{{ csrf_token() }}', status: status}, function(resp){
        if (resp.success) alert('Status updated');
    });
});

$('#postComment').click(function(){
    $.post('{{ route('comment.store') }}', {
        _token: '{{ csrf_token() }}',
        project_id: '{{ $project->id }}',
        content: $('#commentText').val()
    }, function(resp){
        if (resp.user) {
            $('#comments').append('<div><b>'+resp.user+'</b>: '+resp.content+' — <small>'+resp.created_at+'</small></div>');
            $('#commentText').val('');
        }
    });
});
</script>
@endpush

@endsection
