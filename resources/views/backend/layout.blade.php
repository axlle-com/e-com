<?php

use App\Common\Models\User\UserWeb;

$page = _active_page();
$user = UserWeb::auth();

?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="/backend/css/main.css">
    <link rel="stylesheet" href="/backend/css/common.css">
    <title><?= config('app.company_name') ?> | <?= $title ?? 'Заголовок' ?></title>
</head>
<body class="a-shop">
<div class="sidebar">
    <div class="sidebar-header">
        <a href="/" class="logo">
            <?= config('app.company_name') ?>
        </a>
        <a href="#" class="nav-link nav-icon rounded-circle ml-auto" data-toggle="sidebar">
            <i class="material-icons">close</i>
        </a>
    </div>
    <div class="sidebar-body">
        <ul class="nav treeview mb-4" data-accordion>
            <li class="nav-label">ГЛАВНАЯ</li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['admin'] ?? '' ?>" href="/admin">
                    <i data-feather="globe"></i>Аналитика
                </a>
            </li>
            <li class="nav-label">БЛОГ</li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['blog_category'] ?? '' ?>" href="/admin/blog/category">
                    <i class="material-icons">list_alt</i>Категории
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['blog_post'] ?? '' ?>" href="/admin/blog/post">
                    <i class="material-icons">list_alt</i>Посты
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['blog_comment'] ?? '' ?>" href="/admin/blog/comment">
                    <i class="material-icons">list_alt</i>Комментарии
                </a>
            </li>
            <li class="nav-label">КАТАЛОГ</li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['catalog_category'] ?? '' ?>" href="/admin/catalog/category">
                    <i class="material-icons">article</i>Категории
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['catalog_product'] ?? '' ?>" href="/admin/catalog/product">
                    <i class="material-icons">article</i>Товары
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['document'] ?? '' ?>" href="/admin/catalog/document">
                    <i class="material-icons">article</i>Документы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['coupon'] ?? '' ?>" href="/admin/catalog/coupon">
                    <i class="material-icons">article</i>Купоны
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['catalog_comment'] ?? '' ?>" href="/admin/catalog/comment">
                    <i class="material-icons">list_alt</i>Комментарии
                </a>
            </li>
            <li class="nav-label">СПРАВОЧНИКИ</li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['page'] ?? '' ?>" href="/admin/page">
                    <i class="material-icons">list_alt</i>Страницы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['menu'] ?? '' ?>" href="/admin/menu">
                    <i class="material-icons">list_alt</i>Меню
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['render'] ?? '' ?>" href="/admin/render">
                    <i class="material-icons">list_alt</i>Шаблоны
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['widgets'] ?? '' ?>" href="/admin/render">
                    <i class="material-icons">list_alt</i>Виджеты
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['gallery'] ?? '' ?>" href="/admin/gallery">
                    <i class="material-icons">list_alt</i>Галереи
                </a>
            </li>
        </ul>
    </div>
    <!-- /Sidebar body -->
</div>
<div class="main">
    <div class="main-header">
        <a class="nav-link nav-link-faded rounded-circle nav-icon" href="#" data-toggle="sidebar">
            <i class="material-icons">menu</i>
        </a>
        <form class="form-inline ml-3 d-none d-md-flex">
                <span class="input-icon">
                    <i class="material-icons">search</i>
                    <input type="text" placeholder="Поиск..."
                           class="form-control bg-gray-200 border-gray-200 rounded-lg form-shadow">
                </span>
        </form>
        <ul class="nav ml-auto">
            <li class="nav-item d-md-none">
                <a class="nav-link nav-link-faded nav-icon" data-toggle="modal" href="#searchModal">
                    <i class="material-icons">search</i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-block">
                <a class="nav-link nav-link-faded nav-icon" href="" id="refreshPage">
                    <i class="material-icons">refresh</i>
                </a>
            </li>
            <li class="nav-item dropdown nav-notif js-set-credit">
            </li>
            <li class="nav-item dropdown ml-2">
                <a class="nav-link nav-link-faded rounded nav-link-img dropdown-toggle px-2" href="#"
                   data-toggle="dropdown" data-display="static">
                    <img src="/img/user.svg" alt="Admin" class="rounded-circle mr-2">
                    <span class="d-none d-sm-block"><?= $user->email ?? 'Name' ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0 overflow-hidden user-block">
                    <div class="media align-items-center bg-primary text-white px-4 py-3 mb-2">
                        <img src="/img/user.svg" alt="Admin" class="rounded-circle" width="50"
                             height="50">
                        <div class="media-body ml-2 text-nowrap">
                            <h6 class="mb-0"><?= $user->first_name ?? '' ?></h6>
                            <ul>
                                <?php foreach ($user->getSessionRoles() as $roleName){ ?>
                                    <li class="text-gray-400 font-size-sm"><?= $roleName ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <a class="dropdown-item has-icon" href="/admin/profile">
                        <i class="mr-2" data-feather="user"></i>Профиль
                    </a>
                    <a class="dropdown-item has-icon" href="javascript:void(0)">
                        <i class="mr-2" data-feather="settings"></i>Settings
                    </a>
                    <a class="dropdown-item has-icon text-danger" href="/user/logout">
                        <i class="mr-2" data-feather="log-out"></i>Выход
                    </a>
                </div>
            </li>
        </ul>
    </div>
    <div class="a-shop-block">@yield('content')</div>
</div>
<script src="/backend/js/main.js"></script>
<script src="/main/js/glob.js"></script>
<script src="/backend/js/common.js"></script>
</body>
</html>
