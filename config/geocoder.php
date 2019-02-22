<?php

return [
    'key' => env('APP_ENV') != 'production' ? 'testkey' : env('GOOGLE_API_KEY', 'testkey'),
    'language' => null,
    'region' => null
];
