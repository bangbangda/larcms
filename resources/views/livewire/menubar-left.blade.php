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
                        <li class="site-menu-item {{ Ekko::isActiveRoute('redpack.basis') }}" >
                            <a href="{{ route('redpack.basis') }}">
                                <span class="site-menu-title">基础红包</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a href="/html/examples/components/layouts/two-columns.html">
                                <span class="site-menu-title">排名红包</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a href="/html/examples/components/layouts/panel-transition.html">
                                <span class="site-menu-title">裂变红包</span>
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
                        <li class="site-menu-item">
                            <a href="/html/examples/components/layouts/two-columns.html">
                                <span class="site-menu-title">排名红包</span>
                            </a>
                        </li>
                        <li class="site-menu-item">
                            <a href="/html/examples/components/layouts/panel-transition.html">
                                <span class="site-menu-title">裂变红包</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>