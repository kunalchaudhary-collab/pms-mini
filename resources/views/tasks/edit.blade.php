@extends('layouts.app')
@section('content')
<div class="container">
<h2>Edit Task</h2>
<form method="POST" action="{{ route('tasks.update',$task) }}">
    @csrf @method('PUT')
    <div><label>Project</label><br>
        <select name="project_id">
            @foreach($projects as $p)
                <option value="{{ $p->id }}" {{ $p->id==$task->project_id?'selected':'' }}>{{ $p->title }}</option>
            @endforeach
        </select>
    </div>
    <div><label>Title</label><br><input name="title" value="{{ $task->title }}"></div>
    <div><label>Description</label><br><textarea name="description">{{ $task->description }}</textarea></div>
    <div><label>Assign to</label><br>
        <select name="assigned_to">
            <option value="">--none--</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ $u->id==$task->assigned_to?'selected':'' }}>{{ $u->name }}</option>
            @endforeach
        </select>
    </div>
    <div><label>Status</label><br>
        <select name="status">
            <option value="todo" {{ $task->status=='todo'?'selected':'' }}>To Do</option>
            <option value="inprogress" {{ $task->status=='inprogress'?'selected':'' }}>In Progress</option>
            <option value="completed" {{ $task->status=='completed'?'selected':'' }}>Completed</option>
        </select>
    </div>
    <div><label>Due date</label><br><input name="due_date" type="date" value="{{ $task->due_date }}"></div>
    <div><button>Update Task</button></div>
</form>
</div>
@endsection