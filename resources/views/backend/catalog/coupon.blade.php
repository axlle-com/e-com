<?php

/* @var $title string
 * @var $models CatalogProduct[]
 * @var $post array
 */

use App\Common\Models\Catalog\CatalogProduct;

$title = $title ?? 'Заголовок';

?>
@extends('backend.layout',['title' => $title])

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
                    <div class="custom-control custom-control-nolabel custom-checkbox mr-2" data-toggle="tooltip" data-trigger="hover" title="" data-original-title="Select all">
                        <input type="checkbox" class="custom-control-input" id="check-all" data-toggle="mail-checkbox" data-check="all-toggle">
                        <label for="check-all" class="custom-control-label"></label>
                    </div>
                    <div class="btn-group btn-group-sm ml-1" role="group" id="bulk-mail" hidden="true">
                        <button type="button" class="btn has-icon text-success" data-toggle="tooltip" data-trigger="hover" title="" data-original-title="Archive"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg></button>
                        <button type="button" class="btn has-icon text-info" data-toggle="tooltip" data-trigger="hover" title="" data-original-title="Report spam"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg></button>
                        <button type="button" class="btn has-icon text-danger" data-toggle="tooltip" data-trigger="hover" title="" data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
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
                                <div class="coupon-enter">
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Количество"
                                               autocomplete="off">
                                    </div>
                                    <div class="input-group datepicker-wrap">
                                        <input type="text" class="form-control flatpickr-input"
                                               placeholder="Дата окончания" autocomplete="off" data-input="">
                                        <div class="input-group-append">
                                            <button class="btn btn-light btn-icon" type="button" title="Choose date"
                                                    data-toggle=""><i class="material-icons">calendar_today</i></button>
                                            <button class="btn btn-light btn-icon" type="button" title="Clear"
                                                    data-clear=""><i class="material-icons">close</i></button>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-success btn-sm ml-2">Сгенерировать</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <object class="js-coupon-item-block">

                </object>
            </ul>
        </div>
    </div>
@endsection
