<?php
namespace App\Http\Controllers;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller {
    public function index(Request $r){
        $q = ActivityLog::query();
        if ($r->filled('search')) $q->where('action','like','%'.$r->search.'%');
        $logs = $q->latest()->paginate(15);
        return view('activity.index', compact('logs'));
    }
}
