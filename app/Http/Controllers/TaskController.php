<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {
    public function index(){ // show all tasks or you can filter
        $tasks = Task::with('project','assignee')->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create(){
        $projects = Project::where('user_id', auth()->id())->get();
        $users = User::all();
        return view('tasks.create', compact('projects','users'));
    }

    public function store(Request $r){
        $data = $r->validate(['project_id'=>'required|exists:projects,id','assigned_to'=>'nullable|exists:users,id','title'=>'required','description'=>'nullable','status'=>'in:todo,inprogress,completed','due_date'=>'nullable|date']);
        $task = Task::create($data);
        $user=Auth::user();
        logActivity("$user->email:- Created task", ['task_id'=>$task->id,'title'=>$task->title,'project_id'=>$task->project_id]);
        return redirect()->route('projects.show',$task->project_id)->with('success','Task created.');
    }

    public function edit(Task $task){
        $projects = Project::where('user_id', auth()->id())->get();
        $users = User::all();
        return view('tasks.edit', compact('task','projects','users'));
    }

    public function update(Request $r, Task $task){
        $data = $r->validate(['project_id'=>'required|exists:projects,id','assigned_to'=>'nullable|exists:users,id','title'=>'required','description'=>'nullable','status'=>'in:todo,inprogress,completed','due_date'=>'nullable|date']);
        $old = $task->getOriginal();
        $task->update($data);
        $user=Auth::user();
        logActivity("$user->email:-  Updated task", ['task_id'=>$task->id,'old'=>$old,'new'=>$task->toArray()]);
        return redirect()->route('projects.show',$task->project_id)->with('success','Task updated.');
    }

    public function destroy(Task $task){
        $user=Auth::user();
        logActivity("$user->email:-   Deleted task", ['task_id'=>$task->id,'title'=>$task->title,'project_id'=>$task->project_id]);
        $task->delete();
        return back()->with('success','Task deleted.');
    }

    // AJAX endpoint for status update
    public function updateStatus(Request $r, Task $task){
        $r->validate(['status'=>'required|in:todo,inprogress,completed']);
        $old = $task->status;
        $task->update(['status'=>$r->status]);
        $user=Auth::user();
        logActivity("$user->email:-   Changed task status", ['task_id'=>$task->id,'from'=>$old,'to'=>$r->status]);
        return response()->json(['success'=>true,'status'=>$task->status]);
    }
}
