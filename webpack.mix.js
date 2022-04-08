const mix = require('laravel-mix');

mix.styles([
    // 'resources/plugins/bootstrap-4-6-1/css/bootstrap.css',
    'resources/font/inter/inter.min.css',
    'resources/plugins/material-design-icons-iconfont/material-design-icons.min.css',
    'resources/plugins/fontawesome-free/css/all.min.css',
    'resources/plugins/simplebar/simplebar.min.css',
    'resources/plugins/summernote/summernote-bs4.css',
    'resources/plugins/select2/css/select2.min.css',
    'resources/plugins/flatpickr/flatpickr.min.css',
    'resources/plugins/noty/noty.css',
    'resources/plugins/fancybox/fancybox.css',
    'resources/backend/css/style.css',
    'resources/backend/css/sidebar-dark.min.css',
], 'public/backend/css/main.css');
mix.scripts([
    'resources/backend/js/jquery.min.js',
    'resources/backend/js/bootstrap.bundle.min.js',
    'resources/plugins/simplebar/simplebar.min.js',
    'resources/plugins/feather-icons/feather.min.js',
    'resources/plugins/summernote/summernote-bs4.min.js',
    'resources/plugins/select2/js/select2.full.js',
    'resources/plugins/select2/js/i18n/ru.js',
    'resources/plugins/flatpickr/flatpickr.js',
    'resources/plugins/flatpickr/l10n/ru.js',
    'resources/plugins/noty/noty.js',
    'resources/plugins/inputmask/jquery.inputmask.js',
    'resources/plugins/fancybox/fancybox.umd.js',
    'resources/backend/js/script.min.js',
], 'public/backend/js/main.js');
mix.copy('resources/backend/img', 'public/img');
mix.copy([
    'resources/plugins/material-design-icons-iconfont/fonts',
    'resources/plugins/summernote/font'
], 'public/backend/css/fonts');
mix.copy('resources/plugins/fontawesome-free/webfonts', 'public/backend/webfonts');

/********** frontend **********/

mix.styles([
    'resources/plugins/bootstrap-4-6-1/css/bootstrap.css',
    'resources/plugins/fancybox/fancybox.css',
    'storage/template/css/my-bootstrap.css',
    'storage/template/css/header.css',
    'storage/template/css/footer.css',
    'storage/template/css/history.css',
    'storage/template/css/blog.css',
    'storage/template/css/article.css',
    'storage/template/css/style.css',
], 'public/frontend/css/main.css');
mix.styles(['resources/backend/css/404.css',],'public/frontend/css/error.css')
mix.scripts([
    'resources/plugins/jquery-3-6-0/jquery.min.js',
    'resources/plugins/bootstrap-4-6-1/js/bootstrap.js',
    'resources/plugins/fancybox/fancybox.umd.js',
], 'public/frontend/js/main.js');
mix.copy([
    'storage/template/assets/img',
    'storage/template/assets/img_blog',
    'storage/template/assets/img_portfolio',
    'storage/template/assets/img_product',
    'storage/template/assets/icons',
], 'public/frontend/assets/img');
