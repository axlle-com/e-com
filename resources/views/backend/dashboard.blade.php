<?php

use App\Common\Models\Blog\PostCategory;

PostCategory::filter();
?>
@extends('backend.layout', ['title' => $title])
@section('content')
    <div class="main-body">

        <div class="row row-cols-2 row-cols-lg-4 gutters-sm">
            <!-- New Orders -->
            <div class="col mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-secondary font-size-sm">New orders</h6>
                        <div class="d-flex align-items-center mb-1">
                            <i data-feather="shopping-bag" class="mr-2"></i>
                            <h3 class="mb-0 mr-2">250</h3>
                            <span class="small text-success">1.2%<i class="material-icons align-bottom">keyboard_arrow_up</i></span>
                        </div>
                        <div class="sparkline-data"
                             data-value="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,0,0,0,45,0,0,37,0,39,0,0,0,5,0,31,0,43,0,0,30,0,0,0,0,0,0,0,0,0"></div>
                    </div>
                </div>
            </div>
            <!-- /New Orders -->

            <!-- Bounce Rate -->
            <div class="col mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-secondary font-size-sm">Bounce rate</h6>
                        <div class="d-flex align-items-center mb-1">
                            <i data-feather="bar-chart-2" class="mr-2"></i>
                            <h3 class="mb-0 mr-2">57%</h3>
                            <span class="small text-danger">0.7%<i class="material-icons align-bottom">keyboard_arrow_down</i></span>
                        </div>
                        <div class="sparkline-data"
                             data-value="0,0,0,0,0,0,0,0,0,0,0,40,0,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,45,1,0,0,35,0,0,40,0,0,45,0,0,0,5,0,0,20,0,5,0,0,0,0,0,0,0,0,0,0"></div>
                    </div>
                </div>
            </div>
            <!-- /Bounce Rate -->

            <!-- New Users -->
            <div class="col mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-secondary font-size-sm">New users</h6>
                        <div class="d-flex align-items-center mb-1">
                            <i data-feather="user-plus" class="mr-2"></i>
                            <h3 class="mb-0 mr-2">48</h3>
                            <span class="small text-danger">0.3%<i class="material-icons align-bottom">keyboard_arrow_down</i></span>
                        </div>
                        <div class="sparkline-data"
                             data-value="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,40,0,0,10,0,0,0,0,0,0,0,0,0,0,0,50,0,40,0,5,0,0,10,0,0,25,0,0,0,5,0,0,0,0,25,0,0,0,0,40,0,0,0,0,0"></div>
                    </div>
                </div>
            </div>
            <!-- /New Users -->

            <!-- Unique Visitors -->
            <div class="col mb-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title text-secondary font-size-sm">Unique visitors</h6>
                        <div class="d-flex align-items-center mb-1">
                            <i data-feather="pie-chart" class="mr-2"></i>
                            <h3 class="mb-0 mr-2">69</h3>
                            <span class="small text-success">2.1%<i class="material-icons align-bottom">keyboard_arrow_up</i></span>
                        </div>
                        <div class="sparkline-data"
                             data-value="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,0,0,0,45,0,0,37,0,39,0,0,0,5,0,31,0,43,0,0,30,0,0,0,0,0,0,0,0,0"></div>
                    </div>
                </div>
            </div>
            <!-- /Unique Visitors -->
        </div>

        <div class="row gutters-sm">

            <!-- Monthly Sales -->
            <div class="col-xl-7 mb-3">
                <div class="card h-100">
                    <div class="card-header py-1">
                        <i class="material-icons mr-2">show_chart</i>
                        <h6>Monthly Sales</h6>
                        <button type="button" data-action="fullscreen"
                                class="btn btn-sm text-secondary btn-icon rounded-circle ml-auto">
                            <i class="material-icons">fullscreen</i>
                        </button>
                    </div>
                    <div class="card-body" style="height: 350px">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- /Monthly Sales -->

            <!-- Transaction History -->
            <div class="col-md-6 col-xl-5 mb-3">
                <div class="card h-100 overflow-hidden" id="transaction-history">
                    <div class="card-header py-1">
                        <h6>Transaction History</h6>
                        <button type="button" data-action="reload"
                                class="btn btn-sm text-success btn-icon ml-auto rounded-circle">
                            <i class="material-icons">refresh</i>
                        </button>
                        <div class="dropdown">
                            <button class="btn text-secondary btn-icon btn-sm rounded-circle dropdown-toggle no-caret"
                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button">Action</button>
                                <button class="dropdown-item" type="button">Another action</button>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex">
                            <div class="media">
                  <span class="flex-center text-success p-2">
                    <i class="material-icons">check</i>
                  </span>
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Payment from #10322</h6>
                                    <span class="small text-secondary">Mar 21, 2019, 3:30pm</span>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <h6 class="mb-0">+ $250.00</h6>
                                <span class="small text-success">Completed</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <div class="media">
                  <span class="flex-center text-info p-2">
                    <i class="material-icons">subdirectory_arrow_left</i>
                  </span>
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Process refund to #00910</h6>
                                    <span class="small text-secondary">Mar 21, 2019, 1:00pm</span>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <h6 class="mb-0">-$16.50</h6>
                                <span class="small text-success">Completed</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <div class="media">
                  <span class="flex-center text-warning p-2">
                    <i data-feather="truck"></i>
                  </span>
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Process delivery to #44333</h6>
                                    <span class="small text-secondary">Mar 20, 2019, 11:40am</span>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <h6 class="mb-0">3 Items</h6>
                                <span class="small text-info">For pickup</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <div class="media">
                  <span class="flex-center text-success p-2">
                    <i class="material-icons">check</i>
                  </span>
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Payment from #023328</h6>
                                    <span class="small text-secondary">Mar 20, 2019, 10:30pm</span>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <h6 class="mb-0">+ $129.50</h6>
                                <span class="small text-success">Completed</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex">
                            <div class="media">
                  <span class="flex-center text-secondary p-2">
                    <i class="material-icons">close</i>
                  </span>
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Payment failed from #087651</h6>
                                    <span class="small text-secondary">Mar 19, 2019, 12:54pm</span>
                                </div>
                            </div>
                            <div class="ml-auto text-right">
                                <h6 class="mb-0">$150.00</h6>
                                <span class="small text-danger">Declined</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Transaction History -->

            <!-- Today Sales -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="card h-100 overflow-hidden" id="today-sales">
                    <div class="card-header py-1">
                        <h6>Today Sales</h6>
                        <div class="list-with-gap ml-auto">
                            <button type="button" data-action="reload"
                                    class="btn btn-sm text-success btn-icon rounded-circle">
                                <i class="material-icons">refresh</i>
                            </button>
                            <div class="custom-control custom-control-nolabel custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch">
                                <label class="custom-control-label" for="customSwitch"></label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gutters-sm">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 mr-1">$150,200</h5>
                                    <span class="small text-success">0.20%<i class="material-icons align-middle">keyboard_arrow_up</i></span>
                                </div>
                                <span class="small text-secondary">Total Sales</span>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 mr-1">$21,880</h5>
                                    <span class="small text-danger">1.04%<i class="material-icons align-middle">keyboard_arrow_down</i></span>
                                </div>
                                <span class="small text-secondary">Avg. Sales Per Day</span>
                            </div>
                        </div>
                        <div style="height: 250px" class="mt-3">
                            <canvas id="barChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Today Sales -->

            <!-- Sales Revenue -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h6>Sales Revenue</h6>
                        <div class="dropdown ml-auto">
                            <a href="#" role="button" class="dropdown-toggle text-secondary small"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USA</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button">Algeria</button>
                                <button class="dropdown-item" type="button">Argentina</button>
                                <button class="dropdown-item" type="button">Brazil</button>
                                <button class="dropdown-item" type="button">Canada</button>
                                <button class="dropdown-item" type="button">France</button>
                                <button class="dropdown-item" type="button">Germany</button>
                                <button class="dropdown-item" type="button">Greece</button>
                                <button class="dropdown-item" type="button">Iran</button>
                                <button class="dropdown-item" type="button">Iraq</button>
                                <button class="dropdown-item" type="button">Russia</button>
                                <button class="dropdown-item" type="button">Tunisia</button>
                                <button class="dropdown-item" type="button">Turkey</button>
                                <button class="dropdown-item active" type="button">USA</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="vmap" style="height: 150px"></div>
                        <table class="table table-sm table-borderless mt-3 mb-0">
                            <thead>
                            <tr class="text-secondary">
                                <th>States</th>
                                <th class="text-right">Orders</th>
                                <th class="text-right">Earnings</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>California</td>
                                <td class="text-right">12,201</td>
                                <td class="text-right">$150,200.80</td>
                            </tr>
                            <tr>
                                <td>Texas</td>
                                <td class="text-right">11,950</td>
                                <td class="text-right">$138,910.20</td>
                            </tr>
                            <tr>
                                <td>Wyoming</td>
                                <td class="text-right">11,198</td>
                                <td class="text-right">$132,050.00</td>
                            </tr>
                            <tr>
                                <td>Florida</td>
                                <td class="text-right">9,885</td>
                                <td class="text-right">$127,762.10</td>
                            </tr>
                            <tr>
                                <td>New York</td>
                                <td class="text-right">8,560</td>
                                <td class="text-right">$117,087.50</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Sales Revenue -->

            <!-- New Customers -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="card h-100 overflow-hidden" id="new-customers">
                    <div class="card-header py-1">
                        <h6>New Customers</h6>
                        <button type="button" data-action="reload"
                                class="btn btn-sm text-success btn-icon ml-auto rounded-circle">
                            <i class="material-icons">refresh</i>
                        </button>
                        <div class="dropdown">
                            <button class="btn text-secondary btn-icon btn-sm rounded-circle dropdown-toggle no-caret"
                                    type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button">Action</button>
                                <button class="dropdown-item" type="button">Another action</button>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <div class="media">
                                <img src="../../../dist/img/user1.svg" alt="user" class="rounded-circle" width="40">
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Socrates Itumay</h6>
                                    <span class="small text-secondary">Customer ID#00222</span>
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm ml-auto" role="group">
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="user-check"></i></a>
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="mail"></i></a>
                                <a href="javascript:void(0)" class="btn text-danger btn-icon rounded-circle"><i
                                            data-feather="slash"></i></a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="media">
                                <img src="../../../dist/img/user2.svg" alt="user" class="rounded-circle" width="40">
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Reynante Labares</h6>
                                    <span class="small text-secondary">Customer ID#00221</span>
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm ml-auto" role="group">
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="user-check"></i></a>
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="mail"></i></a>
                                <a href="javascript:void(0)" class="btn text-danger btn-icon rounded-circle"><i
                                            data-feather="slash"></i></a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="media">
                                <img src="../../../dist/img/user3.svg" alt="user" class="rounded-circle" width="40">
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Marianne Audrey</h6>
                                    <span class="small text-secondary">Customer ID#00220</span>
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm ml-auto" role="group">
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="user-check"></i></a>
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="mail"></i></a>
                                <a href="javascript:void(0)" class="btn text-danger btn-icon rounded-circle"><i
                                            data-feather="slash"></i></a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="media">
                                <img src="../../../dist/img/user4.svg" alt="user" class="rounded-circle" width="40">
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Owen Bongcaras</h6>
                                    <span class="small text-secondary">Customer ID#00219</span>
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm ml-auto" role="group">
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="user-check"></i></a>
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="mail"></i></a>
                                <a href="javascript:void(0)" class="btn text-danger btn-icon rounded-circle"><i
                                            data-feather="slash"></i></a>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <div class="media">
                                <img src="../../../dist/img/user5.svg" alt="user" class="rounded-circle" width="40">
                                <div class="media-body ml-2">
                                    <h6 class="font-size-sm mb-0">Kirby Avendula</h6>
                                    <span class="small text-secondary">Customer ID#00218</span>
                                </div>
                            </div>
                            <div class="btn-group btn-group-sm ml-auto" role="group">
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="user-check"></i></a>
                                <a href="javascript:void(0)" class="btn text-secondary btn-icon rounded-circle"><i
                                            data-feather="mail"></i></a>
                                <a href="javascript:void(0)" class="btn text-danger btn-icon rounded-circle"><i
                                            data-feather="slash"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /New Customers -->

        </div>
    </div>
@endsection
