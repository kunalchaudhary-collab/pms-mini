<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller {
    public function index(Request $r){
        $q = Project::query();
        if ($r->filled('search')) $q->where('title','like','%'.$r->search.'%');
        $projects = $q->where('user_id', auth()->id())->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create(){ return view('projects.create'); }

    public function store(Request $r){
        $data = $r->validate(['title'=>'required','description'=>'nullable','start_date'=>'nullable|date','end_date'=>'nullable|date','visibility'=>'in:private,public']);
        $data['user_id'] = auth()->id();
        $project = Project::create($data);
        logActivity('Created project', ['project_id'=>$project->id,'title'=>$project->title]);
        return redirect()->route('projects.index')->with('success','Project created.');
    }

    public function show(Project $project){
        $this->authorizeView($project);
        $project->load('tasks','comments');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project){
        $this->authorizeView($project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $r, Project $project){
        $this->authorizeView($project);
        $data = $r->validate(['title'=>'required','description'=>'nullable','start_date'=>'nullable|date','end_date'=>'nullable|date','visibility'=>'in:private,public']);
        $old = $project->getOriginal();
        $project->update($data);
        logActivity('Updated project', ['project_id'=>$project->id,'old'=>$old,'new'=>$project->toArray()]);
        return redirect()->route('projects.show',$project)->with('success','Project updated.');
    }

    public function destroy(Project $project){
        $this->authorizeView($project);
        logActivity('Deleted project', ['project_id'=>$project->id,'title'=>$project->title]);
        $project->delete();
        return redirect()->route('projects.index')->with('success','Project deleted.');
    }

    protected function authorizeView(Project $project){
        if ($project->user_id !== auth()->id()) abort(403);
    }
}
