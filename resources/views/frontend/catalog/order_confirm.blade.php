<?php

/**
 * @var $title string
 * @var $user UserWeb
 */

use App\Common\Models\User\UserWeb;

$user = UserWeb::auth();

?>
@extends('frontend.layout',['title' => $title ?? ''])
@section('content')
    <div class="container order-confirm user-page">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>ИП Семенова Ирина Владимировна</h4>
                            <span><?= _unix_to_string_moscow() ?></span>
                        </div>
                        <hr>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
                            <div class="col">
                                <address class="font-size-sm">
                                    <strong>John Doe</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    Phone: (555) 539-1037<br>
                                    Email: dipivweb@nudjad.ke
                                </address>
                            </div>
                            <div class="col">
                                <ul class="list-unstyled">
                                    <li><strong>Ордер: </strong><?= _uniq_id() ?></li>
                                    <li><strong>Дата создания:</strong> <?= _unix_to_string_moscow() ?></li>
                                    <li><strong>Пользователь:</strong> <?= $user->email ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive my-3">
                            <table class="table table-striped table-sm">
                                <thead>
                                <tr>
                                    <th class="text-center">№</th>
                                    <th>Продукт</th>
                                    <th>Количество</th>
                                    <th class="text-right">Стоимость</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (isset($models)) { ?>
                                <?php foreach ($models['items'] as $key => $model){ ?>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td><?= $model['title'] ?></td>
                                    <td class="nostretch"><?= $model['quantity'] ?></td>
                                    <td class="text-right"><?= $model['price'] ?> ₽</td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                        <tr>
                                            <th class="w-50">Итого:</th>
                                            <td>$250.30</td>
                                        </tr>
                                        <tr>
                                            <th>Скидка</th>
                                            <td>$10.34</td>
                                        </tr>
                                        <tr>
                                            <th>Доставка:</th>
                                            <td>$5.80</td>
                                        </tr>
                                        <tr>
                                            <th>Итого:</th>
                                            <td>$265.24</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row mt-3">
                            <button class="btn btn-light has-icon mt-1 mt-sm-0" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-printer mr-2">
                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <rect x="6" y="14" width="12" height="8"></rect>
                                </svg>
                                Print
                            </button>
                            <button class="btn btn-primary has-icon ml-sm-auto mt-1 mt-sm-0" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-download mr-2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Generate PDF
                            </button>
                            <button class="btn btn-success has-icon ml-sm-1 mt-1 mt-sm-0" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-credit-card mr-2">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Submit Payment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
