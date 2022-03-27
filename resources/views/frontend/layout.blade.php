<?php
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= axAssets('/frontend/css/main.css') ?>">
    <link rel="stylesheet" href="<?= axAssets('/frontend/css/common.css') ?>">
    <title><?= config('app.company_name') ?> | <?= $title ?? '' ?></title>
</head>
<body class="a-shop">
    @yield('content')
    <script src="<?= axAssets('/frontend/js/main.js') ?>"></script>
    <script src="<?= axAssets('/frontend/js/common.js') ?>"></script>
</body>
</html>
