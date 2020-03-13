左侧菜单 -->
<nav id="sidebar">
    <!-- 边栏滚动容器 -->
    <div id="sidebar-scroll">
        <!-- 边栏内容 -->
        <!-- 添加 .sidebar-mini 到页面容器将在sidebar处于mini模式时隐藏它 -->
        <div class="sidebar-content ">
            <!-- Side Header -->
            <div class="side-header side-content bg-white-op">
                <!-- 单击切换颜色按钮 -->
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close"> <i class="fa fa-times"></i>
                </button>
                <!-- 单击切换颜色按钮 -->
                <div class="btn-group pull-right">
                    <button class="btn btn-link text-gray dropdown-toggle" data-toggle="dropdown" type="button"> <i class="si si-drop"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right font-s13 sidebar-mini-hide">
                        <li>
                            <a data-toggle="theme" data-theme="default" tabindex="-1" href="javascript:void(0)"> <i class="fa fa-circle text-default pull-right"></i>  <span class="font-w600">Default</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="assets/css/themes/amethyst.min.css" tabindex="-1" href="javascript:void(0)"> <i class="fa fa-circle text-amethyst pull-right"></i>  <span class="font-w600">Amethyst</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="assets/css/themes/city.min.css" tabindex="-1" href="javascript:void(0)"> <i class="fa fa-circle text-city pull-right"></i>  <span class="font-w600">City</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="assets/css/themes/flat.min.css" tabindex="-1" href="javascript:void(0)"> <i class="fa fa-circle text-flat pull-right"></i>  <span class="font-w600">Flat</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="assets/css/themes/modern.min.css" tabindex="-1" href="javascript:void(0)"> <i class="fa fa-circle text-modern pull-right"></i>  <span class="font-w600">Modern</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="theme" data-theme="assets/css/themes/smooth.min.css" tabindex="-1" href="javascript:void(0)"> <i class="fa fa-circle text-smooth pull-right"></i>  <span class="font-w600">Smooth</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <a class="h5 text-white" href="<?php echo base_url('back/Admin/index')?>"> <i class="fa fa-cart-plus text-primary"></i>  <span class="h4 font-w600 sidebar-mini-hide">Cinch</span>
                </a>
            </div>
            <!-- END Side Header -->
            <!-- Side Content -->
            <div class="side-content">
                <ul class="nav-main">
                    <!-- 选中状态在a标签里面添加.active -->
                    <li>
                        <a class="<?= isset($active_index)?$active_index:""?>" href="<?php echo base_url('back/Admin/index')?>"><i class="si si-home"></i><span class="sidebar-mini-hide">首頁 </span></a>
                    </li>
                    <li class="<?= isset($open_admin)?$open_admin:""?>">
                        <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:void(0);"><i class="si si-user"></i><span class="sidebar-mini-hide">管理員</span></a>
                        <ul>
                            <li>
                                <a class="<?= isset($active_admin)?$active_admin:""?>" href="<?php echo base_url('back/Admin/admin_list')?>">管理員列表</a>
                            </li>
                        </ul>
                    </li>
                   <!--  <li>
                        <a class="<?= isset($active_member) ? $active_member : "" ?>" href="<?php echo base_url('back/Members/member_list') ?>"><i class="si si-users"></i><span class="sidebar-mini-hide">會員管理</span></a>

                    </li> -->
                    <li class="<?= isset($open_home)?$open_home:""?>">
                        <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:void(0);"><i class="si si-user"></i><span class="sidebar-mini-hide">主頁</span></a>
                        <ul>
                            <li>
                                <a class="<?= isset($active_master_image)?$active_master_image:""?>" href="<?php echo base_url('back/Master_image/master_image_list')?>">主頁主圖管理</a>
                            </li>
                             <li>
                                <a class="<?= isset($active_propaganda_film)?$active_propaganda_film:""?>" href="<?php echo base_url('back/Propaganda_film/propaganda_film_list')?>">宣傳影片管理</a>
                            </li>
                             <li>
                                <a class="<?= isset($active_proposition)?$active_proposition:""?>" href="<?php echo base_url('back/Proposition/proposition_list')?>">纖奇主張管理</a>
                            </li>
                             <li>
                                <a class="<?= isset($active_major_product)?$active_major_product:""?>" href="<?php echo base_url('back/Major_product/major_product_list')?>">主力產品管理</a>
                            </li>
                             <li>
                                <a class="<?= isset($active_products_for)?$active_products_for:""?>" href="<?php echo base_url('back/Products_for/products_for_edit')?>">產品索取管理</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= isset($open_about)?$open_about:""?>">
                        <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:void(0);"><i class="si si-user"></i><span class="sidebar-mini-hide">認識我們</span></a>
                        <ul>
                            <li>
                                <a class="<?= isset($active_about)?$active_about:""?>" href="<?php echo base_url('back/About/about_list')?>">認識我們Banner編輯</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= isset($open_pledge)?$open_pledge:""?>">
                        <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:void(0);"><i class="si si-user"></i><span class="sidebar-mini-hide">纖奇保證</span></a>
                        <ul>
                            <li>
                                <a class="<?= isset($active_pledge_image)?$active_pledge_image:""?>" href="<?php echo base_url('back/Pledge_image/pledge_image_list')?>">纖奇保證主圖管理</a>
                            </li>
                             <li>
                                <a class="<?= isset($active_proposita)?$active_proposita:""?>" href="<?php echo base_url('back/Proposita/proposita_list')?>">見證者管理</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?= isset($open_cinch_product)?$open_cinch_product:""?>">
                        <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:void(0);"><i class="si si-user"></i><span class="sidebar-mini-hide">纖奇產品</span></a>
                        <ul>
                            <li>
                                <a class="<?= isset($active_cinch_product)?$active_cinch_product:""?>" href="<?php echo base_url('back/Cinch_product/cinch_product_list')?>">纖奇產品管理</a>
                            </li>
                             <li>
                                <a class="<?= isset($active_cinch_product_image)?$active_cinch_product_image:""?>" href="<?php echo base_url('back/Cinch_product_image/cinch_product_image_list')?>">纖奇產品主圖管理</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="<?= isset($active_client_claim) ? $active_client_claim : "" ?>" href="<?php echo base_url('back/Client_claim/client_claim_list') ?>"><i class="si si-users"></i><span class="sidebar-mini-hide">客戶索取管理</span></a>
                    </li>
                    <li class="<?= isset($open_challenge)?$open_challenge:""?>">
                        <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:void(0);"><i class="si si-user"></i><span class="sidebar-mini-hide">挑戰賽</span></a>
                        <ul>
                            <li>
                                <a class="<?= isset($active_picture_button)?$active_picture_button:""?>" href="<?php echo base_url('back/Picture_button/picture_button_list')?>">挑戰賽主圖與按鈕管理</a>
                            </li>
                             <li>
                                <a class="<?= isset($active_news)?$active_news:""?>" href="<?php echo base_url('back/News/news_list')?>">最新消息管理</a>
                            </li>
                            <li>
                                <a class="<?= isset($active_activities_details)?$active_activities_details:""?>" href="<?php echo base_url('back/Activities_details/activities_details_list')?>">活動詳情管理</a>
                            </li>
                            <li>
                                <a class="<?= isset($active_hot_film)?$active_hot_film:""?>" href="<?php echo base_url('back/Hot_film/hot_film_list')?>">熱門影音管理</a>
                            </li>
                            <li>
                                <a class="<?= isset($active_prediction_win_image)?$active_prediction_win_image:""?>" href="<?php echo base_url('back/Prediction_win_image/prediction_win_image_list')?>">預測贏家圖片管理</a>
                            </li>
                            <li>
                                <a class="<?= isset($active_roulette)?$active_roulette:""?>" href="<?php echo base_url('back/Roulette/roulette_list')?>">轉盤管理</a>
                            </li>
                            <li>
                                <a class="<?= isset($active_apply)?$active_apply:""?>" href="<?php echo base_url('back/Apply/apply_list')?>">報名管理</a>
                            </li>
                            <li>
                                <a class="<?= isset($active_winning)?$active_winning:""?>" href="<?php echo base_url('back/Winning/winning_list')?>">中獎管理</a>
                            </li>
                            <li>
                                <a class="<?= isset($active_vote)?$active_vote:""?>" href="<?php echo base_url('back/Vote/vote_list')?>">投票管理</a>
                            </li>
                        </ul>
                    </li>
                    <!-- 
                    <li>
                        <a class="<?= isset($active_broadcast) ? $active_broadcast : "" ?>" href="<?php echo base_url('back/Push_broadcast/broadcast_list') ?>"><i class="si si-users"></i><span class="sidebar-mini-hide">推播管理</span></a>

                    </li>
                    <li>
                        <a class="<?= isset($active_activities) ? $active_activities : "" ?>" href="<?php echo base_url('back/Exchange_activities/activities_list') ?>"><i class="si si-users"></i><span class="sidebar-mini-hide">兌換活動管理</span></a>
                    </li>
							-->
                </ul>
            </div>
            <!-- END Side Content -->
        </div>
        <!-- 边栏内容 -->
    </div>
    <!-- END 边栏滚动容器 -->
</nav>
<!-- END 左侧菜单结束 -->
<!-- 头部菜单 -->
<header id="header-navbar" class="content-mini content-mini-full">
    <!-- 我是顶部右边按钮点击拉下容器 -->
    <ul class="nav-header pull-right">
        <li>
            <div class="btn-group">
                <button class="btn btn-default btn-txt dropdown-toggle" data-toggle="dropdown" type="button">
                    <!--                    <img src="assets/img/avatars/avatar10.jpg" alt="Avatar"><span class="caret"></span>-->
                    <?php echo $this->session->userdata('username')?>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <!--                    <li class="dropdown-header">Profile</li>-->
                    <!--                    <li>-->
                    <!--                        <a tabindex="-1" href="base_pages_inbox.html"> <i class="si si-envelope-open pull-right"></i>-->
                    <!--                            <span class="badge badge-primary pull-right">3</span>Inbox</a>-->
                    <!--                    </li>-->
                    <!--                    <li>-->
                    <!--                        <a tabindex="-1" href="base_pages_profile.html"> <i class="si si-user pull-right"></i>-->
                    <!--                            <span class="badge badge-success pull-right">1</span>Profile</a>-->
                    <!--                    </li>-->
                    <!--                    <li>-->
                    <!--                        <a tabindex="-1" href="javascript:void(0)"> <i class="si si-settings pull-right"></i>Settings</a>-->
                    <!--                    </li>-->
                    <!--                    <li class="divider"></li>-->
                    <li class="dropdown-header">管理員操作</li>
                    <li>
                        <a tabindex="-1" href="javascript:void(0);" onclick="$('.passedit').val('');$('#password_modal').modal('show');"> <i class="si si-lock pull-right"></i>修改密碼</a>
                    </li>
                    <li>
                        <a tabindex="-1" href="<?php echo base_url('back/Admin/logout')?>"> <i class="si si-logout pull-right"></i>安全退出</a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
    <!-- END 我是顶部右边按钮点击拉下容器 -->
    <!-- 我是顶部左边按钮点击拉下容器分移动端和PC端 -->

    <ul class="nav-header pull-left">

        <li class="hidden-md hidden-lg">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_toggle" type="button"> <i class="fa fa-navicon"></i>
            </button>
        </li>
        <li class="hidden-xs hidden-sm">
            <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
            <button class="btn btn-default" data-toggle="layout" data-action="sidebar_mini_toggle" type="button"> <i class="fa fa-ellipsis-v"></i>
            </button>
        </li>
        <?php if(FALSE){?>
            <li class="visible-xs">
                <!-- Toggle class helper (for .js-header-search below), functionality initialized in App() -> uiToggleClass() -->
                <button class="btn btn-default" data-toggle="class-toggle" data-target=".js-header-search" data-class="header-search-xs-visible" type="button"> <i class="fa fa-search"></i>
                </button>
            </li>
            <li class="js-header-search header-search">
                <form class="form-horizontal" action="base_pages_search.html" method="post">
                    <div class="form-material form-material-primary input-group remove-margin-t remove-margin-b">
                        <input class="form-control" type="text" id="base-material-text" name="base-material-text" placeholder="Search.."> <span class="input-group-addon"><i class="si si-magnifier"></i></span>
                    </div>
                </form>
            </li>
        <?php }?>
    </ul>

    <!-- END 我是顶部左边按钮点击拉下容器分移动端和PC端 -->
</header>
<!-- END 头部菜单结束
