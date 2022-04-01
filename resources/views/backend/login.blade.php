<?php
    /* @var $post array */

    $array = [
        '/404/resources/admin/js/jquery.min.js',
        '/404/resources/admin/js/bootstrap.bundle.min.js',
        '/404/resources/plugins/simplebar/simplebar.min.js',
        '/404/resources/plugins/feather-icons/feather.min.js',
        '/404/resources/plugins/summernote/summernote-bs4.min.js',
        '/404/resources/plugins/select2/js/select2.full.js',
        '/404/resources/plugins/select2/js/i18n/ru.js',
        '/404/resources/plugins/flatpickr/flatpickr.js',
        '/404/resources/plugins/flatpickr/l10n/ru.js',
        '/404/resources/plugins/noty/noty.js',
        '/404/resources/plugins/inputmask/jquery.inputmask.js',
        '/404/resources/plugins/fancybox/fancybox.umd.js',
        '/404/resources/admin/js/script.min.js',
    ];
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= axAssets('/backend/css/main.css') ?>">
    <link rel="stylesheet" href="<?= axAssets('/backend/css/common.css') ?>">
    <title><?= config('app.company_name') ?> | Авторизация</title>
</head>

<body class="login-page">
    <div class="container pt-5">
        <div class="row justify-content-center align-content-center">
            <div class="col-md-auto d-flex justify-content-center">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white flex-column">
                        <h4 class="text-center mb-0">Вход</h4>
                        <div class="text-center opacity-50 font-italic">в ваш аккаунт</div>
                    </div>
                    <div class="card-body p-4">
                        <form action="/login" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="floating-label input-icon">
                                    <i class="material-icons">person_outline</i>
                                    <input type="text" class="form-control" placeholder="Логин" name="email" value="<?= $post['email'] ?? null ?>">
                                    <label for="username">Логин</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="floating-label input-icon">
                                    <i class="material-icons">lock_open</i>
                                    <input type="password" class="form-control" placeholder="Пароль" name="password">
                                    <label for="password">Пароль</label>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember">
                                    <label class="custom-control-label" for="remember">Запомнить</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($array as $item){ ?>
        <script src="<?= axAssets($item) ?>"></script>
    <?php } ?>
{{--    <script src="<?= axAssets('/backend/js/main.js') ?>"></script>--}}
{{--    <script src="<?= axAssets('/backend/js/common.js') ?>"></script>--}}
</body>

</html>
