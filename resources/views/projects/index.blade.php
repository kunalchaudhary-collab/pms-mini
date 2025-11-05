@extends('layouts.app')

@section('content')
<div class="projects-page">
    <div class="page-header">
        <h2>Your Projects</h2>
        <p class="subtitle">Manage all your projects efficiently</p>
    </div>

    <!-- === Search & Create === -->
    <div class="project-actions">
        <form method="GET" class="search-form">
            <input 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Search projects..." 
                class="search-input"
            >
            <button class="btn">Search</button>
        </form>

        <a href="{{ route('projects.create') }}" class="btn btn-primary">+ Create Project</a>
    </div>

    <!-- === Projects List === -->
    <div class="projects-list">
        @forelse($projects as $p)
            <div class="project-card">
                <div class="project-info">
                    <h3>
                        <a href="{{ route('projects.show', $p) }}">{{ $p->title }}</a>
                    </h3>
                    @if($p->description)
                        <p class="project-desc">{{ Str::limit($p->description, 120) }}</p>
                    @endif
                </div>

                <div class="project-actions-inline">
                    <a href="{{ route('projects.edit', $p) }}" class="btn btn-sm btn-secondary">Edit</a>
                    <form 
                        action="{{ route('projects.destroy', $p) }}" 
                        method="POST" 
                        class="inline-form"
                        onsubmit="return confirm('Are you sure you want to delete this project?')"
                    >
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="no-data">No projects found. <a href="{{ route('projects.create') }}">Create one?</a></p>
        @endforelse
    </div>
    <hr>
    <hr>
</div>
 <!-- === Public Comments === -->
    <div class="section">
        <h3>Public Comments</h3>
        <div id="CommentsResult" class="comments-list"></div>
    </div>

    <!-- === Add Comment Form === -->
    <div class="section">
        <h3>Add Public Comment</h3>
        <form id="publicCommentForm" class="comment-form">
            @csrf
            <textarea name="content" id="publicCommentText" rows="3" placeholder="Write your comment..."></textarea>
            <button id="postPublicComment" type="button" class="btn">Post Comment</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    function loadComments() {
        $.ajax({
            url: '{{ route('comments.list') }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#CommentsResult').html(response.html);
            }
        });
    }

    loadComments();

    $('#postPublicComment').click(function(e) {
        e.preventDefault();
        let content = $('#publicCommentText').val().trim();
        if (!content) {
            alert('Please enter a comment before posting.');
            return;
        }
        $.post('{{ route('comment.store') }}', {
            _token: '{{ csrf_token() }}',
            content: content
        }, function(resp) {
            if (resp.user) {
                $('#publicCommentText').val('');
                loadComments();
            }
        }).fail(function() {
            alert('Something went wrong while posting your comment.');
        });
    });
});
</script>
@endpush
@endsection
