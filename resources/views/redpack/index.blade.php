@extends('layouts.app')

@section('title','红包设置')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">红包设置</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('redpack-setting.index') }}">红包设置</a>
                </li>
                <li class="breadcrumb-item active">红包设置列表</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-actions">
                        <a href="{{ route('redpack-setting.create') }}">
                            <button type="button" class="btn btn-success">添加红包</button>
                        </a>
                    </div>
                    <h3 class="panel-title">
                        红包设置管理
                        <span class="panel-desc">邀请好友、绑定手机号赠送红包设置</span>
                    </h3>
                </div>
                <div class="panel-body" style="padding-bottom: 10px;">
                    <form autocomplete="off" onsubmit="return false;">
                        <div class="row">
                            <label class="col-md-1 col-form-label">红包类型：</label>
                            <div class="form-group col-sm-3">
                                <select name="type" data-plugin="selectpicker">
                                    <option value=""></option>
                                    <option value="basis" @if(old('type') == 'basis') selected @endif>基础红包</option>
                                    <option value="share" @if(old('type') == 'share') selected @endif>分享红包</option>
                                </select>
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
                            <th data-field="type" data-width="15%">类型</th>
                            <th data-field="step_amount" data-width="15%">红包金额</th>
                            <th data-field="hit_rate" data-width="15%">命中率</th>
                            <th data-field="start_date" data-width="15%" data-sortable="true">开始时间</th>
                            <th data-field="end_date" data-width="15%" data-sortable="true">结束时间</th>
                            <th data-width="20%" data-formatter="f_operator">操作</th>
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
        search_query['wechat_materials.title'] = $("[name=title]").val();

        $(function () {
            var $table = $("#bs-table"),selections = [];

            $table.bootstrapTable({
                url: "{{ route('redpack-setting.json') }}",
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
                detailFormatter: function (index, row, element) {
                    return '1';
                }
            });
        });

        /**
         * 更新查询条件并执行查询
         */
        function search() {
            search_query['redpack_settings.type'] = $("[name=type]").val();
            $('#bs-table').bootstrapTable("refresh");
        }


        /**
         * 格式化操作信息
         */
        function f_operator(value, row, index, field) {

            var url = "{{config('app.url')}}" + "/share/message-tag/" + row.id +'/edit';
            var butt = [
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
                        $('#delete-form').attr('action', "{{ config('app.url') }}" + "wechatMaterial/" + id);
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
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-select/bootstrap-select.min.js"></script>
@endpush