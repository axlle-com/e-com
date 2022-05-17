const mix = require('laravel-mix');
const frontend = {
    css: [
        'resources/plugins/bootstrap-4-6-1/css/bootstrap.css',
        'resources/plugins/select2/css/select2.min.css',
        'resources/plugins/fancybox/fancybox.css',
        'resources/plugins/sweetalert2/sweetalert2.min.css',
        'resources/plugins/noty/noty.css',
        'resources/plugins/noty/themes/relax.css',
        'storage/template/css/my-bootstrap.css',
        'storage/template/css/header.css',
        'storage/template/css/footer.css',
        'storage/template/css/history.css',
        'storage/template/css/blog.css',
        'storage/template/css/article.css',
        'storage/template/css/style.css',
        'storage/template/css/modals.css',
    ],
    js: [
        'resources/plugins/jquery-3-6-0/jquery.min.js',
        'resources/plugins/bootstrap-4-6-1/js/bootstrap.js',
        'resources/plugins/select2/js/select2.full.js',
        'resources/plugins/fancybox/fancybox.umd.js',
        'resources/plugins/sweetalert2/sweetalert2.all.min.js',
        'resources/plugins/noty/noty.js',
        'resources/plugins/inputmask/jquery.inputmask.js',
    ],
    img: [
        'storage/template/assets/img',
        'storage/template/assets/img_blog',
        'storage/template/assets/img_portfolio',
        'storage/template/assets/img_product',
        'storage/template/assets/icons',
    ],
    error404: function () {
        let _404Css = Array.from(this.css);
        _404Css.push('resources/backend/css/404.css');
        mix.styles(_404Css, 'public/frontend/css/_error.css');
        mix.styles(_404Css, 'public/frontend/css/error.css');
    },
    catalog: function () {
        let catalogJs = Array.from(this.js);
        /***** dev *****/
        catalogJs.push(
            'resources/plugins/isotope/isotope.pkgd.min.js',
            'resources/plugins/isotope/imagesloaded.pkgd.min.js',
            'resources/plugins/isotope/isotope_init.js',
        );
        mix.scripts(catalogJs, 'public/frontend/js/_catalog.js');
        /***** prod *****/
        catalogJs.push(
            'public/main/js/glob.js',
            'public/frontend/js/common.js',
        );
        mix.scripts(catalogJs, 'public/frontend/js/catalog.js');

    },
    product: function () {
        let productCss = Array.from(this.css);
        let productJs = Array.from(this.js);
        /***** #dev *****/
        productCss.push(
            'resources/plugins/fotorama/fotorama.css',
            'storage/template/css/product_card.css',
        );
        productJs.push(
            'resources/plugins/isotope/imagesloaded.pkgd.min.js',
            'resources/plugins/fotorama/fotorama.js',
        );
        mix.styles(productCss, 'public/frontend/css/_product.css');
        mix.scripts(productJs, 'public/frontend/js/_product.js');
        /***** prod *****/
        productCss.push('public/frontend/css/common.css');
        productJs.push(
            'public/main/js/glob.js',
            'public/frontend/js/common.js',
        );
        mix.styles(productCss, 'public/frontend/css/product.css');
        mix.scripts(productJs, 'public/frontend/js/product.js');
    },
    copy: function () {
        mix.copy(this.img, 'public/frontend/assets/img');
    },
    main: function () {
        /***** #dev *****/
        mix.styles(this.css, 'public/frontend/css/_main.css');
        mix.scripts(this.js, 'public/frontend/js/_main.js');
        /***** #prod *****/
        this.css.push('public/frontend/css/common.css');
        mix.styles(this.css, 'public/frontend/css/main.css');
        this.js.push('public/main/js/glob.js', 'public/frontend/js/common.js');
        mix.scripts(this.js, 'public/frontend/js/main.js');
    }
}

/** ### backend ### */
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
    'resources/plugins/noty/themes/relax.css',
    'resources/plugins/fancybox/fancybox.css',
    'resources/backend/css/style.css',
    'resources/backend/css/sidebar-dark.min.css',
    'resources/plugins/sweetalert2/sweetalert2.min.css',
], 'public/backend/css/main.css');
mix.scripts([
    'resources/plugins/jquery-3-6-0/jquery.min.js',
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
    'resources/plugins/sweetalert2/sweetalert2.all.min.js',
    'resources/plugins/sortablejs/Sortable.min.js',
    'resources/backend/js/script.min.js',
], 'public/backend/js/main.js');
mix.copy('resources/backend/img', 'public/img');
mix.copy([
    'resources/plugins/material-design-icons-iconfont/fonts',
    'resources/plugins/summernote/font'
], 'public/backend/css/fonts');
mix.copy('resources/plugins/fontawesome-free/webfonts', 'public/backend/webfonts');

/** ### frontend ### */
frontend.copy();
frontend.catalog();
frontend.product();
frontend.main();
frontend.error404();
