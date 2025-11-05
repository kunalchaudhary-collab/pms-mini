<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {
    // Store comment (AJAX or regular)
    public function store(Request $r){
        $data = $r->validate([
            'project_id'=>'nullable|exists:projects,id',
            'task_id'=>'nullable|exists:tasks,id',
            'content'=>'required|string'
        ]);
        $data['user_id'] = auth()->id();
        $user=Auth::user();
        $comment = Comment::create($data);
        logActivity("$user->email:- Added comment", ['comment_id'=>$comment->id,'on'=>isset($data['task_id']) ? 'task' : 'project','content'=>substr($comment->content,0,200)]);
        if ($r->expectsJson() || $r->ajax()) {
            return response()->json([
                'id'=>$comment->id,
                'user'=> $comment->user->name,
                'content'=>$comment->content,
                'created_at'=>$comment->created_at->diffForHumans()
            ]);
        }
        return back()->with('success','Comment added.');
    }

       public function commentList()
    {
        $comments = Comment::with('user')->latest()->take(10)->get();
        $html = view('commentlist', compact('comments'))->render();
        return response()->json([
            'html' => $html,
        ]);
    }
}
