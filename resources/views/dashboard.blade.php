@extends('layouts.app')

@section('content')
    <div class="dashboard">
        <!-- === Dashboard Summary === -->
        <div class="dashboard-header">
            <h2>Dashboard</h2>
            <p class="subtitle">Welcome back, {{ auth()->user()->name ?? 'User' }} 👋</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h4>Total Projects</h4>
                <p class="stat-value">{{ $projects }}</p>
            </div>
            <div class="stat-card">
                <h4>Total Tasks</h4>
                <p class="stat-value">{{ $tasks }}</p>
            </div>
            <div class="stat-card">
                <h4>To Do</h4>
                <p class="stat-value todo">{{ $todo }}</p>
            </div>
            <div class="stat-card">
                <h4>In Progress</h4>
                <p class="stat-value inprogress">{{ $inprogress }}</p>
            </div>
            <div class="stat-card">
                <h4>Completed</h4>
                <p class="stat-value completed">{{ $completed }}</p>
            </div>
        </div>

        <!-- === Recent Activity === -->
        <div class="section">
            <h3>Recent Activity</h3>
            <ul class="activity-list">
                @forelse ($logs as $log)
                    <li class="activity-item">
                        <div class="activity-header">
                            <small>{{ $log->action }}</small>
                            <small>{{ $log->created_at->diffForHumans() }}</small>
                        </div>

                    </li>
                @empty
                    <p class="no-data">No recent activity found.</p>
                @endforelse
            </ul>
        </div>

        <hr>
        <hr>
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
