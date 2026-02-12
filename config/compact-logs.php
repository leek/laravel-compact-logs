<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | The logging channels that should have their stack traces truncated.
    | Set to null to disable auto-registration (manual tap setup required).
    |
    */

    'channels' => ['single', 'daily'],

    /*
    |--------------------------------------------------------------------------
    | Max Trace Depth
    |--------------------------------------------------------------------------
    |
    | The maximum number of stack trace frames to keep per exception.
    | Additional frames are replaced with a "... and N more frames" indicator.
    |
    */

    'max_trace_depth' => (int) env('LOG_TRACE_DEPTH', 3),

];
