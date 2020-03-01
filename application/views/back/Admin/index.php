<!DOCTYPE html>
<base href="<?php  echo base_url();?>"/>
<!--[if IE 9]>
<html class="ie9 no-focus"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-focus"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="description" content="OneUI - Admin Dashboard Template & UI Framework">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
    <?php $this->load->view('back/partials/_include_head') ?>
</head>
<body>
<!-- Page Container -->
<!--
    Available Classes:

    'sidebar-l'                  Left Sidebar and right Side Overlay
    'sidebar-r'                  Right Sidebar and left Side Overlay
    'sidebar-mini'               Mini hoverable Sidebar (> 991px)
    'sidebar-o'                  Visible Sidebar by default (> 991px)
    'sidebar-o-xs'               Visible Sidebar by default (< 992px)

    'side-overlay-hover'         Hoverable Side Overlay (> 991px)
    'side-overlay-o'             Visible Side Overlay by default (> 991px)

    'side-scroll'                Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (> 991px)

    'header-navbar-fixed'        Enables fixed header
-->
<div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">

    <?php $this->load->view('back/partials/_include_header_aside') ?>

    <!-- Main 中間容器 -->
    <main id="main-container">

        <!-- Page 內問中間默認開始 floating-->
        <div class="content bg-white">
            <!-- 容器 -->
            <div class="block">
<!--                <div class="block-content">-->
<!--                    <div class="">-->
<!--                        <p>總商家數:</p>-->
<!--                        <p>總會員數:</p>-->
<!--                        <p>今日加入會員數:</p>-->
<!--                        <p>本月加入會員數</p>-->
<!--                    </div>-->
<!--                    <hr/>-->
<!--                    <div class="">-->
<!--                        <p>總活動數:</p>-->
<!--                        <p>今日新增活動數:</p>-->
<!--                        <p>本月新增活動數:</p>-->
<!--                    </div>-->
<!--                    <hr/>-->
<!--                    <div class="">-->
<!--                        <p>總折價卷數(虛擬卷):</p>-->
<!--                        <p>市場流通折價卷數:</p>-->
<!--                        <p>今日使用折價卷數:</p>-->
<!--                        <p>本月使用折價卷數:</p>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
            <!-- END 容器 -->
        </div>
        <!-- END Page 內問中間默認開始 -->
    </main>
    <!-- END Main 中間容器 -->

    <?php $this->load->view('back/partials/_include_footer') ?>
</div>
<!-- END Page Container -->
<?php $this->load->view('back/partials/_include_last_js') ?>

<script>
    $(function () {
        // Init page helpers (BS Datepicker + BS Colorpicker + Select2 + Masked Input + Tags Inputs plugins)
        App.initHelpers(['datepicker']);
    });
</script>
</body>
</html>