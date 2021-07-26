<x-guest-layout>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            @foreach ($errors->all() as $message)
                {{ $message }}
            @endforeach
        </div>
    @endif
    <div class="vertical-align">
        <div class="vertical-align-middle">
            <div class="brand text-center">
                <img class="brand-img" src="https://admui.bangbangda.me/public/images/logo.svg" height="50" alt="Admui">
            </div>
            <h3 class="title">登录LARCMS</h3>
            <p class="description">房产营销专业管理平台</p>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="sr-only" for="username">用户名</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="请输入用户名">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">密码</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">验证码</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="validCode" maxlength="4" placeholder="请输入验证码">
                        <div class="input-group-append">
                            <a href="#" class="btn btn-default btn-outline p-0 m-0 reload-vify">
                                <img src="{{ captcha_src('flat') }}" height="40">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
                        <input type="checkbox" name="remember">
                        <label for="remember">自动登录</label>
                    </div>
                </div>
                <div class="collapse" id="forgetPassword" aria-expanded="true">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        请联系管理员重置密码。
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">立即登录</button>
            </form>
        </div>
    </div>


    <footer class="page-copyright">
        <p>大连起缘科技 &copy;
            <a href="https://www.qiyuankeji.cn" target="_blank">qiyuankeji.cn</a>
        </p>
    </footer>
</x-guest-layout>
