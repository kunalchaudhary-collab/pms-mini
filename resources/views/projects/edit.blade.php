@extends('layouts.app')
@section('content')
<h2>Edit Project</h2>
<form method="POST" action="{{ route('projects.update',$project) }}">
    @csrf @method('PUT')
    <div><label>Title</label><br><input name="title" value="{{ old('title',$project->title) }}"></div>
    <div><label>Description</label><br><textarea name="description">{{ old('description',$project->description) }}</textarea></div>
    <div><button>Update</button></div>
</form>
@endsection
