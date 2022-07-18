<?php

return [
    'url' => env('APP_IS_TEST', false) ? env('CDEK_URL', '') : env('CDEK_URL', ''),
    'account' => env('APP_IS_TEST', false) ? env('CDEK_USERNAME', '') : env('CDEK_USERNAME', ''),
    'password' => env('APP_IS_TEST', false) ? env('CDEK_PASSWORD', '') : env('CDEK_PASSWORD', ''),
];
