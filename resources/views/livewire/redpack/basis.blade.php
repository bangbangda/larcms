<form class="form-horizontal" wire:submit.prevent="submit">
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
        <label class="col-md-3 col-form-label">基础红包金额：</label>
        <div class="col-md-7 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">¥</span>
            </div>
            <input type="text" class="form-control" wire:model.defer="amount" placeholder="基础红包金额" autocomplete="off">
            <div class="input-group-append">
                <span class="input-group-text">元</span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">随机红包金额：</label>
        <div class="col-md-3 input-group">
            <input type="text" class="form-control" wire:model="min_random_amount" placeholder="最小金额" autocomplete="off">
            <div class="input-group-append">
                <span class="input-group-text">元</span>
            </div>
        </div>
        <div class="col-md-1">
            至
        </div>
        <div class="col-md-3 input-group">
            <input type="text" class="form-control" wire:model="max_random_amount" placeholder="最大金额"  autocomplete="off">
            <div class="input-group-append">
                <span class="input-group-text">元</span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">随机红包有效期：</label>
        <div class="col-md-3 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="icon wb-calendar" aria-hidden="true"></i>
                </span>
            </div>
            <input type="text" class="form-control" data-plugin="datepicker" data-language="zh-CN" data-format="yyyy-mm-dd" wire:model="start_date"  placeholder="开始时间" autocomplete="off">
        </div>
        <div class="col-md-1">
            至
        </div>
        <div class="col-md-3 input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="icon wb-calendar" aria-hidden="true"></i>
                </span>
            </div>
            <input type="text" class="form-control" data-plugin="datepicker" data-format="yyyy-mm-dd" data-language="zh-CN" wire:model="end_date" placeholder="结束时间" autocomplete="off">
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