@extends('layouts.app')

@section('title','新闻管理')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">新闻管理</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('activity.news.index') }}">新闻管理</a>
                </li>
                <li class="breadcrumb-item active">添加新闻</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">添加新闻</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <div class="example-wrap">
                                <form class="form-horizontal" method="post" action="{{ route('activity.news.store') }}" enctype="multipart/form-data">
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
                                        <label class="col-md-3 col-form-label">新闻标题：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" value="{{ old('title') }}" name="title" placeholder="新闻标题" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">跳转地址：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" value="{{ old('original_url') }}" name="original_url" placeholder="跳转地址" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">封面图片：</label>
                                        <div class="col-md-7">
                                            <input type="file" class="form-control" name="image" data-plugin="dropify" data-default-file="">
                                            <p class="form-text">封面图片 720 * 320</p>
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
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/dropify/dropify.min.js"></script>
@endpush
