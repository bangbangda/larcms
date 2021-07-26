@extends('layouts.app')

@section('title','分享海报管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">分享海报管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('activity.shareImage.index') }}">分享海报管理</a>
                </li>
                <li class="breadcrumb-item active">分享海报列表</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-actions">
                        <a href="{{ route('activity.shareImage.create') }}">
                            <button type="button" class="btn btn-success">添加分享海报</button>
                        </a>
                    </div>
                    <h3 class="panel-title">
                        分享海报管理
                        <span class="panel-desc">设置首页的分享海报信息</span>
                    </h3>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form autocomplete="off" onsubmit="return false;">
                        <div class="row">
                            <label class="col-md-2 col-form-label">开始时间：</label>
                            <div class="form-group col-sm-2">
                                <input type="text" class="form-control" data-plugin="datepicker" value="{{ old('start_date') }}" data-language="zh-CN" data-format="yyyy-mm-dd" name="start_date" maxlength="10" placeholder="创建时间" autocomplete="off">
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
                            <th data-field="url" data-formatter="f_image" data-width="20%">海报</th>
                            <th data-field="start_date" data-width="15%" data-sortable="true">开始时间</th>
                            <th data-field="end_date" data-width="15%" data-sortable="true">结束时间</th>
                            <th data-field="created_at" data-width="15%" data-sortable="true">创建时间</th>
                            <th data-width="15%" data-formatter="f_operator">操作</th>
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
        search_query['share_images.start_date'] = $("[name=start_date]").val();

        $(function () {
            var $table = $("#bs-table"),selections = [];

            $table.bootstrapTable({
                url: "{{ route('activity.shareImage.json') }}",
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
            search_query['share_images.start_date'] = $("[name=start_date]").val();
            $('#bs-table').bootstrapTable("refresh");
        }

        /**
         * 自定义查看图片
         */
        function f_image(value, row, index, field) {
            return '<a class="popup-link" href="' + value + '">查看海报图片</a>';
        }

        /**
         * 格式化操作信息
         */
        function f_operator(value, row, index, field) {

            var url = "{{config('app.url')}}" + "/shareImage/" + row.id +'/edit';
            var butt = [
                '<a href="'+ url +'"><button type="button" class="btn btn-squared btn-outline btn-warning">编辑</button></a>',
                '<button type="button" class="btn btn-squared btn-outline btn-danger" onclick="destroy('+row.id+', 2)">禁用</button>'
            ];

            return butt.join('&nbsp;&nbsp;&nbsp;');
        }


        /**
         * 更新状态
         *
         * @param id 编号
         * @param status 状态
         */
        function destroy(id) {
            bootbox.confirm({
                message: "确定删除标签吗？",
                buttons: {
                    confirm: {
                        label: '确认',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: '取消',
                        className: 'btn-warning'
                    }
                },
                callback: function (result) {
                    if (result) {
                        $('#delete-form').attr('action', "{{ config('app.url') }}" + "/shareImage/" + id);
                        $('#delete-form').submit();
                    }
                }
            });
        }
    </script>
@endsection

@push('pageCss')
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-select/bootstrap-select.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js"></script>
@endpush
