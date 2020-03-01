<!DOCTYPE html>
<base href="<?php  echo base_url();?>"/>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title><?= isset($title)?$title:"使用條款"?></title>
    <style>
        body{
            margin:0px;
            background:#f7f7f7;
        }
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        .banner {
            height:210px;
            background:#e8e8e8;
        }
        .banner img{
            height:100%;
            width:100%;
            object-fit: cover;
        }

        .black {
            padding:0;
            margin:0 auto;
            font-size: 18px;
            color: #000;
        }
        .text-center {
            text-align: center;
        }
        .xq_body {
            background:#fff;
        }
        .title_conter {
            padding-left:30px;
            padding-right:30px;
            padding-top:30px;
            padding-bottom:15px;
        }
        .body_conter {
            padding-left:30px;
            padding-right:30px;
            padding-top:30px;
            padding-bottom:30px;
            background:#f7f7f7;
            border-top-left-radius:20px;
            border-top-right-radius:20px;
        }
        .title_conter {
        }
        .title_conter .tt{
            margin:15px 0;
        }
        .title_conter .ms{
            margin:15px 0;
        }
        .navbar-fixed-bottom{
            position: fixed;
            right: 0;
            left: 0;
            z-index: 1030;
            bottom: 0;
            margin-bottom: 0;
            border-width: 1px 0 0;
        }
        .foot_box {
            display:flex;
            align-items: center;
            justify-items: center;
            padding:15px;
            background:#fff;
        }
        .foot_box .item{
            display:flex;
            align-items: center;
            justify-items: center;
            flex:1;
            margin:0 15px;
            text-decoration:none;
        }
        .foot_box .item.frist{
            flex:0 0 auto;
            color:#fe1d00;
        }
        .foot_box .item.frist img{
            margin-right:10px;
        }
        .btn_lq{
            background:#f11c18;
            border-radius:20px;
            color:#fff;
            padding:6px;
            width:100%;
            text-align:center;
            display:inline-block;
            text-decoration:none;
        }

    </style>
</head>

<body>
<div class="black">
    <?php echo isset($html)?$html:"" ?>
</div>
</body>
</html>