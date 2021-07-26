@extends('layouts.app')

@section('title','短信管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">短信管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('customer.index') }}">短信管理</a>
                </li>
                <li class="breadcrumb-item active">短信列表</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        短信发送管理
                        <span class="panel-desc">添加短信内容，群发短信，确认发送进度。</span>
                    </h3>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form autocomplete="off" onsubmit="return false;">
                        <div class="row">
                            <label class="col-md-2 col-form-label">短信内容：</label>
                            <div class="form-group col-sm-4">
                                <input type="text" class="form-control" name="content" value="{{ old('content') }}"  maxlength="10" placeholder="短信内容" autocomplete="off">
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
                        <a href="{{ route('sms.create') }}">
                            <button type="button" class="btn btn-success">添加短信任务</button>
                        </a>
                    </div>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <table class="table" id="bs-table" >
                        <thead>
                        <tr>
                            <th data-field="id" data-width="5%">编号</th>
                            <th data-field="uuid" data-width="15%">唯一编号</th>
                            <th data-field="content" data-width="50%">短信内容</th>
                            <th data-field="state" data-width="15%">状态</th>
                            <th data-width="10%" data-formatter="f_operator">操作</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // 初始化查询条件
        var search_query = {};
        search_query['sms_send_messages.content'] = $("[name=content]").val();

        $(function () {
            var $table = $("#bs-table"),selections = [];

            $table.bootstrapTable({
                url: "{{ route('sms.json') }}",
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
         * 格式化操作信息
         */
        function f_operator(value, row, index, field) {
            let url = "{{config('app.url')}}" + "/sms/" + row.id;
            var butt = [
                '<a href="'+url+'"><button type="button" class="btn btn-squared btn-outline btn-info">发送详情</button></a>'
            ];

            return butt.join('&nbsp;&nbsp;&nbsp;');
        }

        /**
         * 更新查询条件并执行查询
         */
        function search() {
            search_query['sms_send_messages.content'] = $("[name=content]").val();
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
