<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>

    <!-- OneUI CSS framework -->
    <link rel="stylesheet" id="css-main" href="/assets/css/oneui.css">
    <link rel="stylesheet" id="css-theme-cus" href="/assets/css/themes/cus.css">
<style type="text/css">
    @-webkit-keyframes flipInX{0%{-webkit-transform:perspective(400px) rotate3d(1,0,0,90deg);transform:perspective(400px) rotate3d(1,0,0,90deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in;opacity:0}40%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-20deg);transform:perspective(400px) rotate3d(1,0,0,-20deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in}60%{-webkit-transform:perspective(400px) rotate3d(1,0,0,10deg);transform:perspective(400px) rotate3d(1,0,0,10deg);opacity:1}80%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-5deg);transform:perspective(400px) rotate3d(1,0,0,-5deg)}100%{-webkit-transform:perspective(400px);transform:perspective(400px)}}@keyframes flipInX{0%{-webkit-transform:perspective(400px) rotate3d(1,0,0,90deg);transform:perspective(400px) rotate3d(1,0,0,90deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in;opacity:0}40%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-20deg);transform:perspective(400px) rotate3d(1,0,0,-20deg);-webkit-transition-timing-function:ease-in;transition-timing-function:ease-in}60%{-webkit-transform:perspective(400px) rotate3d(1,0,0,10deg);transform:perspective(400px) rotate3d(1,0,0,10deg);opacity:1}80%{-webkit-transform:perspective(400px) rotate3d(1,0,0,-5deg);transform:perspective(400px) rotate3d(1,0,0,-5deg)}100%{-webkit-transform:perspective(400px);transform:perspective(400px)}}@-webkit-keyframes fadeInUp{0%{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}100%{opacity:1;-webkit-transform:none;transform:none}}@keyframes fadeInUp{0%{opacity:0;-webkit-transform:translate3d(0,100%,0);transform:translate3d(0,100%,0)}100%{opacity:1;-webkit-transform:none;transform:none}}.fadeInUp{-webkit-animation-name:fadeInUp;animation-name:fadeInUp}h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{margin:0;font-family:"Source Sans Pro","Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;font-weight:600;line-height:1.2;color:inherit}.flipInX{-webkit-backface-visibility:visible!important;backface-visibility:visible!important;-webkit-animation-name:flipInX;animation-name:flipInX}.animated{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}.text-city{color:#ff6b6b}.font-s128{font-size:128px!important}.font-w300{font-weight:normal}.push-50{margin-bottom:50px!important;font-family:"Source Sans Pro","Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif}.box{width:50%;margin:0 auto;text-align:center;position:relative;top:150px;color:#646464}
</style>
</head>

<body>

<div class="box">
    <h1 class="font-s128 font-w300 text-city animated flipInX">404</h1>
    <h2 class="h3 font-w300 push-50 animated fadeInUp"><?php echo $message; ?></h2>
</div>

<!-- Error Footer -->
<div class="content pulldown text-muted text-center"><a class="link-effect" href="/back/Admin/index">回首頁</a>
</div>
<!-- END Error Footer -->
</body>

</html>