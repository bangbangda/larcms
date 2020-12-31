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

                <div class="col-6">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">
                            <div class="btn-group dropdown chart-menu">
                                小程序数据
                            </div>
                        </div>
                        <div class="tab-content bg-white p-20">
                            <div class="panel-body p-0 h-400 w-full" id="miniApp"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">
                            <div class="btn-group dropdown chart-menu">
                                公众号数据
                            </div>
                        </div>
                        <div class="tab-content bg-white p-20">
                            <div class="panel-body p-0 h-400 w-full" id="mpApp"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-shadow">
                        <div class="card-header card-header-transparent py-20">
                            <div class="btn-group dropdown chart-menu">
                                红包数据
                            </div>
                        </div>
                        <div class="tab-content bg-white p-20">
                            <div class="panel-body p-0 h-500 w-full" id="redpack"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // 公众号
        let mpChart = echarts.init(document.getElementById('mpApp'));
        mpChart.setOption(option = {
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['新增关注', '取消关注', '关注总量']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: @json($mpWeekData['ref_date'])
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name: '新增关注',
                    type: 'line',
                    stack: 'new_user',
                    data: @json($mpWeekData['new_user'])
                },
                {
                    name: '取消关注',
                    type: 'line',
                    stack: 'cancel_user',
                    data: @json($mpWeekData['cancel_user'])
                },
                {
                    name: '关注总量',
                    type: 'line',
                    stack: 'cumulate_user',
                    data: @json($mpWeekData['cumulate_user'])
                }
            ]
        });

        // 小程序
        let miniChart = echarts.init(document.getElementById('miniApp'));
        // 使用刚指定的配置项和数据显示图表。
        miniChart.setOption({
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['累计用户数', '转发次数', '转发人数']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: @json($miniWeekData['ref_date'])
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name: '转发人数',
                    type: 'line',
                    stack: 'new_user',
                    data: @json($miniWeekData['share_uv'])
                },
                {
                    name: '转发次数',
                    type: 'line',
                    stack: 'cancel_user',
                    data: @json($miniWeekData['share_pv'])
                },
                {
                    name: '累计用户数',
                    type: 'line',
                    stack: 'cumulate_user',
                    data: @json($miniWeekData['visit_total'])
                }
            ]
        });

        // 红包
        let redpackLabelOption = {
            show: true,
            position: 'insideBottom',
            distance: 15,
            align: 'left',
            verticalAlign: 'middle',
            rotate: 90,
            formatter: '{c}元  {name|{a}}',
            fontSize: 16,
            rich: {
                name: {
                }
            }
        };
        let redpackChart = echarts.init(document.getElementById('redpack'));
        redpackChart.setOption({
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                },

            },
            legend: {
                data: ['分享', '团队', '手机号']
            },
            xAxis: [
                {
                    type: 'category',
                    axisTick: {show: true},
                    data: @json($redpackWeekData['sendDate'])
                }
            ],
            yAxis: [
                {
                    type: 'value',
                    axisLabel: {
                        formatter: '{value} 元'
                    }
                }
            ],
            series: [
                {
                    name: '分享',
                    type: 'bar',
                    barGap: 0,
                    label: redpackLabelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: @json($redpackWeekData['basisData'])
                },
                {
                    name: '团队',
                    type: 'bar',
                    label: redpackLabelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: @json($redpackWeekData['teamData'])
                },
                {
                    name: '手机号',
                    type: 'bar',
                    label: redpackLabelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: @json($redpackWeekData['newcomerData'])
                }
            ]
        });

    </script>
@endsection

@push('pageCss')
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/css/examples/pages/home/ecommerce.css">
@endpush

@push('pageScript')
{{--    <script src="https://admui.bangbangda.me/public/js/examples/pages/home/ecommerce.js"></script>--}}
@endpush