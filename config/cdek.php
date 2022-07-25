<?php

return [
    'url' => 0 ? env('CDEK_TEST_URL', '') : env('CDEK_URL', ''),
    'from' => 435,
    'account' => env('CDEK_USERNAME', ''),
    'password' => env('CDEK_PASSWORD', ''),
];
