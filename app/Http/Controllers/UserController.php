<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // login page
    public function showLogin()
    {
        // check already login in
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('success', "Already Login User");
        }
        return view('auth.login');
    }

    // signup

    public function showSignup()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('success' , "Already Registered User");
        }
        return view('auth.register');
    }

    // login now
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ],[
            'email.exists'=>"email not exist in system"
        ]);
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                ActivityLog::create(['user_id'=>Auth::id(),'action'=>'Login Created',"data"=>['users'=>Auth::id(),"url"=>url()->current()]]);
                return redirect()->route('dashboard')->with(['success' => 'Login Successfully']);
            }
            return redirect()->back()->with('error' , 'Credentials Mismatch !!');
        } catch (Exception $e) {
            return redirect()->back()->with('error' , $e->getMessage());
        }
    }

    // signup now
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6|max:8',
        ]);
        try {
            $user=User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
                ActivityLog::create(['user_id'=>$user->id,'action'=>'Signup Created',"data"=>['users'=>$user->id,"url"=>url()->current()]]);
            return redirect()->back()->with(['success' => 'Signup successfully Go to Login']);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    // dashboard page
    public function dashboard()
    {
        $userId = Auth::id();
        $projects = Project::where('user_id',$userId)->count();
        $tasks = Task::count();
        $todo = Task::where('status','todo')->count();
        $inprogress = Task::where('status','inprogress')->count();
        $completed = Task::where('status','completed')->count();
        $logs = ActivityLog::latest()->take(10)->get();
        $comments = Comment::latest()->take(20)->get(); 
        return view('dashboard', compact('projects','tasks','todo','inprogress','completed','logs','comments'));
    }
}
