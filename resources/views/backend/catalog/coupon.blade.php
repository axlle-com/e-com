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
                <li class="coupon-item">
                    <div class="row coupon-item-block">
                        <div class="col-md-1 ">1</div>
                        <div class="col-md-2 coupon-item-block-number">Facebook</div>
                        <div class="col-md-5 coupon-item-block-user">Пользователь</div>
                        <div class="col-md-2 coupon-item-block-status">Статус</div>
                        <div class="col-md-2 coupon-item-block-time">21.21.2121</div>
                    </div>
                </li>
                <li class="list-group-item mail-item unread starred">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-2">
                                <label for="inbox-2" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2 active"
                                    data-toggle="button" aria-pressed="true">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                notifications
                            </div>
                            <div class="mail-item-subject"> New comment: Mimity - Admin Dashboard Template<span
                                    class="mail-item-summary text-secondary"> - Someone commented on your item, Mimity - Admin Dashboard + Retail Template</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Sep 24</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item starred">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-3">
                                <label for="inbox-3" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2 active"
                                    data-toggle="button" aria-pressed="true">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                service@intl.paypal.
                            </div>
                            <div class="mail-item-subject"> We're transferring money to your bank<span
                                    class="mail-item-summary text-secondary"> - We're transferring money from PayPal to your bank. You asked us to transfer</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Sep 16</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-4">
                                <label for="inbox-4" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Steam Support
                            </div>
                            <div class="mail-item-subject"> Thank you for activating your product on Steam!<span
                                    class="mail-item-summary text-secondary"> - Your activation of DiRT Rally was successful. It is recommended that you</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-paperclip mr-2">
                                <path
                                    d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                            </svg>
                            <time>Aug 31</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item unread starred">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-5">
                                <label for="inbox-5" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2 active"
                                    data-toggle="button" aria-pressed="true">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Facebook
                            </div>
                            <div class="mail-item-subject"><span class="badge badge-info">Social</span> Did you log into
                                Facebook from somewhere new?<span class="mail-item-summary text-secondary"> - It looks like someone tried to log into your account on August 13 at</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Aug 13</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-6">
                                <label for="inbox-6" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Pinterest
                            </div>
                            <div class="mail-item-subject"> Discover new ideas from your Pin twin<span
                                    class="mail-item-summary text-secondary"> - You and Wenjia are both interested in dashboard design! Check out some ideas</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Aug 11</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-7">
                                <label for="inbox-7" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Pixabay
                            </div>
                            <div class="mail-item-subject"><span class="badge badge-success">Promotion</span> Free
                                Add-Ons for Photoshop and MS Office<span class="mail-item-summary text-secondary"> - These plugins let you search and insert Pixabay images directly from within</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Jul 31</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-8">
                                <label for="inbox-8" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Caleb Porzio
                            </div>
                            <div class="mail-item-subject"> Learn VS Code #7: Make Your .env Files Pretty<span
                                    class="mail-item-summary text-secondary"> - Hey friends, Here's a quick update on the book/course/thing before we talk</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Jul 14</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-9">
                                <label for="inbox-9" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Adam Wathan
                            </div>
                            <div class="mail-item-subject"> Tailwind UI: What you've missed so far<span
                                    class="mail-item-summary text-secondary"> - Hey, thanks again for talking an interest in Tailwind UI! So far you've missed five</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Jun 18</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-10">
                                <label for="inbox-10" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Dribbble
                            </div>
                            <div class="mail-item-subject"> Dashboard obsessional<span
                                    class="mail-item-summary text-secondary"> - This week UX/UI designer Zinat Farahani joins us to share her favorite dashboard designs</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>May 10</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-11">
                                <label for="inbox-11" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                noreply@remove.bg
                            </div>
                            <div class="mail-item-subject"> Activate your remove.bg account<span
                                    class="mail-item-summary text-secondary"> - remove.bg Activate your Account Thanks for signing up at remove.bg! To confirm your account</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>May 02</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-12">
                                <label for="inbox-12" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Ubisoft Account Support
                            </div>
                            <div class="mail-item-subject"> Welcome to Ubisoft<span
                                    class="mail-item-summary text-secondary"> - Hi, Welcome to Ubisoft. For your account security please verify your email address</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>May 01</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-13">
                                <label for="inbox-13" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                James Simmons
                            </div>
                            <div class="mail-item-subject"> Feedback about licenses and support policy<span
                                    class="mail-item-summary text-secondary"> - Hello omadmin, You reveiced this email because you are a seller on Wrapbootstrap</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Apr 27</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-14">
                                <label for="inbox-14" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Google+ Team
                            </div>
                            <div class="mail-item-subject"> Your personal Google+ account is going away on April 2, 2019<span
                                    class="mail-item-summary text-secondary"> - You've received this email because you have a consumer (personal) Google+ account or you manage a Google+ page</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Apr 01</time>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mail-item">
                    <div class="media">
                        <div class="d-flex">
                            <div class="custom-control custom-control-nolabel custom-checkbox mr-2">
                                <input type="checkbox" class="custom-control-input" id="inbox-15">
                                <label for="inbox-15" class="custom-control-label"></label>
                            </div>
                            <button type="button" class="btn-starred btn btn-icon btn-xs mr-2" data-toggle="button"
                                    aria-pressed="false">
                                <i class="fa fa-star"></i>
                            </button>
                        </div>
                        <div class="media-body collapsed" data-toggle="collapse" data-target=".mail-content"
                             aria-expanded="false">
                            <div class="mail-item-from">
                                Nate Murray
                            </div>
                            <div class="mail-item-subject"> Fullstack Vue: 30 Days of Vue PDF Inside<span
                                    class="mail-item-summary text-secondary"> - Download 30 Days of Vue PDF and Code Here's your 30 Days of Vue PDF</span>
                            </div>
                        </div>
                        <div class="d-flex small text-muted mt-2 mt-sm-0 align-self-start align-self-sm-center">
                            <time>Mar 29</time>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection
