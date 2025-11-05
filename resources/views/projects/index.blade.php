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
</div>
@endsection
