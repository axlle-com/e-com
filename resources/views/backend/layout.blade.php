<?php

use App\Common\Models\User\UserWeb;

$page = ax_active_page();
$user = UserWeb::auth();
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
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/backend/css/main.css">
    <link rel="stylesheet" href="/backend/css/common.css">
    <title><?= config('app.company_name') ?> | <?= $title ?? 'Заголовок' ?></title>
</head>
<body>
<div class="sidebar">

    <!-- Sidebar header -->
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
                <a class="nav-link has-icon treeview-toggle <?= $page['report'] ?? '' ?>" href="#">
                    <i class="material-icons">fact_check</i>Отчеты
                </a>
                <ul class="nav">
                    <li class="nav-item">
                        <a href="/admin/report/storage-balance-simple"
                           class="nav-link <?= $page['storage_balance_simple'] ?? '' ?>">Остатки</a>
                    </li>
                </ul>
            </li>
            <li class="nav-label">КАТАЛОГ</li>
            <li class="nav-label">СПРАВОЧНИКИ</li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['producer'] ?? '' ?>" href="/admin/producer">
                    <i class="material-icons">article</i>Поставщики
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['customer'] ?? '' ?>" href="/admin/customer">
                    <i class="material-icons">article</i>Покупатели
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['employee'] ?? '' ?>" href="/admin/employee">
                    <i class="material-icons">article</i>Сотрудники
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['catalog'] ?? '' ?>" href="/admin/catalog">
                    <i class="material-icons">article</i>Каталог
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link has-icon <?= $page['storage_place'] ?? '' ?>" href="/admin/storage-place">
                    <i class="material-icons">article</i>Склады
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
                    <input type="text" placeholder="Search..."
                           class="form-control bg-gray-200 border-gray-200 rounded-lg">
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
                <div class="dropdown-menu dropdown-menu-right pt-0 overflow-hidden">
                    <div class="media align-items-center bg-primary text-white px-4 py-3 mb-2">
                        <img src="/img/user.svg" alt="Admin" class="rounded-circle" width="50"
                             height="50">
                        <div class="media-body ml-2 text-nowrap">
                            <h6 class="mb-0"><?= $user->first_name ?? '' ?></h6>
                            <ul>
                                <?php foreach ($user->getRoleNames() as $roleName){ ?>
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
                    <a class="dropdown-item has-icon text-danger" href="/logout">
                        <i class="mr-2" data-feather="log-out"></i>Выход
                    </a>
                </div>
            </li>
        </ul>
    </div>
    @yield('content')
</div>
<script src="/backend/js/main.js"></script>
<script src="/backend/js/common.js"></script>
</body>
</html>
