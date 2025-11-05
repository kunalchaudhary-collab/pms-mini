<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Create demo user
        $user = User::factory()->create([
            'name'=>'Demo User',
            'email'=>'demo@pms.test',
            'password'=>Hash::make('password')
        ]);

        // Make a couple more users
        $u2 = User::factory()->create(['name'=>'Alice','email'=>'alice@pms.test','password'=>Hash::make('password')]);
        $u3 = User::factory()->create(['name'=>'Bob','email'=>'bob@pms.test','password'=>Hash::make('password')]);

        // Projects
        $p = Project::create([
            'user_id'=>$user->id,
            'title'=>'Demo Project',
            'description'=>'This is a seeded demo project',
        ]);

        // Tasks
        $t1 = Task::create(['project_id'=>$p->id,'assigned_to'=>$u2->id,'title'=>'Design UI','description'=>'Design the main UI','status'=>'todo']);
        $t2 = Task::create(['project_id'=>$p->id,'assigned_to'=>$u3->id,'title'=>'API Endpoints','description'=>'Create APIs','status'=>'inprogress']);

        // Comments
        Comment::create(['user_id'=>$u2->id,'project_id'=>$p->id,'content'=>'Looks good!']);
        Comment::create(['user_id'=>$u3->id,'task_id'=>$t2->id,'content'=>'Working on auth']);

        // Activity logs
        ActivityLog::create(['user_id'=>$user->id,'action'=>'Seeded demo project','data'=>['project_id'=>$p->id]]);
        ActivityLog::create(['user_id'=>$u2->id,'action'=>'Seeded comment','data'=>['comment'=>'Looks good!']]);
    }
}