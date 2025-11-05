<?php
use App\Models\ActivityLog;

if (! function_exists('logActivity')) {
    function logActivity(string $action, array|null $data = null) {
        ActivityLog::create([
            'user_id' => auth()->id() ?? null,
            'action' => $action,
            'data' => $data,
        ]);
    }
}