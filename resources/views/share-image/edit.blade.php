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
                    <a href="{{ route('material.wechatMaterial.index') }}">分享海报管理</a>
                </li>
                <li class="breadcrumb-item active">添加分享海报</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">添加分享海报</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <div class="example-wrap">
                                <form class="form-horizontal" method="post" action="{{ route('activity.shareImage.update', $shareImage->id) }}" enctype="multipart/form-data">
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
                                        <label class="col-md-3 col-form-label">海报有效期：</label>
                                        <div class="col-md-3 input-group">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                        </span>
                                            </div>
                                            <input type="text" class="form-control" data-plugin="datepicker" value="{{ old('start_date', $shareImage->start_date) }}" data-language="zh-CN" data-format="yyyy-mm-dd" name="start_date" maxlength="10" placeholder="开始时间" autocomplete="off">
                                        </div>
                                        <div class="col-md-3 input-group">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="icon wb-calendar" aria-hidden="true"></i>
                                        </span>
                                            </div>
                                            <input type="text" class="form-control" data-plugin="datepicker" value="{{ old('end_date', $shareImage->end_date) }}" data-format="yyyy-mm-dd" data-language="zh-CN" name="end_date" placeholder="结束时间" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">海报文件：</label>
                                        <div class="col-md-7">
                                            <input type="file" class="form-control" name="image" data-plugin="dropify" data-default-file="{{ $shareImage->url }}">
                                            <p class="form-text">海报尺寸为 720 * 1558</p>
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
