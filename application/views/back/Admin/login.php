<!DOCTYPE html>
<base href="<?php  echo base_url();?>"/>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
    <!-- OneUI CSS framework -->
    <link rel="stylesheet" id="css-main" href="assets/css/oneui.css">
    <link rel="stylesheet" id="Link1" href="assets/css/login.css?1">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link href="assets/plugins/jquery-validation/jquery.validate.css" rel="stylesheet">
    <link href="assets/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">
    <link href="assets/css/ajaxSendLoad.css" rel="stylesheet">
</head>


<body>



<div class="login-logo">
    <img src="assets/images/logo.png" width="147" height="33">
</div>

<div class="widget">
    <div class="login-content">
        <div class="widget-content" style="padding-bottom:0;">
            <form id="login" action="<?php echo base_url('back/Admin/login')?>" method="post" autocomplete="off">
                <h3 class="form-title">Cinch</h3>

                <fieldset>
                    <div class="form-group no-margin">
                        <label for="email">帳號/Email</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                  <i class="si si-user"></i>
                                </span>
                            <input type="text" name="email" class="form-control" placeholder="帳號">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>

                        <div class="input-group input-group-lg">
                                <span class="input-group-addon">
                                  <i class="si si-lock"></i>
                                </span>
                            <input type="password" name="password" class="form-control" placeholder="密碼">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="css-input css-checkbox css-checkbox-warning">
                            <input type="checkbox" value="1"  id="Checkbox2" name="isAlways"><span></span> 保持登入（3天）
                        </label>
                    </div>
                </fieldset>
                <div class="form-actions">
                    <?php echo form_hidden($csrf); ?>
                    <button class="btn btn-lg btn-block btn-warning" type="submit">登入</button>
                    <!-- <div class="forgot"><a href="#" class="forgot">Forgot Username or Password?</a></div>-->
                </div>

            </form>


        </div>
    </div>
</div>
<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>

<div class="demo_changer" style="right: -145px;">
    <div class="demo-icon"></div>
    <div class="form_holder">
        <div class="predefined_styles">
            <a class="styleswitch" rel="a" href=""><img alt="" src="assets/images/a.jpg"></a>
            <a class="styleswitch" rel="b" href=""><img alt="" src="assets/images/b.jpg"></a>
            <a class="styleswitch" rel="c" href=""><img alt="" src="assets/images/c.jpg"></a>
            <a class="styleswitch" rel="d" href=""><img alt="" src="assets/images/d.jpg"></a>
            <a class="styleswitch" rel="e" href=""><img alt="" src="assets/images/e.jpg"></a>
            <a class="styleswitch" rel="f" href=""><img alt="" src="assets/images/f.jpg"></a>
            <a class="styleswitch" rel="g" href=""><img alt="" src="assets/images/g.jpg"></a>
            <a class="styleswitch" rel="h" href=""><img alt="" src="assets/images/h.jpg"></a>
            <a class="styleswitch" rel="i" href=""><img alt="" src="assets/images/i.jpg"></a>
            <a class="styleswitch" rel="j" href=""><img alt="" src="assets/images/j.jpg"></a>
        </div>

    </div>
</div>


<!--switcher html end-->
<script src="assets/plugins/switcher/switcher.js"></script>
<script src="assets/plugins/switcher/moderziner.custom.js"></script>
<link href="assets/plugins/switcher/switcher.css" rel="stylesheet">
<link href="assets/plugins/switcher/switcher-defult.css" rel="stylesheet">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/a.css" title="a" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/b.css" title="b" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/c.css" title="c" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/d.css" title="d" media="all">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/e.css" title="e" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/f.css" title="f" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/g.css" title="g" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/h.css" title="h" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/i.css" title="i" media="all" disabled="">
<link rel="alternate stylesheet" type="text/css" href="assets/plugins/switcher/j.css" title="j" media="all" disabled="">

<script src="assets/plugins/jquery.form/jquery.form.min.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js?1"></script>
<script src="assets/plugins/jquery-validation/localization/messages_zh_TW.min.js"></script>
<script src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>
<script src="assets/js/ajaxSendLoad.js"></script>

<script>
    $(function () {
        $("#login").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper:"span",
            rules: {
                email: {
                    required: true,
                    minlength: 5,
                    maxlength:30
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength:30
                }
            },
            messages: {
                email: {
                    required: "請輸入賬號",
                    minlength: "請輸入5-30個字元"
                },
                password: {
                    required: "請輸入密碼",
                    minlength: "請輸入5-30個字元英文或數字"
                }
            },errorPlacement: function (error, element) { //指定错误信息位置
                if (element.is(':input')) { //如果是radio或checkbox
                    var eid = element.attr('name'); //获取元素的name属性
                    error.insertAfter(element.parent()); //将错误信息添加当前元素的父结点后面
                } else {
                    error.insertAfter(element);
                }
            }
        });
        var options = {
            target: '',   // target element(s) to be updated with server response
            dataType: 'JSON',
            beforeSubmit: showRequest,  // pre-submit callback
            success: showResponse,  // post-submit callback
            error: showError
        };

        $('#login').ajaxForm(options);

    });

    function showRequest(formData, jqForm, options) {
        if(!$('#login').valid())
        {
            return false;
        }
    }

    // post-submit callback
    function showResponse(jsonData, statusText, xhr, $form) {
        /*alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
            '\n\nThe output div should have already been updated with the responseText.');*/
        switch (jsonData.Statu) {
            case "ok":
                if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                    //$.alertMsg(data.Msg, "系统提示", function () { funcSuc(data); });
                    sweetAlert({
                        title:'登入成功',
                        text:'等待跳轉',
                        timer:2000,
                        showConfirmButton:false
                    });
                    if (jsonData.BackUrl && $.trim(jsonData.BackUrl) != "") {
                        if (window.top) { window.top.location = jsonData.BackUrl; } else {
                            window.location = jsonData.BackUrl;
                        }
                    } else {

                    }
                }
                break;
            case "err":
                if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                    //$.alertMsg(data.Msg, "系統提示", function () { funcErr(data); });
                    sweetAlert({
                        title: jsonData.Msg,
                        text: null,
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#33A0E8",
                        confirmButtonText: "確定",
                        cancelButtonText: "取消",
                        closeOnConfirm: true,
                        closeOnCancel: false
                    }, function (isConfirm) {
                        window.location.reload();
                        // if (jsonData.BackUrl && $.trim(jsonData.BackUrl) != "") {
                        //     if (window.top) { window.top.location = jsonData.BackUrl; } else {
                        //         window.location = jsonData.BackUrl;
                        //     }
                        // } else {
                        //
                        // }
                    });


                }
                break;
        }
    }

    function showError() {
        sweetAlert({
            title: "系統忙碌中，請您稍後重新嘗試。",
            text: null,
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#33A0E8",
            confirmButtonText: "確定",
            cancelButtonText: "取消",
            closeOnConfirm: true,
            closeOnCancel: false
        }, function (isConfirm) {
            window.location.reload();
        });
    }
</script>>
</body>

</html>
