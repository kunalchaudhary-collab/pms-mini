<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog;
use App\Models\Comment;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $projects = Project::where('user_id', $userId)->count();
        $tasks = Task::count();
        $todo = Task::where('status', 'todo')->count();
        $inprogress = Task::where('status', 'inprogress')->count();
        $completed = Task::where('status', 'completed')->count();
        $logs = ActivityLog::latest()->take(10)->get();
        $comments = Comment::latest()->take(20)->get(); // public comments
        return view('dashboard', compact('projects', 'tasks', 'todo', 'inprogress', 'completed', 'logs', 'comments'));
    }
 
}
