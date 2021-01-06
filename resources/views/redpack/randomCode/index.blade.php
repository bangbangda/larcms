@extends('layouts.app')

@section('title','红包管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">红包管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('customer.index') }}">随机码红包管理</a>
                </li>
                <li class="breadcrumb-item active">随机码红包列表</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        随机码红包管理
                        <span class="panel-desc">创建随机码红包，创建成功后，复制随机码给用户，用户复制后关注公众号打开小程序即可自动领取红包。</span>
                    </h3>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form autocomplete="off" onsubmit="return false;">
                        <div class="row">
                            <label class="col-md-2 col-form-label">随机码：</label>
                            <div class="form-group col-sm-4">
                                <input type="text" class="form-control" name="code" value="{{ old('code') }}"  maxlength="10" placeholder="随机码" autocomplete="off">
                            </div>

                            <div class="form-group offset-lg-3">
                                <button type="button" class="btn btn-primary" onclick="search();">检索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="icon wb-list" aria-hidden="true"></i>
                        列表
                    </h3>
                    <div class="panel-actions">
                        <a href="#" id="create">
                            <button type="button" class="btn btn-success">生成随机码</button>
                        </a>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <table class="table" id="bs-table" >
                        <thead>
                        <tr>
                            <th data-field="id" data-width="5%">编号</th>
                            <th data-field="code" data-width="20%">随机码</th>
                            <th data-field="amount" data-formatter="f_amount" data-width="10%">红包金额</th>
                            <th data-field="nickname" data-width="15%">领取人</th>
                            <th data-field="receive_time" data-sortable="true" data-width="20%">领取时间</th>
                            <th data-field="receive_status" data-formatter="f_receive_status" data-width="10%">领取状态</th>
                            <th data-width="10%" data-formatter="f_operator">操作</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <form id="create-form" method="post" action="{{ route('redpack.randomCode.store') }}">
                {{ csrf_field() }}
            </form>
        </div>
    </div>

    <script type="text/javascript">
        // 初始化查询条件
        var search_query = {};
        search_query['random_code_redpacks.code'] = $("[name=code]").val();

        $(function () {
            var $table = $("#bs-table"),selections = [];

            $table.bootstrapTable({
                url: "{{ route('redpack.randomCode.json') }}",
                sortName: 'id',
                sortOrder: 'desc',
                pagination: true,
                sidePagination: 'server',
                search: false,
                toolbar: "#toolbar",
                detailView: false,
                queryParams: function (params) {
                    params.query = search_query;
                    return params;
                },
                responseHandler:function (res) {
                    return res;
                },
                onLoadSuccess: function (data) {
                }
            });

            $("#create").click(function () {
                $('#create-form').submit();
            });

        });

        /**
         * 格式化操作信息
         */
        function f_operator(value, row, index, field) {
            let url = '#';
            var butt = [
                '<a href="'+url+'"><button type="button" class="btn btn-squared btn-outline btn-info">领取详情</button></a>'
            ];

            return butt.join('&nbsp;&nbsp;&nbsp;');
        }

        /**
         * 格式化领取状态
         */
        function f_receive_status(value, row, index, field) {
            if (value == 'success') {
                return '领取成功';
            } else if(value == 'error') {
                return '领取失败';
            }
        }

        function f_amount(value, row, index, field) {
            return value / 100 + ' 元';
        }


        /**
         * 更新查询条件并执行查询
         */
        function search() {
            search_query['random_code_redpacks.code'] = $("[name=code]").val();
            $('#bs-table').bootstrapTable("refresh");
        }

    </script>
@endsection

@push('pageCss')
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-table/bootstrap-table.min.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
@endpush
