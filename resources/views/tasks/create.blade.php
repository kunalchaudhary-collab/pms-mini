@extends('layouts.app')
@section('content')
<h2>Create Task</h2>
<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <div><label>Project</label><br>
        <select name="project_id">
            @foreach($projects as $p)
                <option value="{{ $p->id }}">{{ $p->title }}</option>
            @endforeach
        </select>
    </div>
    <div><label>Title</label><br><input name="title"></div>
    <div><label>Description</label><br><textarea name="description"></textarea></div>
    <div><label>Assign to (user)</label><br>
        <select name="assigned_to">
            <option value="">--none--</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>
    </div>
    <div><label>Due Date</label><br><input name="due_date" type="date"></div>
    <div><button>Create Task</button></div>
</form>
@endsection
