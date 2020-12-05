<div class="navbar-header">
    <div @if($hiddenNavbar) style="display: none;" @endif>
        <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided" data-toggle="menubar">
            <span class="sr-only">切换菜单</span>
            <span class="hamburger-bar"></span>
        </button>
        <button type="button" class="navbar-toggler collapsed" data-target="#admui-navbarCollapse" data-toggle="collapse">
            <i class="icon wb-more-horizontal" aria-hidden="true"></i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <img class="navbar-brand-logo d-sm-block d-lg-block d-none navbar-logo" src="https://admui.bangbangda.me/public/images/logo-white.svg"
                 title="Admui">
            <img class="navbar-brand-logo d-sm-none navbar-logo-mini" src="https://admui.bangbangda.me/public/images/logo-white-min.svg" title="Admui">
        </div>
    </div>
</div>

<div class="navbar-container container-fluid">
    <div class="collapse navbar-collapse navbar-collapse-toolbar" id="admui-navbarCollapse">
        <ul class="nav navbar-toolbar navbar-left" @if($hiddenNavbarMenu)style="display: none;"@endif>
            <li class="nav-item hidden-float" id="toggleMenubar">
                <a class="nav-link" data-toggle="menubar" href="javascript:;" role="button" id="admui-toggleMenubar">
                    <i class="icon hamburger hamburger-arrow-left">
                        <span class="sr-only">切换目录</span>
                        <span class="hamburger-bar"></span>
                    </i>
                </a>
            </li>
            <li class="navbar-menu nav-tabs-horizontal nav-tabs-animate is-load" id="admui-navMenu">
                    <ul class="nav navbar-toolbar nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#admui-navTabsItem-2" aria-controls="admui-navTabsItem-2"
                               role="tab" aria-expanded="false">
                                <i class="icon wb-library"></i>
                                <span>UI 示例</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admui-navTabsItem-3" aria-controls="admui-navTabsItem-3"
                               role="tab" aria-expanded="false">
                                <i class="icon wb-desktop"></i>
                                <span>页面示例</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admui-navTabsItem-4" aria-controls="admui-navTabsItem-4"
                               role="tab" aria-expanded="false">
                                <i class="icon wb-table"></i>
                                <span>表格示例</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admui-navTabsItem-5" aria-controls="admui-navTabsItem-5"
                               role="tab" aria-expanded="false">
                                <i class="icon wb-order"></i>
                                <span>表单示例</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admui-navTabsItem-6" aria-controls="admui-navTabsItem-6"
                               role="tab" aria-expanded="false">
                                <i class="icon wb-pie-chart"></i>
                                <span>统计图表</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admui-navTabsItem-7" aria-controls="admui-navTabsItem-7"
                               role="tab" aria-expanded="false">
                                <i class="icon wb-menu"></i>
                                <span>菜单示例</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#admui-navTabsItem-8" aria-controls="admui-navTabsItem-8"
                               role="tab" aria-expanded="false">
                                <i class="icon wb-settings"></i>
                                <span>系统管理</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown" id="admui-navbarSubMenu">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:;"
                               data-animation="slide-bottom">
                                更多
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item no-menu" href="/html/site-map.html">
                                    <i class="icon wb-list-numbered"></i>
                                    <span>网站地图</span>
                                </a>
                                <a class="dropdown-item no-menu" href="/html/system/menu.html">
                                    <i class="icon wb-wrench"></i>
                                    <span>菜单管理</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
        </ul>
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
            <li class="nav-item dropdown" id="admui-navbarMessage">
                <a class="nav-link msg-btn" data-toggle="dropdown" href="javascript:;" aria-expanded="false"
                   data-animation="scale-up" role="button">
                    <i class="icon wb-bell" aria-hidden="true"></i>
                    <span class="badge badge-danger up msg-num"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                    <li class="dropdown-menu-header" role="presentation">
                        <h5>最新消息</h5>
                        <span class="badge badge-round label-danger"></span>
                    </li>
                    <li class="list-group" role="presentation">
                        <div class="navbar-message-content h-250" data-plugin="mCustomScrollbar">
                            <div id="admui-messageContent"></div>
                        </div>
                        <script type="text/html" id="admui-messageTpl">
                            <% if (msgList.length < 1) { %>
                            <p class="text-center h-200 vertical-align">
                                <small class="vertical-align-middle opacity-four">没有新消息</small>
                            </p>
                            <% } else { %>
                            <% for(var i = 0; i < msgList.length; i++){ %>
                            <% var item = msgList[i]; %>
                            <a class="list-group-item" href="#" data-message-id="<%= item.messageId %>"
                               data-title="<%= item.title %>"
                               data-content="<%= item.content %>" role="menuitem">
                                <div class="media">
                                    <div class="pr-10">
                                        <i class="icon <%= $imports.iconType(item.messageId) %> white icon-circle"
                                           aria-hidden="true"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="media-heading"><%= item.title %></h6>
                                        <time class="media-meta" datetime="<%= item.sendTime %>">
                                            <%= $imports.timeMsg(item.sendTime) %>
                                        </time>
                                    </div>
                                </div>
                            </a>
                            <% } %>
                            <% } %>
                        </script>
                    </li>
                    <div class="dropdown-menu-footer" role="presentation">
                        <a class="dropdown-item" href="/html/system/account.html?tab=message" role="menuitem">
                            <i class="icon fa-navicon"></i>所有消息
                        </a>
                    </div>
                </ul>
            </li>
            <li class="nav-item dropdown" id="admui-navbarUser">
                <a class="nav-link navbar-avatar" data-toggle="dropdown" href="javascript:;" aria-expanded="false"
                   data-animation="scale-up" role="button">
                    <span class="avatar avatar-online">
                        <img src="https://admui.bangbangda.me/public/images/avatar.svg" alt="...">
                        <i></i>
                    </span>
                </a>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="/html/system/account.html?tab=display" role="menuitem">
                        <i class="icon wb-layout" aria-hidden="true"></i>
                        <span>显示设置</span>
                    </a>
                    <a class="dropdown-item" href="/html/system/account.html?tab=password" role="menuitem">
                        <i class="icon wb-pencil" aria-hidden="true"></i>
                        <span>修改密码</span>
                    </a>
                    <a class="dropdown-item" href="/html/system/account.html" role="menuitem">
                        <i class="icon wb-settings" aria-hidden="true"></i>
                        <span>账户信息</span>
                    </a>
                    <div class="dropdown-divider" role="presentation"></div>
                    <a class="dropdown-item" href="/html/login.html" role="menuitem">
                        <i class="icon wb-power"></i>
                        <span>退出</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
