<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'project_id', 'task_id', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
