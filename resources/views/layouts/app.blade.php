
<!DOCTYPE html>
<html class="no-js css-menubar" lang="zh-cn">
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
    <!-- Safari浏览器添加到主屏幕（IOS） -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Admui">

    <title>@yield('title', '管理后台') - Admui</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/themes/global/css/bootstrap.css">

    <!-- 字体图标 CSS -->
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/fonts/font-awesome/font-awesome.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/fonts/web-icons/web-icons.css">

    <!-- Site CSS -->
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/themes/base/css/site.css" id="admui-siteStyle">

    <!-- 插件 CSS -->
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/animsition/animsition.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/toastr/toastr.css">
    <link rel="stylesheet" href="https://admui.bangbangda.me/public/vendor/mCustomScrollbar/jquery.mCustomScrollbar.css">

    <!-- Page CSS -->
    @stack('pageCss')

    <!-- 插件 -->
    <script src="https://admui.bangbangda.me/public/vendor/jquery/jquery.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/lodash/lodash.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/breakpoints/breakpoints.min.js"></script>

    <!--[if lt IE 10]>
    <script src="https://admui.bangbangda.me/public/vendor/media-match/media.match.min.js"></script>
    <script src="https://admui.bangbangda.me/public/vendor/respond/respond.min.js"></script>
    <![endif]-->

    <!-- 核心 -->
    <script src="https://admui.bangbangda.me/public/themes/global/js/core.js"></script>
    <script src="https://admui.bangbangda.me/public/themes/global/js/configs/site-configs.js"></script>
    <script src="https://admui.bangbangda.me/public/themes/global/js/components.js"></script>
    <script src="https://admui.bangbangda.me/public/themes/base/js/site.js"></script>

    <!-- Livewire -->
    @livewireStyles

    <script>
        'use strict';
        Breakpoints();
    </script>
</head>
<body class="site-menubar-unfold " data-theme="base">
    <nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-inverse" id="admui-siteNavbar" role="navigation">
        @livewire('navbar-header')
    </nav>
    <nav class="site-menubar" id="admui-siteMenubar">
        @livewire('menubar-left')
    </nav>

    <main class="site-page">
        <div class="page-container" id="admui-pageContent">
            @yield('content')
        </div>
    </main>

<footer class="site-footer">
    <div class="site-footer-legal">大连起缘科技 &copy;
        <a href="https://www.qiyuankeji.cn" target="_blank">qiyuankeji.cn</a>
    </div>
    <div class="site-footer-right">
        当前版本：v2.1.0
    </div>
</footer>
<!-- 插件 -->
<script src="https://admui.bangbangda.me/public/themes/global/js/plugins/responsive-tabs.js"></script>
<script src="https://admui.bangbangda.me/public/vendor/artTemplate/template-web.js"></script>
<script src="https://admui.bangbangda.me/public/vendor/toastr/toastr.min.js"></script>
<script src="https://admui.bangbangda.me/public/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>
<script src="https://admui.bangbangda.me/public/vendor/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://admui.bangbangda.me/public/vendor/screenfull/screenfull.min.js"></script>
<script src="https://admui.bangbangda.me/public/vendor/bootbox/bootbox.min.js"></script>

    <!-- Page JS -->
    @stack('pageScript')
<!-- Livewire JS -->
@livewireScripts
    <script type="text/javascript">
        $(function () {
            $('#logout').click(function () {
                $('#logoutForm').submit();
            });
        })
    </script>
    @include('layouts._message')
</body>
</html>