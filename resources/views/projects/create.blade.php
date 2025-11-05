@extends('layouts.app')
@section('content')
<h2>Create Project</h2>
<form method="POST" action="{{ route('projects.store') }}">
    @csrf
    <div><label>Title</label><br><input name="title" value="{{ old('title') }}"></div>
    <div><label>Description</label><br><textarea name="description">{{ old('description') }}</textarea></div>

    <div><button>Create</button></div>
</form>
@endsection
