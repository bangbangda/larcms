<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://admui.bangbangda.me/public/themes/global/css/bootstrap.css">

        <!-- 字体图标 CSS -->
        <link rel="stylesheet" href="https://admui.bangbangda.me/public/fonts/web-icons/web-icons.css">

        <!-- Site CSS -->
        <link rel="stylesheet" href="https://admui.bangbangda.me/public/themes/base/css/site.css" id="admui-siteStyle">

        <!-- 插件 -->
        <script src="https://admui.bangbangda.me/public/vendor/jquery/jquery.min.js"></script>

        <!-- 插件 CSS -->
        <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/animsition/animsition.css">

        <!-- Page CSS -->
        <link rel="stylesheet" href="https://admui.bangbangda.me/public/css/login.css">

        @livewireStyles
    </head>
    <body class="page-login layout-full page-dark">
        <div class="page h-full">
            <div class="page-content h-full">
{{--                <div class="page-brand-info vertical-align animation-slide-left d-none d-sm-block">--}}
{{--                    <div class="page-brand vertical-align-middle">--}}
{{--                        <div class="brand">--}}
{{--                            <img class="brand-img" src="../public/images/logo-white.svg" height="50" alt="Admui">--}}
{{--                        </div>--}}
{{--                        <h2 class="title">Admui 通用管理系统快速开发框架</h2>--}}
{{--                        <ul class="list-icons description">--}}
{{--                            <li>--}}
{{--                                <i class="wb-check" aria-hidden="true"></i> Admui 是一个基于最新 Web--}}
{{--                                技术的企业级通用管理系统快速开发框架，可以帮助企业极大的提高工作效率，节省开发成本，提升品牌形象。--}}
{{--                            </li>--}}
{{--                            <li>--}}
{{--                                <i class="wb-check" aria-hidden="true"></i> 您可以 Admui 为基础，快速开发各种MIS系统，如CMS、OA、CRM、ERP、POS等。</li>--}}
{{--                            <li>--}}
{{--                                <i class="wb-check" aria-hidden="true"></i> Admui 紧贴业务特性，涵盖了大量的常用组件和基础功能，最大程度上帮助企业节省时间成本和费用开支。--}}
{{--                            </li>--}}
{{--                        </ul>--}}

{{--                    </div>--}}
{{--                </div>--}}
                <div class="page-login-main animation-fade">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @livewireScripts
    </body>

    <script type="text/javascript">
        $(function () {
            $('.reload-vify').on('click', function() {
                var $img = $(this).children('img');
                var URL = $img.prop('src');

                $img.prop('src', URL + '?tm=' + Math.random());
            });
        })
    </script>
</html>