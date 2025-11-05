<?php

use App\Models\ActivityLog;
use App\Models\User;

if (! function_exists('logActivity')) {
    function logActivity($action, $data = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id() ?? null,
            'action' => $action,
            'data' => $data,
        ]);
    }
}
