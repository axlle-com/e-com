<?php

use App\Common\Models\User\UserWeb;

/**
 *
 */

$user = UserWeb::auth();

?>
        <!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="/backend/v2/css/main.css">
    <link rel="stylesheet" href="/backend/v2/css/common.css">
    <title><?= config('app.company_name') ?> | <?= $title ?? 'Заголовок' ?></title>
</head>
<body class="ax-template-v2">
<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a>
                </li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html"
                                                          data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                          title="Email"><i class="ficon" data-feather="mail"></i></a>
                </li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-bs-toggle="tooltip"
                                                          data-bs-placement="bottom" title="Chat"><i class="ficon"
                                                                                                     data-feather="message-square"></i></a>
                </li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calendar.html"
                                                          data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                          title="Calendar"><i class="ficon" data-feather="calendar"></i></a>
                </li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html" data-bs-toggle="tooltip"
                                                          data-bs-placement="bottom" title="Todo"><i class="ficon"
                                                                                                     data-feather="check-square"></i></a>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon text-warning"
                                                                                            data-feather="star"></i></a>
                    <div class="bookmark-input search-input">
                        <div class="bookmark-input-icon"><i data-feather="search"></i></div>
                        <input class="form-control input" type="text" placeholder="Bookmark" tabindex="0"
                               data-search="search">
                        <ul class="search-list search-list-bookmark"></ul>
                    </div>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag"
                                                               href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                               aria-expanded="false"><i
                            class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag"><a class="dropdown-item"
                                                                                                href="#"
                                                                                                data-language="en"><i
                                class="flag-icon flag-icon-us"></i> English</a><a class="dropdown-item" href="#"
                                                                                  data-language="fr"><i
                                class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="#"
                                                                                 data-language="de"><i
                                class="flag-icon flag-icon-de"></i> German</a><a class="dropdown-item" href="#"
                                                                                 data-language="pt"><i
                                class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
            </li>
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                                                                                         data-feather="moon"></i></a>
            </li>
            <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon"
                                                                                   data-feather="search"></i></a>
                <div class="search-input">
                    <div class="search-input-icon"><i data-feather="search"></i></div>
                    <input class="form-control input" type="text" placeholder="Explore Vuexy..." tabindex="-1"
                           data-search="search">
                    <div class="search-input-close"><i data-feather="x"></i></div>
                    <ul class="search-list search-list-main"></ul>
                </div>
            </li>
            <li class="nav-item dropdown dropdown-cart me-25"><a class="nav-link" href="#" data-bs-toggle="dropdown"><i
                            class="ficon" data-feather="shopping-cart"></i><span
                            class="badge rounded-pill bg-primary badge-up cart-item-count">6</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">My Cart</h4>
                            <div class="badge rounded-pill badge-light-primary">4 Items</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list">
                        <div class="list-item align-items-center"><img class="d-block rounded me-1"
                                                                       src="../../../app-assets/images/pages/eCommerce/1.png"
                                                                       alt="donuts" width="62">
                            <div class="list-item-body flex-grow-1"><i class="ficon cart-item-remove"
                                                                       data-feather="x"></i>
                                <div class="media-heading">
                                    <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html">
                                            Apple watch 5</a></h6><small class="cart-item-by">By Apple</small>
                                </div>
                                <div class="cart-item-qty">
                                    <div class="input-group">
                                        <input class="touchspin-cart" type="number" value="1">
                                    </div>
                                </div>
                                <h5 class="cart-item-price">$374.90</h5>
                            </div>
                        </div>
                        <div class="list-item align-items-center"><img class="d-block rounded me-1"
                                                                       src="../../../app-assets/images/pages/eCommerce/7.png"
                                                                       alt="donuts" width="62">
                            <div class="list-item-body flex-grow-1"><i class="ficon cart-item-remove"
                                                                       data-feather="x"></i>
                                <div class="media-heading">
                                    <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html">
                                            Google Home Mini</a></h6><small class="cart-item-by">By Google</small>
                                </div>
                                <div class="cart-item-qty">
                                    <div class="input-group">
                                        <input class="touchspin-cart" type="number" value="3">
                                    </div>
                                </div>
                                <h5 class="cart-item-price">$129.40</h5>
                            </div>
                        </div>
                        <div class="list-item align-items-center"><img class="d-block rounded me-1"
                                                                       src="../../../app-assets/images/pages/eCommerce/2.png"
                                                                       alt="donuts" width="62">
                            <div class="list-item-body flex-grow-1"><i class="ficon cart-item-remove"
                                                                       data-feather="x"></i>
                                <div class="media-heading">
                                    <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html">
                                            iPhone 11 Pro</a></h6><small class="cart-item-by">By Apple</small>
                                </div>
                                <div class="cart-item-qty">
                                    <div class="input-group">
                                        <input class="touchspin-cart" type="number" value="2">
                                    </div>
                                </div>
                                <h5 class="cart-item-price">$699.00</h5>
                            </div>
                        </div>
                        <div class="list-item align-items-center"><img class="d-block rounded me-1"
                                                                       src="../../../app-assets/images/pages/eCommerce/3.png"
                                                                       alt="donuts" width="62">
                            <div class="list-item-body flex-grow-1"><i class="ficon cart-item-remove"
                                                                       data-feather="x"></i>
                                <div class="media-heading">
                                    <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html">
                                            iMac Pro</a></h6><small class="cart-item-by">By Apple</small>
                                </div>
                                <div class="cart-item-qty">
                                    <div class="input-group">
                                        <input class="touchspin-cart" type="number" value="1">
                                    </div>
                                </div>
                                <h5 class="cart-item-price">$4,999.00</h5>
                            </div>
                        </div>
                        <div class="list-item align-items-center"><img class="d-block rounded me-1"
                                                                       src="../../../app-assets/images/pages/eCommerce/5.png"
                                                                       alt="donuts" width="62">
                            <div class="list-item-body flex-grow-1"><i class="ficon cart-item-remove"
                                                                       data-feather="x"></i>
                                <div class="media-heading">
                                    <h6 class="cart-item-title"><a class="text-body" href="app-ecommerce-details.html">
                                            MacBook Pro</a></h6><small class="cart-item-by">By Apple</small>
                                </div>
                                <div class="cart-item-qty">
                                    <div class="input-group">
                                        <input class="touchspin-cart" type="number" value="1">
                                    </div>
                                </div>
                                <h5 class="cart-item-price">$2,999.00</h5>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-menu-footer">
                        <div class="d-flex justify-content-between mb-1">
                            <h6 class="fw-bolder mb-0">Total:</h6>
                            <h6 class="text-primary fw-bolder mb-0">$10,999.00</h6>
                        </div>
                        <a class="btn btn-primary w-100" href="app-ecommerce-checkout.html">Checkout</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown dropdown-notification me-25"><a class="nav-link" href="#"
                                                                         data-bs-toggle="dropdown"><i class="ficon"
                                                                                                      data-feather="bell"></i><span
                            class="badge rounded-pill bg-danger badge-up">5</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                            <div class="badge rounded-pill badge-light-primary">6 New</div>
                        </div>
                    </li>
                    <li class="scrollable-container media-list"><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar"><img
                                                src="../../../app-assets/images/portrait/small/avatar-s-15.jpg"
                                                alt="avatar" width="32" height="32"></div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Congratulation Sam 🎉</span>winner!
                                    </p><small class="notification-text"> Won the monthly best seller badge.</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar"><img
                                                src="../../../app-assets/images/portrait/small/avatar-s-3.jpg"
                                                alt="avatar" width="32" height="32"></div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">New message</span>&nbsp;received
                                    </p><small class="notification-text"> You have 10 unread messages</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content">MD</div>
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Revised Order 👋</span>&nbsp;checkout
                                    </p><small class="notification-text"> MD Inc. order updated</small>
                                </div>
                            </div>
                        </a>
                        <div class="list-item d-flex align-items-center">
                            <h6 class="fw-bolder me-auto mb-0">System Notifications</h6>
                            <div class="form-check form-check-primary form-switch">
                                <input class="form-check-input" id="systemNotification" type="checkbox" checked="">
                                <label class="form-check-label" for="systemNotification"></label>
                            </div>
                        </div>
                        <a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content"><i class="avatar-icon" data-feather="x"></i></div>
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Server down</span>&nbsp;registered
                                    </p><small class="notification-text"> USA Server is down due to high CPU
                                        usage</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar bg-light-success">
                                        <div class="avatar-content"><i class="avatar-icon" data-feather="check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">Sales report</span>&nbsp;generated
                                    </p><small class="notification-text"> Last month sales report generated</small>
                                </div>
                            </div>
                        </a><a class="d-flex" href="#">
                            <div class="list-item d-flex align-items-start">
                                <div class="me-1">
                                    <div class="avatar bg-light-warning">
                                        <div class="avatar-content"><i class="avatar-icon"
                                                                       data-feather="alert-triangle"></i></div>
                                    </div>
                                </div>
                                <div class="list-item-body flex-grow-1">
                                    <p class="media-heading"><span class="fw-bolder">High memory</span>&nbsp;usage</p>
                                    <small class="notification-text"> BLR Server using high memory</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Read all
                            notifications</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                                                           id="dropdown-user" href="#" data-bs-toggle="dropdown"
                                                           aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">John Doe</span><span
                                class="user-status">Admin</span></div>
                    <span class="avatar"><img class="round"
                                              src="../../../app-assets/images/portrait/small/avatar-s-11.jpg"
                                              alt="avatar" height="40" width="40"><span
                                class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a class="dropdown-item"
                                                                                                href="page-profile.html"><i
                                class="me-50" data-feather="user"></i> Profile</a><a class="dropdown-item"
                                                                                     href="app-email.html"><i
                                class="me-50" data-feather="mail"></i> Inbox</a><a class="dropdown-item"
                                                                                   href="app-todo.html"><i class="me-50"
                                                                                                           data-feather="check-square"></i>
                        Task</a><a class="dropdown-item" href="app-chat.html"><i class="me-50"
                                                                                 data-feather="message-square"></i>
                        Chats</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="page-account-settings-account.html"><i class="me-50"
                                                                                          data-feather="settings"></i>
                        Settings</a><a class="dropdown-item" href="page-pricing.html"><i class="me-50"
                                                                                         data-feather="credit-card"></i>
                        Pricing</a><a class="dropdown-item" href="page-faq.html"><i class="me-50"
                                                                                    data-feather="help-circle"></i> FAQ</a><a
                            class="dropdown-item" href="auth-login-cover.html"><i class="me-50"
                                                                                  data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<ul class="main-search-list-defaultlist d-none">
    <li class="d-flex align-items-center"><a href="#">
            <h6 class="section-label mt-75 mb-0">Files</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                                   href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="../../../app-assets/images/icons/xls.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing
                        Manager</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;17kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                                   href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="../../../app-assets/images/icons/jpg.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;11kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                                   href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="../../../app-assets/images/icons/pdf.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                        Marketing Manager</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;150kb</small>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                                   href="app-file-manager.html">
            <div class="d-flex">
                <div class="me-75"><img src="../../../app-assets/images/icons/doc.png" alt="png" height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                </div>
            </div>
            <small class="search-data-size me-50 text-muted">&apos;256kb</small>
        </a></li>
    <li class="d-flex align-items-center"><a href="#">
            <h6 class="section-label mt-75 mb-0">Members</h6>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                                   href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="png"
                                               height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                                   href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="png"
                                               height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                        Developer</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                                   href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg" alt="png"
                                               height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing
                        Manager</small>
                </div>
            </div>
        </a></li>
    <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                                   href="app-user-view-account.html">
            <div class="d-flex align-items-center">
                <div class="avatar me-75"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="png"
                                               height="32"></div>
                <div class="search-data">
                    <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                </div>
            </div>
        </a></li>
</ul>
<ul class="main-search-list-defaultlist-other-list d-none">
    <li class="auto-suggestion justify-content-between"><a
                class="d-flex align-items-center justify-content-between w-100 py-50">
            <div class="d-flex justify-content-start"><span class="me-75" data-feather="alert-circle"></span><span>No results found.</span>
            </div>
        </a></li>
</ul>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand"
                                            href="../../../html/ltr/vertical-menu-template-semi-dark/index.html"><span
                            class="brand-logo">
                            <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" height="24">
                                <defs>
                                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%"
                                                    y2="89.4879456%">
                                        <stop stop-color="#000000" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%"
                                                    x2="37.373316%" y2="100%">
                                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                                    </lineargradient>
                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                        <g id="Group" transform="translate(400.000000, 178.000000)">
                                            <path class="text-primary" id="Path"
                                                  d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                  style="fill:currentColor"></path>
                                            <path id="Path1"
                                                  d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                  fill="url(#linearGradient-1)" opacity="0.2"></path>
                                            <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                                     points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                            <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                                     points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994"
                                                     points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                        </g>
                                    </g>
                                </g>
                            </svg></span>
                    <h2 class="brand-text">Vuexy</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                            class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                            class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary"
                            data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a class="d-flex align-items-center" href="index.html"><i
                            data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span
                            class="badge badge-light-warning rounded-pill ms-auto me-1">2</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="dashboard-analytics.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Analytics">Analytics</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="dashboard-ecommerce.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="eCommerce">eCommerce</span></a>
                    </li>
                </ul>
            </li>
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i
                        data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="app-email.html"><i data-feather="mail"></i><span
                            class="menu-title text-truncate" data-i18n="Email">Email</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="app-chat.html"><i
                            data-feather="message-square"></i><span class="menu-title text-truncate" data-i18n="Chat">Chat</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="app-todo.html"><i
                            data-feather="check-square"></i><span class="menu-title text-truncate"
                                                                  data-i18n="Todo">Todo</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="app-calendar.html"><i
                            data-feather="calendar"></i><span class="menu-title text-truncate" data-i18n="Calendar">Calendar</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="app-kanban.html"><i
                            data-feather="grid"></i><span class="menu-title text-truncate"
                                                          data-i18n="Kanban">Kanban</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                            class="menu-title text-truncate" data-i18n="Invoice">Invoice</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-invoice-list.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">List</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-invoice-preview.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Preview</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-invoice-edit.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">Edit</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-invoice-add.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Add">Add</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="app-file-manager.html"><i
                            data-feather="save"></i><span class="menu-title text-truncate" data-i18n="File Manager">File Manager</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="shield"></i><span
                            class="menu-title text-truncate"
                            data-i18n="Roles &amp; Permission">Roles &amp; Permission</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-access-roles.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Roles">Roles</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-access-permission.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Permission">Permission</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i
                            data-feather="shopping-cart"></i><span class="menu-title text-truncate"
                                                                   data-i18n="eCommerce">eCommerce</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-ecommerce-shop.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shop">Shop</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-ecommerce-details.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Details">Details</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-ecommerce-wishlist.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Wish List">Wish List</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="app-ecommerce-checkout.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Checkout">Checkout</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span
                            class="menu-title text-truncate" data-i18n="User">User</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="app-user-list.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">List</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="View">View</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="app-user-view-account.html"><span
                                            class="menu-item text-truncate" data-i18n="Account">Account</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="app-user-view-security.html"><span
                                            class="menu-item text-truncate" data-i18n="Security">Security</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="app-user-view-billing.html"><span
                                            class="menu-item text-truncate" data-i18n="Billing &amp; Plans">Billing &amp; Plans</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="app-user-view-notifications.html"><span
                                            class="menu-item text-truncate"
                                            data-i18n="Notifications">Notifications</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="app-user-view-connections.html"><span
                                            class="menu-item text-truncate"
                                            data-i18n="Connections">Connections</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                            class="menu-title text-truncate" data-i18n="Pages">Pages</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Account Settings">Account Settings</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="page-account-settings-account.html"><span
                                            class="menu-item text-truncate" data-i18n="Account">Account</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-account-settings-security.html"><span
                                            class="menu-item text-truncate" data-i18n="Security">Security</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-account-settings-billing.html"><span
                                            class="menu-item text-truncate" data-i18n="Billings &amp; Plans">Billings &amp; Plans</span></a>
                            </li>
                            <li><a class="d-flex align-items-center"
                                   href="page-account-settings-notifications.html"><span class="menu-item text-truncate"
                                                                                         data-i18n="Notifications">Notifications</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-account-settings-connections.html"><span
                                            class="menu-item text-truncate"
                                            data-i18n="Connections">Connections</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="page-profile.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Profile">Profile</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="page-faq.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="FAQ">FAQ</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="page-knowledge-base.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Knowledge Base">Knowledge Base</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="page-pricing.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Pricing">Pricing</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="page-license.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="License">License</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="page-api-key.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="API Key">API Key</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Blog">Blog</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="page-blog-list.html"><span
                                            class="menu-item text-truncate" data-i18n="List">List</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-blog-detail.html"><span
                                            class="menu-item text-truncate" data-i18n="Detail">Detail</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-blog-edit.html"><span
                                            class="menu-item text-truncate" data-i18n="Edit">Edit</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Mail Template">Mail Template</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center"
                                   href="https://pixinvent.com/demo/vuexy-mail-template/mail-welcome.html"
                                   target="_blank"><span class="menu-item text-truncate"
                                                         data-i18n="Welcome">Welcome</span></a>
                            </li>
                            <li><a class="d-flex align-items-center"
                                   href="https://pixinvent.com/demo/vuexy-mail-template/mail-reset-password.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Reset Password">Reset Password</span></a>
                            </li>
                            <li><a class="d-flex align-items-center"
                                   href="https://pixinvent.com/demo/vuexy-mail-template/mail-verify-email.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Verify Email">Verify Email</span></a>
                            </li>
                            <li><a class="d-flex align-items-center"
                                   href="https://pixinvent.com/demo/vuexy-mail-template/mail-deactivate-account.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Deactivate Account">Deactivate Account</span></a>
                            </li>
                            <li><a class="d-flex align-items-center"
                                   href="https://pixinvent.com/demo/vuexy-mail-template/mail-invoice.html"
                                   target="_blank"><span class="menu-item text-truncate"
                                                         data-i18n="Invoice">Invoice</span></a>
                            </li>
                            <li><a class="d-flex align-items-center"
                                   href="https://pixinvent.com/demo/vuexy-mail-template/mail-promotional.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Promotional">Promotional</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Miscellaneous">Miscellaneous</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="page-misc-coming-soon.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Coming Soon">Coming Soon</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-misc-not-authorized.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Not Authorized">Not Authorized</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-misc-under-maintenance.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Maintenance">Maintenance</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="page-misc-error.html" target="_blank"><span
                                            class="menu-item text-truncate" data-i18n="Error">Error</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user-check"></i><span
                            class="menu-title text-truncate" data-i18n="Authentication">Authentication</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Login">Login</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="auth-login-basic.html" target="_blank"><span
                                            class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="auth-login-cover.html" target="_blank"><span
                                            class="menu-item text-truncate" data-i18n="Cover">Cover</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Register">Register</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="auth-register-basic.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="auth-register-cover.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Cover">Cover</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="auth-register-multisteps.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Multi-Steps">Multi-Steps</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate"
                                    data-i18n="Forgot Password">Forgot Password</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="auth-forgot-password-basic.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="auth-forgot-password-cover.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Cover">Cover</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Reset Password">Reset Password</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="auth-reset-password-basic.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="auth-reset-password-cover.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Cover">Cover</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Verify Email">Verify Email</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="auth-verify-email-basic.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="auth-verify-email-cover.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Cover">Cover</span></a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Two Steps">Two Steps</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="auth-two-steps-basic.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="auth-two-steps-cover.html"
                                   target="_blank"><span class="menu-item text-truncate" data-i18n="Cover">Cover</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="modal-examples.html"><i
                            data-feather="square"></i><span class="menu-title text-truncate" data-i18n="Modal Examples">Modal Examples</span></a>
            </li>
            <li class=" navigation-header"><span data-i18n="User Interface">User Interface</span><i
                        data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="ui-typography.html"><i
                            data-feather="type"></i><span class="menu-title text-truncate" data-i18n="Typography">Typography</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="ui-feather.html"><i data-feather="eye"></i><span
                            class="menu-title text-truncate" data-i18n="Feather">Feather</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="credit-card"></i><span
                            class="menu-title text-truncate" data-i18n="Card">Card</span><span
                            class="badge badge-light-success rounded-pill ms-auto me-1">New</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="card-basic.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="card-advance.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Advance">Advance</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="card-statistics.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Statistics">Statistics</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="card-analytics.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Analytics">Analytics</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="card-actions.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Card Actions">Card Actions</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="briefcase"></i><span
                            class="menu-title text-truncate" data-i18n="Components">Components</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="component-accordion.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Accordion">Accordion</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-alerts.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Alerts">Alerts</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-avatar.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Avatar">Avatar</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-badges.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Badges">Badges</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-breadcrumbs.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Breadcrumbs">Breadcrumbs</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-buttons.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Buttons">Buttons</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-carousel.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Carousel">Carousel</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-collapse.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Collapse">Collapse</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-divider.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Divider">Divider</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-dropdowns.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Dropdowns">Dropdowns</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-list-group.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="List Group">List Group</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-modals.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Modals">Modals</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-navs-component.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Navs Component">Navs Component</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-offcanvas.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Offcanvas">Offcanvas</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-pagination.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Pagination">Pagination</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-pill-badges.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Pill Badges">Pill Badges</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-pills-component.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Pills Component">Pills Component</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-popovers.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Popovers">Popovers</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-progress.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Progress">Progress</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-spinner.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Spinner">Spinner</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-tabs-component.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Tabs Component">Tabs Component</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-timeline.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Timeline">Timeline</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-bs-toast.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Toasts">Toasts</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="component-tooltips.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Tooltips">Tooltips</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="box"></i><span
                            class="menu-title text-truncate" data-i18n="Extensions">Extensions</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="ext-component-sweet-alerts.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Sweet Alert">Sweet Alert</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-blockui.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Block UI">BlockUI</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-toastr.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Toastr">Toastr</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-sliders.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Sliders">Sliders</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-drag-drop.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Drag &amp; Drop">Drag &amp; Drop</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-tour.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Tour">Tour</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-clipboard.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Clipboard">Clipboard</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-media-player.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Media player">Media Player</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-context-menu.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Context Menu">Context Menu</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-swiper.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="swiper">Swiper</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-tree.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Tree">Tree</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-ratings.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Ratings">Ratings</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="ext-component-i18n.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="l18n">l18n</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="layout"></i><span
                            class="menu-title text-truncate" data-i18n="Page Layouts">Page Layouts</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="layout-collapsed-menu.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Collapsed Menu">Collapsed Menu</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="layout-full.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Layout Full">Layout Full</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="layout-without-menu.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Without Menu">Without Menu</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="layout-empty.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Layout Empty">Layout Empty</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="layout-blank.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Layout Blank">Layout Blank</span></a>
                    </li>
                </ul>
            </li>
            <li class=" navigation-header"><span data-i18n="Forms &amp; Tables">Forms &amp; Tables</span><i
                        data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="copy"></i><span
                            class="menu-title text-truncate" data-i18n="Form Elements">Form Elements</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="form-input.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Input">Input</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-input-groups.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Input Groups">Input Groups</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-input-mask.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Input Mask">Input Mask</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-textarea.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Textarea">Textarea</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-checkbox.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Checkbox">Checkbox</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-radio.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Radio">Radio</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-custom-options.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Custom Options">Custom Options</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-switch.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Switch">Switch</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-select.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Select">Select</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-number-input.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Number Input">Number Input</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-file-uploader.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="File Uploader">File Uploader</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-quill-editor.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Quill Editor">Quill Editor</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="form-date-time-picker.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Date &amp; Time Picker">Date &amp; Time Picker</span></a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="form-layout.html"><i
                            data-feather="box"></i><span class="menu-title text-truncate" data-i18n="Form Layout">Form Layout</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="form-wizard.html"><i
                            data-feather="package"></i><span class="menu-title text-truncate" data-i18n="Form Wizard">Form Wizard</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="form-validation.html"><i
                            data-feather="check-circle"></i><span class="menu-title text-truncate"
                                                                  data-i18n="Form Validation">Form Validation</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="form-repeater.html"><i
                            data-feather="rotate-cw"></i><span class="menu-title text-truncate"
                                                               data-i18n="Form Repeater">Form Repeater</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="table-bootstrap.html"><i
                            data-feather="server"></i><span class="menu-title text-truncate"
                                                            data-i18n="Table">Table</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="grid"></i><span
                            class="menu-title text-truncate" data-i18n="Datatable">Datatable</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="table-datatable-basic.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Basic">Basic</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="table-datatable-advanced.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="Advanced">Advanced</span></a>
                    </li>
                </ul>
            </li>
            <li class=" navigation-header"><span data-i18n="Charts &amp; Maps">Charts &amp; Maps</span><i
                        data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="pie-chart"></i><span
                            class="menu-title text-truncate" data-i18n="Charts">Charts</span><span
                            class="badge badge-light-danger rounded-pill ms-auto me-2">2</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="chart-apex.html"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Apex">Apex</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="chart-chartjs.html"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Chartjs">Chartjs</span></a>
                    </li>
                </ul>
            </li>
            <li class="active nav-item"><a class="d-flex align-items-center" href="maps-leaflet.html"><i
                            data-feather="map"></i><span class="menu-title text-truncate" data-i18n="Leaflet Maps">Leaflet Maps</span></a>
            </li>
            <li class=" navigation-header"><span data-i18n="Misc">Misc</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="menu"></i><span
                            class="menu-title text-truncate" data-i18n="Menu Levels">Menu Levels</span></a>
                <ul class="menu-content">
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Second Level">Second Level 2.1</span></a>
                    </li>
                    <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Second Level">Second Level 2.2</span></a>
                        <ul class="menu-content">
                            <li><a class="d-flex align-items-center" href="#"><span class="menu-item text-truncate"
                                                                                    data-i18n="Third Level">Third Level 3.1</span></a>
                            </li>
                            <li><a class="d-flex align-items-center" href="#"><span class="menu-item text-truncate"
                                                                                    data-i18n="Third Level">Third Level 3.2</span></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="disabled nav-item"><a class="d-flex align-items-center" href="#"><i
                            data-feather="eye-off"></i><span class="menu-title text-truncate" data-i18n="Disabled Menu">Disabled Menu</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center"
                                     href="https://pixinvent.com/demo/vuexy-html-bootstrap-admin-template/documentation"
                                     target="_blank"><i data-feather="folder"></i><span class="menu-title text-truncate"
                                                                                        data-i18n="Documentation">Documentation</span></a>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="https://pixinvent.ticksy.com/"
                                     target="_blank"><i data-feather="life-buoy"></i><span
                            class="menu-title text-truncate" data-i18n="Raise Support">Raise Support</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Leaflet Maps</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Maps</a>
                                </li>
                                <li class="breadcrumb-item active">Leaflet Maps
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    data-feather="grid"></i></button>
                        <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="app-todo.html"><i
                                        class="me-1" data-feather="check-square"></i><span
                                        class="align-middle">Todo</span></a><a class="dropdown-item"
                                                                               href="app-chat.html"><i class="me-1"
                                                                                                       data-feather="message-square"></i><span
                                        class="align-middle">Chat</span></a><a class="dropdown-item"
                                                                               href="app-email.html"><i class="me-1"
                                                                                                        data-feather="mail"></i><span
                                        class="align-middle">Email</span></a><a class="dropdown-item"
                                                                                href="app-calendar.html"><i class="me-1"
                                                                                                            data-feather="calendar"></i><span
                                        class="align-middle">Calendar</span></a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="maps-leaflet">
                <div class="row">
                    <!-- Basic Starts -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">Basic Map</h4>
                            </div>
                            <div class="card-body">
                                <div class="leaflet-map" id="basic-map"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Basic Ends -->

                    <!-- Marker Circle & Polygon Starts -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">Marker Circle & Polygon</h4>
                            </div>
                            <div class="card-body">
                                <div class="leaflet-map" id="shape-map"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Marker Circle & Polygon Ends -->

                    <!-- Draggable Marker With Popup Starts -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">Draggable Marker With Popup</h4>
                            </div>
                            <div class="card-body">
                                <div class="leaflet-map" id="drag-map"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Draggable Marker With Popup Ends -->

                    <!-- User Location Starts -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">User Location</h4>
                            </div>
                            <div class="card-body">
                                <div class="leaflet-map" id="user-location"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Location Ends -->

                    <!-- Custom Icons Starts -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">Custom Icons</h4>
                            </div>
                            <div class="card-body">
                                <div class="leaflet-map" id="custom-icons"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Custom Icons Ends -->

                    <!-- GeoJson Starts -->
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">GeoJson</h4>
                            </div>
                            <div class="card-body">
                                <div class="leaflet-map" id="geojson"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /GeoJson Ends -->

                    <!-- Layer Control Starts -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Layer Control</h4>
                            </div>
                            <div class="card-body">
                                <div class="leaflet-map" id="layer-control"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Layer Control Ends -->
                </div>
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a
                    class="ms-25" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent</a><span
                    class="d-none d-sm-inline-block">, All rights Reserved</span></span><span
                class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span></p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
<script src="/backend/mimity/js/main.js"></script>
<script src="/main/js/glob.js"></script>
<script src="/backend/mimity/js/common.js"></script>
</body>
</html>
