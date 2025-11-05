<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['id','user_id', 'title', 'description', 'start_date', 'end_date', 'visibility'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
