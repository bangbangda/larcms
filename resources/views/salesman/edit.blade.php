@extends('layouts.app')

@section('title','专属顾问管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">专属顾问管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('salesman.index') }}">专属顾问管理</a>
                </li>
                <li class="breadcrumb-item active">编辑专属顾问</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">编辑专属顾问</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <div class="example-wrap">
                                <form class="form-horizontal" method="post" action="{{ route('salesman.update', $salesman->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
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
                                        <label class="col-md-3 col-form-label">顾问名称：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" name="name" value="{{ $salesman->name }}" autocomplete="off" placeholder="顾问名称">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">头像文件：</label>
                                        <div class="col-md-7">
                                            <input type="file" class="form-control" name="image" data-plugin="dropify" data-default-file="{{ $salesman->avatar_url }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">顾问职位：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" name="position" value="{{ $salesman->position }}" placeholder="顾问职位">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">手机号：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" name="phone" value="{{ $salesman->phone }}" placeholder="手机号">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">微信号：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" name="wechat" value="{{ $salesman->wechat }}" placeholder="微信号">
                                        </div>
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
    </div>
@endsection

@push('pageCss')
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/dropify/dropify.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/dropify/dropify.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js"></script>
@endpush
