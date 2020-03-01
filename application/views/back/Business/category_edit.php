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
    <style>
        .sort_img_list {
            display: flex;
            flex-flow: wrap;
            justify-content: space-between;
            border: 1px solid #ece8e8;
            padding: 15px;
        }
        .sort_img {
            flex: 0 1 48%;
        }
        .form-group-t {
            margin-left: 3px;
            margin-bottom: 2px;
        }
        .sort_img button {
            margin-right: 10px;
        }
        .form-horizontal .sort_img .form-group {
            margin-left: 0px;
            margin-right: 0px;
        }
        .imgContainer {
            display: inline-block;
            width: 100%;
            margin-left: 1%;
            border: 1px solid #666666;
            position: relative;
            margin-top: 1%;
            margin-bottom: 1%;
            box-sizing: border-box;
            overflow: hidden;
            height: 250px;
            float: left;
        }
        .imgContainer img {
            width: 100%;
            cursor: pointer;
            height: 100%;
            object-fit: contain;
        }
        .dropup .dropdown-menu, .navbar-fixed-bottom .dropdown .dropdown-menu {
            z-index: 3333;
        }
    </style>
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
        <!-- Page 中間標題頭部 -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        商家分類
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首页</a></li>
                        <li><a class="link-effect" href="<?php echo base_url('back/Business/category_list')?>">商家分類列表</a></li>
                        <li><?php echo isset($model->id)&&$model->id > 0?"商家分類編輯":"商家分類新增" ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- END Page 中間標題頭部 -->

        <!-- Page 內問中間默認開始 floating-->
        <div class="content">
            <div class="">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- 表单 -->
                        <div class="block">
                            <div class="block-header">
                                <ul class="block-options">
                                    <li>
                                        <button type="button"><i class="si si-settings"></i></button>
                                    </li>
                                </ul>
                                <h3 class="block-title">
                                    <?php echo isset($model->id)&&$model->id > 0?"商家分類編輯":"商家分類新增" ?> <small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="<?php echo base_url('back/Business/category_edit')?>" enctype="multipart/form-data" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:""?>">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">商家分類名稱</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="name" value="<?php echo isset($model->name)?$model->name:""?>" type="text" placeholder="商家分類名稱">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-2 control-label">圖標</label>
                                        <div class="col-md-7">
                                            <button class="btn btn-sm btn-default" onclick="document.getElementById('file_pic').click();" type="button">瀏覽</button>
                                            <input type="file" name="file" id="file_pic" obj_op="pic_img" onchange="select_files(this)" accept="image/jpeg,image/jpg,image/png,image/svg" style="display:none;">
                                            <span>檔案格式: JPG、PNG  限制大小: 3MB</span>
                                        </div>
                                    </div>
                                    <div class="form-group picss ">
                                        <label class="col-md-2 control-label sr-only">預覽圖標 </label>
                                        <div class="col-md-7">
                                            <div class="sort_img_list">
                                                <div class="sort_img">
                                                    <div class="form-group-t">
                                                        <button type="button" class="btn btn-warning" onclick="$('#pic_img').html('');$('#pic_img_name').val('');;$('#file_pic').val('');">刪除</button>
                                                    </div>
                                                    <input type="hidden" name="pic" id="pic_img_name" value="<?php echo isset($model->pic)?$model->pic:""?>">
                                                    <div class="form-group">
                                                        <div id="preimg">
                                                            <div class='imgContainer' id="pic_img">
                                                                <img title='图片' class="src_list" src="<?php echo isset($model->pic)?$model->pic:""?>"  onerror=this.onerror=null;this.src="assets/images/no.jpg" alt='图片'/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">排序</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="sort" type="text" value="<?php echo isset($model->sort)?$model->sort:""?>" placeholder="排序">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">狀態</label>
                                        <div class="col-md-8">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" <?php echo isset($model->status)&&$model->status==0?"checked":""?> value="0" name="status"><span></span> 關閉
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" <?php echo isset($model->status)&&$model->status==1?"checked":""?> value="1" name="status"><span></span> 開啟
                                            </label>
                                        </div>
                                    </div>
                                    <?php if(isset($model->id)&&$model->id > 0){ ?>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">建立時間</label>
                                            <div class="col-md-8">
                                                <!--編輯才出現或者加類form-control-static-->
                                                <div class="form-control-static"><?php echo isset($model->created_at)?$model->created_at:""?></div>
                                            </div>
                                        </div>
                                    <?php }?>

                                    <?php echo form_hidden($csrf); ?>
                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-2 text-right">
                                            <button class="btn btn-sm btn-primary" type="submit">確認</button>
                                            <button id="cancel_edit" class="btn btn-sm btn-danger" type="button">取消</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- END 表单 -->
                    </div>
                </div>
            </div>
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
        $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper:"span",
            rules: {
                username: {
                    required: true,
                    minlength: 5,
                    maxlength:30
                },
                email: {
                    required: true,
                    minlength: 5,
                    maxlength:30
                },
                pass: {
                    required: true,
                    minlength: 5,
                    maxlength:30
                },
                pass_again: {
                    required: true,
                    minlength: 5,
                    maxlength:30,
                    equalTo: "#pass"
                }
            },
            messages: {
                username: {
                    required: "請輸入賬號",
                    minlength: "請輸入5-30個字元"
                },
                email: {
                    required: "請輸入Email",
                    minlength: "請輸入5-30個字元"
                },
                pass: {
                    required: "請輸入密碼",
                    minlength: "請輸入5-30個字元英文或數字"
                },
                pass_again: {
                    required: "請再次輸入新密碼",
                    minlength: "請輸入5-30個字元英文或數字",
                    equalTo: "兩次密碼輸入不一致"
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

        $('#addform').ajaxForm(options);
    });

    //建立一个可存取到该file的url
    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }

    function showRequest(formData, jqForm, options) {

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
                        title:jsonData.Msg,
                        text:'等待跳轉',
                        timer:3000,
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
                        //window.location.reload();
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
            //window.location.reload();
        });
    }

    function select_files(obj) {
        var err_alert = false;
        var obj_op = $(obj).attr("obj_op");
        for (i = 0; i < obj.files.length; i++) {
            var src = getObjectURL(obj.files[i])
            if (src) {
                var fileSize = obj.files[i].size / 1024;

                if (fileSize > 3072)//5M
                {
                    err_alert = true;
                } else {
                    //$("#"+obj_op+"").attr("src", src);
                    $("#" + obj_op + "").html('<img title="图片" class="src_list" src="' + src + '" onerror=this.onerror=null;this.src="assets/images/no.jpg" alt="图片"/>');
                    $("#" + obj_op + "_name").val(obj.files[i].name);
                }
            }
        }
        if (err_alert) {
            var jacked = humane.create({
                baseCls: 'humane-jackedup',
                addnCls: 'humane-jackedup-error',
                timeout: 2000
            })
            jacked.log("已過濾文件過大的選擇項（圖片限制3M）");
        }
        // var file = $(obj)
        // file.after(file.clone().val(""));
        // file.remove();
    }
</script>
</body>
</html>