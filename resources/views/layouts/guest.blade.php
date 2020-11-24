<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>



<!DOCTYPE html>
<html class="no-js css-menubar" lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 移动设备 viewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,minimal-ui">
    <meta name="author" content="admui.com">
    <!-- 360浏览器默认使用Webkit内核 -->
    <meta name="renderer" content="webkit">
    <!-- 禁止搜索引擎抓取 -->
    <meta name="robots" content="nofollow">
    <!-- 禁止百度SiteAPP转码 -->
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <!-- Chrome浏览器添加桌面快捷方式（安卓） -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" type="image/png" href="../public/images/favicon.png">
    <!-- Safari浏览器添加到主屏幕（IOS） -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Admui">
    <link rel="icon" sizes="192x192" href="../public/images/apple-touch-icon.png">

    <!-- Win8标题栏及ICON图标 -->
    <meta name="msapplication-TileColor" content="#62a8ea">
    <meta name="msapplication-TileImage" content="../public/images/app-icon72x72@2x.png">
    <link rel="apple-touch-icon-precomposed" href="../public/images/apple-touch-icon.png">

    <title>登录 - {{ config('app.name', 'LarCMS') }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../public/themes/global/css/bootstrap.css">

    <!-- 字体图标 CSS -->
    <link rel="stylesheet" href="../public/fonts/web-icons/web-icons.css">

    <!-- Site CSS -->
    <link rel="stylesheet" href="../public/themes/base/css/site.css" id="admui-siteStyle">

    <!-- 插件 CSS -->
    <link rel="stylesheet" href="../public/vendor/animsition/animsition.css">

    <!-- Page CSS -->
    <link rel="stylesheet" href="../public/css/login.css">

    <!--[if lt IE 10]>
    <script src="../public/vendor/media-match/media.match.min.js"></script>
    <script src="../public/vendor/respond/respond.min.js"></script>
    <![endif]-->

</head>
<body class="page-login layout-full page-dark">

<div class="page h-full">
    <div class="page-content h-full">
        <div class="page-brand-info vertical-align animation-slide-left d-none d-sm-block">
            <div class="page-brand vertical-align-middle">
                <div class="brand">
                    <img class="brand-img" src="../public/images/logo-white.svg" height="50" alt="Admui">
                </div>
                <h2 class="title">Admui 通用管理系统快速开发框架</h2>
                <ul class="list-icons description">
                    <li>
                        <i class="wb-check" aria-hidden="true"></i> Admui 是一个基于最新 Web
                        技术的企业级通用管理系统快速开发框架，可以帮助企业极大的提高工作效率，节省开发成本，提升品牌形象。
                    </li>
                    <li>
                        <i class="wb-check" aria-hidden="true"></i> 您可以 Admui 为基础，快速开发各种MIS系统，如CMS、OA、CRM、ERP、POS等。</li>
                    <li>
                        <i class="wb-check" aria-hidden="true"></i> Admui 紧贴业务特性，涵盖了大量的常用组件和基础功能，最大程度上帮助企业节省时间成本和费用开支。
                    </li>
                </ul>
                <div class="description">
                    <a href="http://www.admui.com" class="btn btn-primary mr-5" target="_blank">
                        <i class="icon wb-home"></i> 访问官网
                    </a>
                    <a href="http://docs.admui.com/basic/" class="btn btn-success" target="_blank">
                        <i class="icon wb-book"></i> 开发文档
                    </a>
                </div>
            </div>
        </div>
        <div class="page-login-main animation-fade">
            <div class="alert alert-danger alert-dismissible" role="alert">
                用户名或密码错误！
            </div>
            <div class="vertical-align">
                <div class="vertical-align-middle">
                    <div class="brand text-center">
                        <img class="brand-img" src="../public/images/logo.svg" height="50" alt="Admui">
                    </div>
                    <h3 class="title">登录 Admui</h3>
                    <p class="description">Admui 在线演示系统</p>
                    <form class="login-form" action="/system/loginValidate" method="post" id="loginForm">
                        <div class="form-group">
                            <label class="sr-only" for="username">用户名</label>
                            <input type="text" class="form-control" id="username" name="loginName" placeholder="请输入用户名">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="password">密码</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="password">验证码</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="validCode" placeholder="请输入验证码">
                                <div class="input-group-append">
                                    <a href="javascript:;" class="btn btn-default btn-outline p-0 m-0 reload-vify">
                                        <img src="http://demo.admui.com/system/captcha" height="40">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">自动登录</label>
                            </div>
                            <a class="float-right collapsed" data-toggle="collapse" href="#forgetPassword"
                               aria-expanded="false" aria-controls="forgetPassword">
                                忘记密码了？
                            </a>
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
                <p>上海畅控 &copy;
                    <a href="http://www.admui.com" target="_blank">admui.com</a>
                </p>
            </footer>
        </div>
    </div>
</div>

<!-- 插件 -->
<script src="../public/vendor/jquery/jquery.min.js"></script>
<script src="../public/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="../public/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="../public/vendor/jquery-validation/localization/messages_zh.js"></script>

</body>
</html>
