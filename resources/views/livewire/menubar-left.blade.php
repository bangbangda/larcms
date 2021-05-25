<div class="site-menubar-body">
    <div class="tab-content h-full" id="admui-navTabs">
        <div class="tab-pane animation-fade h-full active" id="admui-navTabsItem-2" role="tabpanel">
            <ul class="site-menu">

                <li class="site-menu-category">仪表盘</li>
                <li class="site-menu-item {{ Ekko::isActiveRoute('dashboard') }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="site-menu-icon fa-tachometer" aria-hidden="true"></i>
                        <span class="site-menu-title">仪表盘</span>
                    </a>
                </li>
                <li class="site-menu-category">微信管理</li>
                <li class="site-menu-item has-sub {{ Ekko::isActiveRoute('redpack.*', 'open') }}">
                    <a href="javascript:;">
                        <i class="site-menu-icon fa-laptop" aria-hidden="true"></i>
                        <span class="site-menu-title">红包管理</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item {{ Ekko::isActiveRoute('redpack.setting.*') }}" >
                            <a href="{{ route('redpack.setting.index') }}">
                                <span class="site-menu-title">红包设置</span>
                            </a>
                        </li>
                        <li class="site-menu-item {{ Ekko::isActiveRoute('redpack.randomCode.*') }}" >
                            <a href="{{ route('redpack.randomCode.index') }}">
                                <span class="site-menu-title">随机码红包</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="site-menu-item has-sub {{ Ekko::isActiveRoute('material.*', 'open') }}">
                    <a href="javascript:;">
                        <i class="site-menu-icon fa-video-camera" aria-hidden="true"></i>
                        <span class="site-menu-title">素材管理</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item {{ Ekko::isActiveRoute('material.wechatMaterial.*') }}" >
                            <a href="{{ route('material.wechatMaterial.index') }}">
                                <span class="site-menu-title">基本素材</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="site-menu-item {{ Ekko::isActiveRoute('customer.*') }}">
                    <a href="{{ route('customer.index') }}">
                        <i class="site-menu-icon fa-user-circle" aria-hidden="true"></i>
                        <span class="site-menu-title">客户管理</span>
                    </a>
                </li>

                <li class="site-menu-item {{ Ekko::isActiveRoute('sms.*') }}">
                    <a href="{{ route('sms.index') }}">
                        <i class="site-menu-icon fa-envelope" aria-hidden="true"></i>
                        <span class="site-menu-title">短信管理</span>
                    </a>
                </li>
                <li class="site-menu-category">活动管理</li>
                <li class="site-menu-item has-sub {{ Ekko::isActiveRoute(['activity.*', 'club.*'], 'open') }}">
                    <a href="javascript:;">
                        <i class="site-menu-icon fa-share-alt" aria-hidden="true"></i>
                        <span class="site-menu-title">首页管理</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item {{ Ekko::isActiveRoute('activity.shareImage.*') }}" >
                            <a href="{{ route('activity.shareImage.index') }}">
                                <span class="site-menu-title">分享图片</span>
                            </a>
                        </li>
                        <li class="site-menu-item {{ Ekko::isActiveRoute('club.*') }}" >
                            <a href="{{ route('club.index') }}">
                                <span class="site-menu-title">会所管理</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>