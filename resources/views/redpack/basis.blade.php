@extends('layouts.app')

@section('title','基础红包')

@section('content')
    <div class="page animation-fade page-forms">
        <div class="page-header">
            <h1 class="page-title">红包设置</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>红包设置</a>
                </li>
                <li class="breadcrumb-item active">基础红包设置</li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">基础红包设置</h3>
                </div>
                <div class="panel-body container-fluid">
                    <div class="row row-lg">
                        <div class="col-md-12 col-lg-10">
                            <div class="example-wrap">
                                <livewire:redpack.basis :redpack="$redpack" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('pageCss')
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
@endpush

@push('pageScript')
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js"></script>
@endpush
