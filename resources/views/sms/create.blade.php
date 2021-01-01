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
                    <a href="{{ route('sms.index') }}">短信管理</a>
                </li>
                <li class="breadcrumb-item active">添加短信发送任务</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">添加短信任务</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <div class="example-wrap">
                                <form class="form-horizontal" method="post" action="{{ route('sms.store') }}">
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
                                        <label class="col-md-3 col-form-label">短信内容：</label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" rows="4" name="content" id="content"></textarea>
                                            <p class="form-text">共 0 字，1 条短信。</p>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline btn-info" id="checkContent">检测内容</button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <br />
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-2 offset-md-5">
                                            <button type="submit" class="btn btn-block btn-primary">提交 </button>
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
@endpush

@push('pageScript')
    <script type="text/javascript">
        $(function () {
            $("#checkContent").click(function (){
                let content = $("#content").val();
                axios.post("{{ route('sms.checkContent') }}", {
                    'content': content,
                }).then(function (response) {
                    if (response.data.code == 0) {
                        toastr.success("验证成功");
                    } else {
                        toastr.error(response.data.msg);
                    }
                })
            });
        });
    </script>
@endpush
