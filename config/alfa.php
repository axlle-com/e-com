<?php

return [
    'url' => env('APP_IS_TEST', false) ? env('ALFA_TEST_URL', '') : env('ALFA_URL', ''),
    'username' => env('APP_IS_TEST', false) ? env('ALFA_TEST_USERNAME', '') : env('ALFA_USERNAME', ''),
    'password' => env('APP_IS_TEST', false) ? env('ALFA_TEST_PASSWORD', '') : env('ALFA_PASSWORD', ''),
];
