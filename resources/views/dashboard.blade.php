@extends('layouts.app')

@section('title','仪表盘')

@section('content')
    <div class="page animation-fade page-ecommerce">
        <div class="page-header">
            <h1 class="page-title font-size-26 font-weight-300">概览</h1>
        </div>
        <div class="page-content container-fluid">
            <div class="row" data-plugin="matchHeight" data-by-row="true">

                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-warning">
                                <i class="icon wb-shopping-cart"></i>
                            </button>
                            <span class="ml-15 font-weight-400">订单</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon wb-triangle-up font-size-20"> </i>
                                <span class="font-size-40 font-weight-300">399</span>
                                <p class="blue-grey-400 font-weight-300 m-0">+45% 同比增长</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-danger">
                                <i class="icon fa-yen"></i>
                            </button>
                            <span class="ml-15 font-weight-400">收入</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-success icon wb-triangle-down font-size-20"> </i>
                                <span class="font-size-40 font-weight-300">&yen;18,628</span>
                                <p class="blue-grey-400 font-weight-300 m-0">+45% 同比增长</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-success">
                                <i class="icon wb-eye"></i>
                            </button>
                            <span class="ml-15 font-weight-400">访客</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon wb-triangle-up font-size-20"> </i>
                                <span class="font-size-40 font-weight-300">23,456</span>
                                <p class="blue-grey-400 font-weight-300 m-0">+25% 同比增长</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-primary">
                                <i class="icon wb-user"></i>
                            </button>
                            <span class="ml-15 font-weight-400">买家</span>
                            <div class="content-text text-center mb-0">
                                <i class="text-danger icon wb-triangle-up font-size-20"> </i>
                                <span class="font-size-40 font-weight-300">4,367</span>
                                <p class="blue-grey-400 font-weight-300 m-0">+25% 同比增长</p>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-12" id="ecommerceChartView">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">
                            <div class="btn-group dropdown chart-menu">
                                <button type="button" class="btn btn-outline btn-default dropdown-toggle" data-toggle="dropdown">
                                    产品销售
                                </button>
                                <div class="dropdown-menu animate" role="menu">
                                    <a class="dropdown-item" href="javascript:;" role="menuitem">销售</a>
                                    <a class="dropdown-item" href="javascript:;" role="menuitem">总销售额</a>
                                    <a class="dropdown-item" href="javascript:;" role="menuitem">利润</a>
                                </div>
                            </div>
                            <ul class="nav nav-pills nav-pills-rounded chart-action" id="chartViewNav">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#scoreLineToDay">本日</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#scoreLineToWeek">本周</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#scoreLineToMonth">本月</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content bg-white p-20">
                            <div class="ct-chart tab-pane active" id="scoreLineToDay"></div>
                            <div class="ct-chart tab-pane" id="scoreLineToWeek"></div>
                            <div class="ct-chart tab-pane" id="scoreLineToMonth"></div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-8" id="ecommerceRecentOrder">
                    <div class="card card-shadow table-row">
                        <div class="card-header card-header-transparent p-20">
                            <div class="btn-group dropdown table-menu">
                                <button type="button" class="btn btn-outline btn-default dropdown-toggle" data-toggle="dropdown">
                                    最近订单
                                </button>
                                <div class="dropdown-menu animate" role="menu">
                                    <a class="dropdown-item" href="javascript:;" role="menuitem">销售</a>
                                    <a class="dropdown-item" href="javascript:;" role="menuitem">总销售额</a>
                                    <a class="dropdown-item" href="javascript:;" role="menuitem">利润</a>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>图片</th>
                                    <th>产品</th>
                                    <th>买家</th>
                                    <th>进度</th>
                                    <th>状态</th>
                                    <th>编号</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <img src="../../../../public/images/products/imac.png" width="40" alt="iMac">
                                    </td>
                                    <td>iMac</td>
                                    <td>南学斌</td>
                                    <td>2016.9.22</td>
                                    <td>
                                        <span class="badge badge-success font-weight-300">已完成</span>
                                    </td>
                                    <td>98BC85SD84</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="../../../../public/images/products/iphone.png" width="40" alt="iPhone">
                                    </td>
                                    <td>iPhone</td>
                                    <td>吕佳</td>
                                    <td>2016.9.22</td>
                                    <td>
                                        <span class="badge badge-warning font-weight-300">待发货</span>
                                    </td>
                                    <td>98SA3C9SC</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="../../../../public/images/products/applewatch.png" width="40" alt="apple_watch">
                                    </td>
                                    <td>apple Watch</td>
                                    <td>赵烁利</td>
                                    <td>2016.9.22</td>
                                    <td>
                                        <span class="badge badge-success font-weight-300">已完成</span>
                                    </td>
                                    <td>98BC85SD84</td>
                                </tr>
                                <tr>
                                    <td>
                                        <img src="../../../../public/images/products/macmouse.png" width="40" alt="mac_mouse">
                                    </td>
                                    <td>mac Mouse</td>
                                    <td>付于倩</td>
                                    <td>2016.9.22</td>
                                    <td>
                                        <span class="badge badge-default font-weight-300">待发货</span>
                                    </td>
                                    <td>98SA3C9SC</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4" id="ecommerceRevenue">
                    <div class="card card-shadow text-center pt-10">
                        <h3 class="card-header card-header-transparent blue-grey-700 font-size-14 mb-20">收入</h3>
                        <div class="bg-white">
                            <div class="ct-chart barChart"></div>
                            <div class="pie-view">
                                <div class="col-6 pie-left float-left text-center">
                                    <h5 class="blue-grey-500 font-size-14 font-weight-300">总收入</h5>
                                    <p class="font-size-20 blue-grey-700">
                                        9,362,74 </p>
                                    <div class="pie-progress pie-progress-sm" data-valuemax="100" data-valuemin="0"
                                         data-barcolor="#a58add" data-size="100" data-barsize="4" data-goal="60"
                                         aria-valuenow="60" role="progressbar">
                                        <span class="pie-progress-number">60%</span>
                                    </div>
                                </div>
                                <div class="col-6 pie-right float-right text-center">
                                    <h5 class="blue-grey-500 font-size-14 font-weight-300">线上收入</h5>
                                    <p class="font-size-20 blue-grey-700">
                                        6,734,58 </p>
                                    <div class="pie-progress pie-progress-sm" data-valuemax="100" data-valuemin="0"
                                         data-barcolor="#77d6e1" data-size="100" data-barsize="4" data-goal="78"
                                         aria-valuenow="78" role="progressbar">
                                        <span class="pie-progress-number">78%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageCss')

    <link rel="stylesheet" href="https://admui.bangbangda.me/public/css/examples/pages/home/ecommerce.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/js/examples/pages/home/ecommerce.js"></script>
@endpush