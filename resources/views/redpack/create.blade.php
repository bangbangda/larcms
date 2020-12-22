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
                <li class="breadcrumb-item active">添加红包设置</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        基础红包设置
                        <span class="panel-desc">成功获取用户手机号后或邀请好友，赠送指定的红包。</span>
                    </h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <form class="form-horizontal" action="{{ route('redpack-setting.store') }}" method="post">
                                @if ($errors->any())
                                    <div class="summary-errors alert alert-danger alert-dismissible">
                                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <p>错误信息如下：</p>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">红包类型：</label>
                                    <div class="col-md-7">
                                        <select name="type" data-plugin="selectpicker">
                                            <option value=""></option>
                                            <option value="basis" @if(old('type') == 'basis') selected @endif>基础红包</option>
                                            <option value="share" @if(old('type') == 'share') selected @endif>分享红包</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">基础红包金额：</label>
                                    <div class="col-md-6 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">¥</span>
                                        </div>
                                        <input type="text" class="form-control" name="amount" placeholder="基础红包金额" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">元</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">红包规则有效期：</label>
                                    <div class="col-md-3 input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control" data-plugin="datepicker" data-language="zh-CN" data-format="yyyy-mm-dd" name="start_date"  placeholder="开始时间" autocomplete="off">
                                    </div>
                                    <div class="col-md-3 input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control" data-plugin="datepicker" data-format="yyyy-mm-dd" data-language="zh-CN" name="end_date" placeholder="结束时间" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">红包金额：</label>
                                    <div class="col-md-3 input-group">
                                        <input type="text" class="form-control" name="step_amount[]" placeholder="红包金额" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">元</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 input-group">
                                        <input type="text" class="form-control" name="hit_rate[]" placeholder="命中率"  autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"><i class="icon wb-plus" aria-hidden="true" style="font-size: 18px;"></i></label>
                                    <div class="col-md-3 input-group">
                                        <input type="text" class="form-control" name="step_amount[]" placeholder="红包金额" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">元</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 input-group">
                                        <input type="text" class="form-control" name="hit_rate[]" placeholder="命中率"  autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="list">

                                </div>

                                <div class="form-group row">
                                    <br />
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9 offset-md-5">
                                        <button type="submit" class="btn btn-primary">提交 </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            // 动态添加答案
            $('.wb-plus').on('click', function () {
                $('#list').append('<div class="form-group row">' +
                    ' <label class="col-sm-3 col-form-label"><i class="icon wb-close" aria-hidden="true" style="font-size: 18px;"></i></label>' +
                    ' <div class="col-md-3 input-group">' +
                    ' <input type="text" class="form-control" name="step_amount[]" placeholder="红包金额" autocomplete="off">' +
                    ' <div class="input-group-append">' +
                    ' <span class="input-group-text">元</span>' +
                    ' </div>' +
                    ' </div>' +
                    ' <div class="col-md-3 input-group">' +
                    ' <input type="text" class="form-control" name="hit_rate[]" placeholder="命中率"  autocomplete="off">' +
                    ' <div class="input-group-append">' +
                    ' <span class="input-group-text">%</span>' +
                    ' </div>' +
                    ' </div>' +
                    ' </div>');
            });
            // 动态删除答案
            $(document).on("click",".wb-close",function(){
                $(this).parent().parent().hide();
            });
        })
    </script>
@endsection

@push('pageCss')
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-select/bootstrap-select.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-select/bootstrap-select.min.js"></script>
@endpush
