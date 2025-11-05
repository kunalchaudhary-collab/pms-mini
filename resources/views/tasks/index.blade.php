@extends('layouts.app')
@section('content')
<h2>All Tasks</h2>
<p><a href="{{ route('tasks.create') }}">Create Task</a></p>
<ul>
@foreach($tasks as $t)
    <li>{{ $t->title }} ({{ $t->project->title ?? '—' }}) — {{ $t->status }} — Assigned: {{ $t->assignee?->name ?? 'N/A' }} — <a href="{{ route('tasks.edit',$t) }}">Edit</a></li>
@endforeach
</ul>
@endsection
