@extends('layouts.app')

@section('title','新闻管理')

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
                <li class="breadcrumb-item active">添加户型</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">添加户型</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <div class="example-wrap">
                                <form class="form-horizontal" method="post" action="{{ route('house.store') }}" enctype="multipart/form-data">
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
                                        <label class="col-md-3 col-form-label">户型名称：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" value="{{ old('name') }}" name="name" placeholder="户型名称" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">户型面积：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" value="{{ old('area') }}" name="area" placeholder="户型面积" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">户型排序：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" value="{{ old('weight') }}" name="weight" placeholder="户型排序" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">户型标签：</label>
                                        <div class="col-md-7 input-group">
                                            <input type="text" class="form-control" data-plugin="tokenfield" value="{{ old('tag') }}" name="tag" autocomplete="off">
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
                                        <label class="col-md-3 col-form-label">户型详情：</label>
                                        <div class="col-md-9 row sortable">
                                            <div class="col-md-3">
                                                <div class="upload-default">
                                                    <button type="button" class="btn btn-dark">
                                                        <i class="icon wb-upload" aria-hidden="true"></i> 上传
                                                    </button>
                                                </div>
                                            </div>
                                            @if(old('imageUrl'))
                                                @foreach(old('imageUrl') as $image)
                                                    <div class="col-md-3 text-center">
                                                        <figure class="overlay overlay-hover" style="width: auto;">
                                                            <img class="rounded h-250"  src="{{ $image }}">
                                                            <input type="hidden" name="imageUrl[]" value="{{ $image }}" />
                                                            <figcaption class="overlay-bottom overlay-panel overlay-background overlay-slide-top overlay-icon">
                                                                <i class="icon fa-trash delete-image" aria-hidden="true"></i>
                                                            </figcaption>
                                                        </figure>
                                                    </div>
                                                @endforeach
                                            @endif
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
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/html5sortable/sortable.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-tokenfield/bootstrap-tokenfield.css">
    <style type="text/css">
        .upload-default{
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 250px;
            border: 2px solid #efefef;
        }
        .bootstrap-select {
            width: 100% !important;
        }
    </style>
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/dropify/dropify.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/html5sortable/html.sortable.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-tokenfield/bootstrap-tokenfield.min.js"></script>

    <script src="{{ asset('vendor/ajax-uploader/SimpleAjaxUploader.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            sortable('.sortable', {
                handle: 'figure',
                placeholder: '<div class="col-md-3 h-250""></div>'
            })[0].addEventListener('sortupdate', function (e) {
                console.log(e.detail)
            });

            let uploaderImage = new ss.SimpleUpload({
                button: $(".btn-dark"), // HTML element used as upload button
                url: "{{ route('house.storeImage') }}", // URL of server-side upload handler
                name: 'image', // Parameter name of the uploaded file
                responseType: 'json',
                customHeaders: {
                    'X-CSRF-TOKEN': window.csrfToken
                },
                onComplete: function (filename, response, uploadBtn, fileSize){
                    if (response.status == 'success') {
                        addImageHtml(response.fileUrl);
                        sortable('.sortable');
                    }
                }
            });

            function addImageHtml(imageSrc) {
                let html = '' +
                    '<div class="col-md-3 text-center">' +
                    '    <figure class="overlay overlay-hover" style="width: auto;">' +
                    '        <img class="rounded h-250"  src="' + imageSrc + '">' +
                    '        <input type="hidden" name="imageUrl[]" value="' + imageSrc + '" />' +
                    '        <figcaption class="overlay-bottom overlay-panel overlay-background overlay-slide-top overlay-icon">' +
                    '            <i class="icon fa-trash delete-image" aria-hidden="true"></i>' +
                    '        </figcaption>' +
                    '    </figure>' +
                    '</div>';

                $(".sortable").append(html);

                $('.delete-image').click(function () {
                    let imageDiv = $(this).parent().parent().parent('div');
                    bootbox.confirm({
                        message: "确定删除吗？",
                        buttons: {
                            confirm: {
                                label: '确认',
                                className: 'btn-primary'
                            },
                            cancel: {
                                label: '取消',
                                className: 'btn-default'
                            }
                        },
                        callback: function (result) {
                            if (result) {
                                imageDiv.remove();
                            }
                        }
                    });
                });
            }

        })
    </script>
@endpush
