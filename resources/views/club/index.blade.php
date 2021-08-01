@extends('layouts.app')

@section('title','会所管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">会所管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('club.index') }}">会所管理</a>
                </li>
                <li class="breadcrumb-item active">会所列表</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        会所房间管理
                        <span class="panel-desc">管理小程序端会所页面的显示信息，每个房间只允许传1张图片。</span>
                    </h3>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form autocomplete="off" onsubmit="return false;">
                        <div class="row">
                            <label class="col-md-2 col-form-label">房间名称：</label>
                            <div class="form-group col-sm-4">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"  maxlength="20" placeholder="类型名称" autocomplete="off">
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
                        <a href="{{ route('club.create') }}">
                            <button type="button" class="btn btn-success">添加会所类型</button>
                        </a>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <table class="table" id="bs-table" >
                        <thead>
                        <tr>
                            <th data-field="id" data-width="5%">编号</th>
                            <th data-field="name" data-width="20%">房间名称</th>
                            <th data-field="image_url" data-formatter="f_image" data-width="10%">图片</th>
                            <th data-field="weight" data-width="15%">排序</th>
                            <th data-width="10%" data-formatter="f_operator">操作</th>
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
        search_query['clubs.name'] = $("[name=name]").val();

        $(function () {
            var $table = $("#bs-table"),selections = [];

            $table.bootstrapTable({
                url: "{{ route('club.json') }}",
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

            $("#create").click(function () {
                $('#create-form').submit();
            });

        });

        /**
         * 格式化操作信息
         */
        function f_operator(value, row, index, field) {
            var url = "{{config('app.url')}}" + "/club/" + row.id +'/edit';
            var butt = [
                '<a href="'+ url +'"><button type="button" class="btn btn-squared btn-outline btn-warning">编辑</button></a>',
                '<button type="button" class="btn btn-squared btn-outline btn-danger" onclick="destroy('+row.id+', 2)">禁用</button>'
            ];

            return butt.join('&nbsp;&nbsp;&nbsp;');
        }


        /**
         * 自定义查看图片
         */
        function f_image(value, row, index, field) {
            return '<a class="popup-link" href="' + value + '">查看海报图片</a>';
        }


        /**
         * 更新查询条件并执行查询
         */
        function search() {
            search_query['clubs.name'] = $("[name=name]").val();
            $('#bs-table').bootstrapTable("refresh");
        }

        /**
         * 更新状态
         *
         * @param id 编号
         * @param status 状态
         */
        function destroy(id) {
            bootbox.confirm({
                message: "确定删除吗？",
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
                        $('#delete-form').attr('action', "{{ config('app.url') }}" + "/club/" + id);
                        $('#delete-form').submit();
                    }
                }
            });
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
