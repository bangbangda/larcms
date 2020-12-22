@extends('layouts.app')

@section('title','仪表盘')

@section('content')
    <div class="page animation-fade page-ecommerce">
        <div class="page-header">
            <h1 class="page-title font-size-26 font-weight-300">数据概览</h1>
        </div>
        <div class="page-content container-fluid">
            <div class="row" data-plugin="matchHeight" data-by-row="true">
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-warning">
                                <i class="icon fa-gift"></i>
                            </button>
                            <span class="ml-15 font-weight-400">红包总数量</span>
                            <div class="content-text text-center mb-0">
                                <span class="font-size-40 font-weight-300">{{ $totalRedpack['totalQuantity'] }} 个</span>
                                <p class="blue-grey-400 font-weight-300 m-0">实时更新</p>
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
                            <span class="ml-15 font-weight-400">红包总金额</span>
                            <div class="content-text text-center mb-0">
                                <span class="font-size-40 font-weight-300">&yen;{{ $totalRedpack['totalAmount'] }}</span>
                                <p class="blue-grey-400 font-weight-300 m-0">实时更新</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 info-panel">
                    <div class="card card-shadow">
                        <div class="bg-white p-20">
                            <button type="button" class="btn btn-floating btn-sm btn-success">
                                <i class="icon fa-mobile-phone"></i>
                            </button>
                            <span class="ml-15 font-weight-400">手机号码总数量</span>
                            <div class="content-text text-center mb-0">
                                <span class="font-size-40 font-weight-300">{{ $totalUser['totalPhone'] }} 个</span>
                                <p class="blue-grey-400 font-weight-300 m-0">实时更新</p>
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
                            <span class="ml-15 font-weight-400">小程序累计用户数</span>
                            <div class="content-text text-center mb-0">
                                <span class="font-size-40 font-weight-300">{{ $dailySummary['visit_total'] }} 个</span>
                                <p class="blue-grey-400 font-weight-300 m-0">
                                    数据截止：{{ $dailySummary['ref_date'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12" id="ecommerceChartView">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">
                            <div class="btn-group dropdown chart-menu">
                                分享数据
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