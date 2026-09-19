<?php

return [
    'api_key' => env('GEMINI_API_KEY'),
    'model'   => env('GEMINI_MODEL', 'gemini-3.5-flash-lite'),
    'timeout' => env('GEMINI_REQUEST_TIMEOUT', 240),
];