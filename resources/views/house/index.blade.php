@extends('layouts.app')

@section('title','户型管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">户型管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('house.index') }}">户型管理</a>
                </li>
                <li class="breadcrumb-item active">户型列表</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-actions">
                        <a href="{{ route('house.create') }}">
                            <button type="button" class="btn btn-success">添加户型</button>
                        </a>
                    </div>
                    <h3 class="panel-title">
                        户型管理
                        <span class="panel-desc">设置户型信息</span>
                    </h3>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form class="form-horizontal" autocomplete="off" onsubmit="return false;">
                        <div class="row">
                            <label class="col-md-2 col-form-label">户型名称：</label>
                            <div class="form-group col-sm-5">
                                <input type="text" class="form-control" name="name" maxlength="10" placeholder="户型名称" autocomplete="off">
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
                            <th data-field="name" data-class="text-truncate" data-width="30%">名称</th>
                            <th data-field="area" data-width="10%" data-sortable="true">面积</th>
                            <th data-field="weight" data-width="10%" data-sortable="true">排序</th>
                            <th data-field="created_at" data-width="15%" data-sortable="true">创建时间</th>
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
        search_query['houses.name'] = $("[name=name]").val();

        $(function () {
            var $table = $("#bs-table"),selections = [];

            $table.bootstrapTable({
                url: "{{ route('house.json') }}",
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
        });

        /**
         * 更新查询条件并执行查询
         */
        function search() {
            search_query['houses.name'] = $("[name=name]").val();
            $('#bs-table').bootstrapTable("refresh");
        }

        /**
         * 格式化操作信息
         */
        function f_operator(value, row, index, field) {

            let url = "{{config('app.url')}}" + "/house/" + row.id +'/edit';
            let roomUrl = "{{config('app.url')}}" + "/house/" + row.id +'/rooms';

            let butt = [
                '<a href="'+ url +'"><button type="button" class="btn btn-squared btn-outline btn-warning">编辑</button></a>',
                '<button type="button" class="btn btn-squared btn-outline btn-danger" onclick="destroy('+row.id+', 2)">禁用</button>',
                '<a href="'+ roomUrl +'"><button type="button" class="btn btn-squared btn-outline btn-info">房间</button></a>'
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
                        $('#delete-form').attr('action', "{{ config('app.url') }}" + "/house/" + id);
                        $('#delete-form').submit();
                    }
                }
            });
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
