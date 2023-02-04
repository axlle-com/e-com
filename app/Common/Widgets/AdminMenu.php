<?php

namespace App\Common\Widgets;

use Illuminate\View\View;

/**
 * Main b application asset.
 */
class AdminMenu extends Widget
{
    private array $activePage = [];
    private array $menu = [
        'ГЛАВНАЯ' => [
            [
                'admin',
                '<i data-feather="globe"></i>',
                '/admin',
                'Аналитика',
            ],
        ],
        'БЛОГ' => [
            [
                'blog_category',
                '<i class="material-icons">list_alt</i>',
                '/admin/blog/category',
                'Категории',
            ],
            [
                'blog_post',
                '<i class="material-icons">list_alt</i>',
                '/admin/blog/post',
                'Посты',
            ],
            [
                'blog_comment',
                '<i class="material-icons">list_alt</i>',
                '/admin/blog/comment',
                'Комментарии',
            ],
        ],
        'КАТАЛОГ' => [
            [
                'catalog_category',
                '<i class="material-icons">article</i>',
                '/admin/catalog/category',
                'Категории',
            ],
            [
                'catalog_product',
                '<i class="material-icons">article</i>',
                '/admin/catalog/product',
                'Товары',
            ],
            [
                'catalog_property',
                '<i class="material-icons">article</i>',
                '/admin/catalog/property',
                'Свойства',
            ],
            [
                'catalog_storage',
                '<i class="material-icons">article</i>',
                '/admin/catalog/storage',
                'Склад',
            ],
            [
                'document',
                '<i class="material-icons">article</i>',
                '/admin/catalog/document',
                'Документы',
                'children' => [
                    [
                        'fin_invoice',
                        '<i class="material-icons">article</i>',
                        '/admin/catalog/document/fin-invoice',
                        'Счета на оплату',
                    ],
                    [
                        'order',
                        '<i class="material-icons">article</i>',
                        '/admin/catalog/document/order',
                        'Заказы',
                    ],
                    [
                        'coming',
                        '<i class="material-icons">article</i>',
                        '/admin/catalog/document/coming',
                        'Поступление',
                    ],
                    [
                        'sale',
                        '<i class="material-icons">article</i>',
                        '/admin/catalog/document/sale',
                        'Продажа',
                    ],
                    [
                        'write-off',
                        '<i class="material-icons">article</i>',
                        '/admin/catalog/document/write-off',
                        'Списание',
                    ],
                    [
                        'reservation',
                        '<i class="material-icons">article</i>',
                        '/admin/catalog/document/reservation',
                        'Резервирование',
                    ],
                    [
                        'reservation-cancel',
                        '<i class="material-icons">article</i>',
                        '/admin/catalog/document/reservation-cancel',
                        'Снятие с резерва',
                    ],
                ],
            ],
            [
                'coupon',
                '<i class="material-icons">article</i>',
                '/admin/catalog/coupon',
                'Купоны',
            ],
            [
                'catalog_comment',
                '<i class="material-icons">list_alt</i>',
                '/admin/catalog/comment',
                'Комментарии',
            ],
        ],
        'СПРАВОЧНИКИ' => [
            [
                'page',
                '<i class="material-icons">list_alt</i>',
                '/admin/page',
                'Страницы',
            ],
            [
                'menu',
                '<i class="material-icons">list_alt</i>',
                '/admin/menu',
                'Меню',
            ],
            [
                'render',
                '<i class="material-icons">list_alt</i>',
                '/admin/render',
                'Шаблоны',
            ],
            [
                'widgets',
                '<i class="material-icons">list_alt</i>',
                '/admin/widgets',
                'Виджеты',
            ],
            [
                'gallery',
                '<i class="material-icons">list_alt</i>',
                '/admin/gallery',
                'Галереи',
            ],
        ],
    ];

    public function init(): static
    {
        $this->page();
        return $this;
    }

    private function page(): void
    {
        $url = $_SERVER['REQUEST_URI'];
        $urlArray = explode('/', $url);
        if ($url === '/admin') {
            $this->activePage['admin'] = 'active';
        }
        if (strripos($url, '/admin/blog/category') !== false) {
            $this->activePage['blog_category'] = 'active';
        }
        if (strripos($url, '/admin/blog/post') !== false) {
            $this->activePage['blog_post'] = 'active';
        }
        if (strripos($url, '/admin/catalog/category') !== false) {
            $this->activePage['catalog_category'] = 'active';
        }
        if (strripos($url, 'admin/catalog/product') !== false) {
            $this->activePage['catalog_product'] = 'active';
        }
        if (strripos($url, 'admin/catalog/property') !== false) {
            $this->activePage['catalog_property'] = 'active';
        }
        if (strripos($url, '/admin/catalog/coupon') !== false) {
            $this->activePage['coupon'] = 'active';
        }
        if (strripos($url, '/admin/catalog/document') !== false) {
            $this->activePage['document'] = 'active';
        }
        if (strripos($url, '/admin/catalog/document/order') !== false) {
            $this->activePage['order'] = 'active';
        }
        if (strripos($url, '/admin/catalog/document/fin-invoice') !== false) {
            $this->activePage['fin_invoice'] = 'active';
        }
        if (strripos($url, '/admin/catalog/document/coming') !== false) {
            $this->activePage['coming'] = 'active';
        }
        if (strripos($url, '/admin/catalog/document/write-off') !== false) {
            $this->activePage['write-off'] = 'active';
        }
        if (strripos($url, '/admin/catalog/document/reservation') !== false) {
            $this->activePage['reservation'] = 'active';
        }
        if (strripos($url, '/admin/catalog/document/reservation-cancel') !== false) {
            $this->activePage['reservation-cancel'] = 'active';
        }
        if (strripos($url, '/admin/page') !== false) {
            $this->activePage['page'] = 'active';
        }
        if (strripos($url, '/admin/catalog/storage') !== false) {
            $this->activePage['catalog_storage'] = 'active';
        }
        if (strripos($url, '/admin/storage-place') !== false) {
            $this->activePage['storage_place'] = 'active';
        }
        if (strripos($url, '/admin/report') !== false) {
            $this->activePage['report'] = 'active show';
        }
        if (strripos($url, '/admin/report/storage-balance-simple') !== false) {
            $this->activePage['storage_balance_simple'] = 'active';
        }
    }

    public function run(): ?View
    {
        return view('assets.backend.menu', [
            'menu' => $this->menu,
            'page' => $this->activePage,
        ]);
    }
}
