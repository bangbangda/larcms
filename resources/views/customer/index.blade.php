@extends('layouts.app')

@section('title','客户管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">客户管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('customer.index') }}">客户管理</a>
                </li>
                <li class="breadcrumb-item active">客户列表</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        微信客户管理
                        <span class="panel-desc">查询微信用户列表，可通过微信昵称进行检索。</span>
                    </h3>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form autocomplete="off" onsubmit="return false;">
                        <div class="row">
                            <label class="col-md-2 col-form-label">微信昵称：</label>
                            <div class="form-group col-sm-4">
                                <input type="text" class="form-control" name="nickname" value="{{ old('nickname') }}"  maxlength="10" placeholder="微信昵称" autocomplete="off">
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
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <table class="table" id="bs-table" >
                        <thead>
                        <tr>
                            <th data-field="id" data-width="5%">编号</th>
                            <th data-field="nickname" data-width="15%">微信昵称</th>
                            <th data-field="phone" data-width="15%">手机号码</th>
                            <th data-field="avatar_url" data-formatter="f_image" data-width="15%">微信头像</th>
                            <th data-field="created_at" data-width="15%" data-sortable="true">关注时间</th>
                            <th data-field="subscribe_scene" data-formatter="f_subscribe_scenee" data-width="15%">关注来源</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <form id="delete-form" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>
        </div>
    </div>

    <script type="text/javascript">
        // 初始化查询条件
        var search_query = {};
        search_query['customers.nickname'] = $("[name=nickname]").val();

        $(function () {
            var $table = $("#bs-table"),selections = [];

            $table.bootstrapTable({
                url: "{{ route('customer.json') }}",
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
                    $('.popup-link').magnificPopup({
                        type: 'image'
                    });
                }
            });
        });

        /**
         * 更新查询条件并执行查询
         */
        function search() {
            search_query['customers.nickname'] = $("[name=nickname]").val();
            $('#bs-table').bootstrapTable("refresh");
        }

        /**
         * 自定义查看图片
         */
        function f_image(value, row, index, field) {
            return '<a class="popup-link" href="' + value + '">查看微信头像</a>';
        }

        /**
         * 自定义关注来源
         */
        function f_subscribe_scenee(value, row, index, field) {
            switch (value) {
                case 'ADD_SCENE_SEARCH':
                    return '公众号搜索';
                case 'ADD_SCENE_PROFILE_CARD':
                    return '名片分享';
                case 'ADD_SCENE_PROFILE_LINK':
                    return '图文页内名称点击';
                case 'ADD_SCENE_OTHERS':
                    return '其他'
            }
        }

    </script>
@endsection

@push('pageCss')
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/magnific-popup/magnific-popup.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
@endpush
