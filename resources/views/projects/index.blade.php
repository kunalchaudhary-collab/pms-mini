@extends('layouts.app')
@section('content')
<h2>Your Projects</h2>
<form method="GET">
    <input name="search" value="{{ request('search') }}" placeholder="Search">
    <button>Search</button>
</form>
<p><a href="{{ route('projects.create') }}">Create Project</a></p>
<ul>
@foreach($projects as $p)
    <li><a href="{{ route('projects.show', $p) }}">{{ $p->title }}</a> — <a href="{{ route('projects.edit',$p) }}">Edit</a> 
        <form action="{{ route('projects.destroy',$p) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </li>
@endforeach
</ul>
@endsection
