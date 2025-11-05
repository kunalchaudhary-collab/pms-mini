<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table="activity_logs";
    protected $fillable=['id','user_id','action','data'];
    protected $casts=[
        'data'=>'array' 
    ];

}
