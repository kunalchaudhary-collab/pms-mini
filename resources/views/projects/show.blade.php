@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="project-title">{{ $project->title }}</h2>
    <p class="project-description">{{ $project->description }}</p>

    <div class="tasks-section">
        <h3>Tasks</h3>
        <p><a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a></p>
        <ul class="task-list">
            @foreach($project->tasks as $task)
                <li class="task-item">
                    <b>Task Name : {{ $task->title }}</b> — Status: 
                    <select class="task-status" data-id="{{ $task->id }}">
                        <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>To Do</option>
                        <option value="inprogress" {{ $task->status == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    — Assigned: {{ $task->assignee?->name ?? 'N/A' }}
                    — <a href="{{ route('tasks.edit', $task) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="comments-section">
        <h3>Comments</h3>
        <div id="comments" class="comment-list">
            @foreach($project->comments as $c)
                <div class="comment-item">
                    <b>{{ $c->user->name }}</b>: {{ $c->content }} — <small>{{ $c->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        </div>

        <h4>Add Comment</h4>
        <form id="projectCommentForm">
            @csrf
            <textarea id="commentText" rows="3" cols="50" class="form-control" placeholder="Write your comment..."></textarea><br>
            <button id="postComment" type="button" class="btn btn-success">Post Comment</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Update Task Status
    $('.task-status').change(function(){
        var id = $(this).data('id');
        var status = $(this).val();
        $.post('/tasks/'+id+'/status', {_token:'{{ csrf_token() }}', status: status}, function(resp){
            if (resp.success) alert('Status updated');
        });
    });

    // Post Comment
    $('#postComment').click(function(){
        $.post('{{ route('comment.store') }}', {
            _token: '{{ csrf_token() }}',
            project_id: '{{ $project->id }}',
            content: $('#commentText').val()
        }, function(resp){
            if (resp.user) {
                $('#comments').append('<div class="comment-item"><b>' + resp.user + '</b>: ' + resp.content + ' — <small>' + resp.created_at + '</small></div>');
                $('#commentText').val('');
            }
        });
    });
</script>
@endpush

@endsection

