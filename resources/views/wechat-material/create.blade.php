@extends('layouts.app')

@section('title','素材管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">素材管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('material.wechatMaterial.index') }}">素材管理</a>
                </li>
                <li class="breadcrumb-item active">添加基础素材</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">添加基础素材</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <div class="example-wrap">
                                <form class="form-horizontal" method="post" action="{{ route('material.wechatMaterial.store') }}" enctype="multipart/form-data">
                                    @csrf
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
                                        <label class="col-md-3 col-form-label">素材标题：</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="title" placeholder="素材标题" value="{{ old('title') }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">素材类型：</label>
                                        <div class="col-md-7">
                                            <select name="type" data-plugin="selectpicker">
                                                <option value=""></option>
                                                <option value="image" @if(old('type') == 'image') selected @endif>图片</option>
                                                <option value="video" @if(old('type') == 'video') selected @endif>视频</option>
                                                <option value="voice" @if(old('type') == 'voice') selected @endif>语音</option>
                                                <option value="thumb" @if(old('type') == 'thumb') selected @endif>缩略图</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">素材文件：</label>
                                        <div class="col-md-7">
                                            <input type="file" class="form-control" name="material" data-plugin="dropify" data-default-file="">
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
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-select/bootstrap-select.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/dropify/dropify.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-select/bootstrap-select.min.js"></script>
@endpush
