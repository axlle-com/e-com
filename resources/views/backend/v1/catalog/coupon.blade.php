<?php

/** @var $title string
 * @var $coupons CatalogCoupon[]
 * @var $post array
 */

use App\Common\Models\Catalog\CatalogCoupon;
use App\Common\Models\Setting\Setting;




$title = $title ?? 'Заголовок';

?>
@extends($layout,['title' => $title])

@section('content')
    <div class="main-body blog-category js-index">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style3">
                <li class="breadcrumb-item"><a href="/admin">Главная</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            </ol>
        </nav>
        <h5><?= $title ?></h5>
        <div class="card coupon js-coupon">
            <ul class="list-group list-group-sm list-group-flush sticky-top border-bottom">
                <li class="list-group-item has-icon">
                    <div class="custom-control custom-control-nolabel custom-checkbox mr-2" data-toggle="tooltip"
                         data-trigger="hover" title="" data-original-title="Select all">
                        <input type="checkbox" class="custom-control-input" id="check-all" data-toggle="mail-checkbox"
                               data-check="all-toggle">
                        <label for="check-all" class="custom-control-label"></label>
                    </div>
                    <div class="btn-group btn-group-sm ml-1" role="group" id="bulk-mail" hidden="true">
                        <button type="button" class="btn has-icon text-success js-coupon-zip" data-toggle="tooltip"
                                data-trigger="hover" title="" data-original-title="Архивировать">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-archive">
                                <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                <rect x="1" y="3" width="22" height="5"></rect>
                                <line x1="10" y1="12" x2="14" y2="12"></line>
                            </svg>
                        </button>
                        <button type="button" class="btn has-icon text-success js-coupon-issued" data-toggle="tooltip"
                                data-trigger="hover" title="" data-original-title="Выдан">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-gift">
                                <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                <rect x="2" y="7" width="20" height="5"></rect>
                                <line x1="12" y1="22" x2="12" y2="7"></line>
                                <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                            </svg>
                        </button>
                        <button type="button" class="btn has-icon text-danger js-coupon-delete" data-toggle="tooltip"
                                data-trigger="hover" title="" data-original-title="Удалить">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-trash">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path
                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex-start">
                        <a class="btn btn-primary collapsed btn-sm"
                           data-toggle="collapse"
                           href="#collapseExample"
                           role="button"
                           aria-expanded="false"
                           aria-controls="collapseExample">
                            Новый
                        </a>
                    </div>
                    <div class="ml-auto flex-center">
                        <small class="text-secondary mr-2 d-none d-sm-block">1-10 of 347</small>
                        <button class="btn btn-sm btn-light btn-icon border-0 rounded-circle"><i class="material-icons">chevron_left</i>
                        </button>
                        <button class="btn btn-sm btn-light btn-icon border-0 rounded-circle"><i class="material-icons">chevron_right</i>
                        </button>
                    </div>

                </li>
            </ul>
            <ul class="list-group list-group-sm list-group-flush" id="mail-item-wrapper">
                <li class="coupon-item">
                    <div class="collapse" id="collapseExample" style="">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="/admin/catalog/ajax/add-coupon">
                                    <div class="coupon-enter">
                                        <div class="input-group">
                                            <input
                                                type="number"
                                                name="count"
                                                class="form-control"
                                                placeholder="Количество"
                                                autocomplete="off">
                                        </div>
                                        <div class="input-group">
                                            <input
                                                type="number"
                                                name="discount"
                                                data-validator-required
                                                data-validator="discount"
                                                class="form-control"
                                                placeholder="Скидка"
                                                autocomplete="off">
                                        </div>
                                        <div class="input-group datepicker-wrap">
                                            <input
                                                type="text"
                                                name="expired_at"
                                                class="form-control flatpickr-input"
                                                placeholder="Дата окончания"
                                                autocomplete="off"
                                                data-validator="expired_at"
                                                data-validator-required
                                                data-input="">
                                            <div class="input-group-append">
                                                <button class="btn btn-light btn-icon" type="button" title="Choose date"
                                                        data-toggle=""><i class="material-icons">calendar_today</i>
                                                </button>
                                                <button class="btn btn-light btn-icon" type="button" title="Clear"
                                                        data-clear=""><i class="material-icons">close</i></button>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-success btn-sm ml-2 js-add-coupon">
                                                Сгенерировать
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <div class="js-coupon-item-block">
                    @include($backendTemplate.'.catalog.inc.coupon', ['coupons' => $coupons])
                </div>
                <?= $coupons->links($pagination) ?>
            </ul>
        </div>
    </div>
@endsection
