@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Tasks</h2>

    <div class="mb-3">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
    </div>

    @if($tasks->isEmpty())
        <p>No tasks available.</p>
    @else
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Assignee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->project->title ?? '—' }}</td>
                        <td>
                            <span class="badge 
                                @if($task->status === 'completed') bg-success
                                @elseif($task->status === 'pending') bg-warning
                                @else bg-secondary
                                @endif
                            ">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        <td>{{ $task->assignee?->name ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
