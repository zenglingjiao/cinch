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
        <!-- Page 中間標題頭部 -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        系統帳號
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首页</a></li>
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/admin_list')?>">管理員列表</a></li>
                        <li><?php echo isset($admin['id'])&&$admin['id']>0?"管理員編輯":"管理員新增" ?></li>
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
                                    <?php echo isset($admin['id'])&&$admin['id']>0?"管理員編輯":"管理員新增" ?> <small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="<?php echo base_url('back/Admin/admin_edit')?>" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" value="<?php echo isset($admin['id'])?$admin['id']:""?>">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">姓名</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="full_name" value="<?php echo isset($admin['full_name'])?$admin['full_name']:""?>" type="text" placeholder="姓名">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">帳號</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="username" type="text" value="<?php echo isset($admin['username'])?$admin['username']:""?>" placeholder="帳號">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Email</label>
                                        <div class="col-md-7">

                                            <?php //if(isset($admin['id'])&&$admin['id']>0){ ?>
                                            <!--    <div class="form-control-static">--><?php //echo isset($admin['email'])?$admin['email']:""?><!--</div>-->
                                            <?php //}else{ ?>
                                            <!--    <input class="form-control" name="email" type="text" placeholder="Email">-->
                                            <?php //} ?>
                                            <input class="form-control" name="email" type="text" value="<?php echo isset($admin['email'])?$admin['email']:""?>" placeholder="Email">
                                        </div>
                                    </div>

                                    <?php if(isset($admin['id'])&&$admin['id']>0){ ?>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">密碼</label>
                                            <div class="col-md-7">
                                                <button class="btn btn-sm btn-primary" type="button" onclick="$('.passedit').val('');$('#password_edit_modal').modal('show');">修改密碼</button>
                                            </div>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">密碼</label>
                                            <div class="col-md-7">
                                                <input class="form-control" name="pass" id="pass" type="password" placeholder="密碼">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">確認密碼</label>
                                            <div class="col-md-7">
                                                <input class="form-control" name="pass_again" type="password" placeholder="確認密碼">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">權限</label>
                                        <div class="col-md-8">
                                            <table class="table table-bordered table-zhiw">
                                                <tr>
                                                    <th>全選</th>
                                                    <th class="text-right">
                                                        <button type="button" class="btn-default btn btn-sm" onclick="selectAll(1)">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm" onclick="selectAll(0)">全不選</button>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>商家分類管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'fl')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'fl')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="f1" data-name="fl"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="f2" data-name="fl"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="f3" data-name="fl"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="f4" data-name="fl"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>商家管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'sj')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'sj')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="sj"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="sj"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="sj"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="sj"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>會員管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'hy')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'hy')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="hy"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="hy"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="hy"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="hy"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>優惠管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'yh')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'yh')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="yh"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="yh"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="yh"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="yh"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>活動管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'hd')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'hd')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="hd"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="hd"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="hd"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="hd"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>折價卷管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'zj')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'zj')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="zj"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="zj"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="zj"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="zj"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>廣告管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'gg')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'gg')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="gg"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="gg"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="gg"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="gg"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>推播管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'tb')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'tb')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="tb"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="tb"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="tb"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="tb"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>系統帳號管理</td>
                                                    <td>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(1,'xt')">全選</button>
                                                        <button type="button" class="btn-default btn btn-sm push-10-r" onclick="selectAll2(0,'xt')">全不選</button>
                                                        <label class="css-input css-checkbox css-checkbox-info push-10-r">
                                                            <input type="checkbox" name="" data-name="xt"><span></span> 瀏覽
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-primary push-10-r">
                                                            <input type="checkbox" name="" data-name="xt"><span></span> 新增
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                            <input type="checkbox" name="" data-name="xt"><span></span> 修改
                                                        </label>
                                                        <label class="css-input css-checkbox css-checkbox-danger push-10-r">
                                                            <input type="checkbox" name="" data-name="xt"><span></span> 刪除
                                                        </label>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>

                                    <?php if(isset($admin['id'])&&$admin['id']>0){ ?>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">建立時間</label>
                                            <div class="col-md-8">
                                                <!--編輯才出現或者加類form-control-static-->
                                                <div class="form-control-static"><?php echo isset($admin['date_created'])?$admin['date_created']:""?></div>
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

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="password_edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">密碼修改</h4>
                </div>
                <div class="modal-body">
                    <form id="password_edit_form" action="<?php echo base_url('back/Admin/password_change_eidt')?>" autocomplete="off" method="post" onsubmit="return false;">
                        <input type="hidden" name="id" value="<?php echo isset($admin['id'])?$admin['id']:""?>">
                        <div class="form-group">
                            <label for="example-nf-password">請輸入新密碼</label>
                            <input class="form-control passedit" type="password" name="password_new" id="password_new" onkeyup="value=value.replace(/[^0-9a-z]/g,'');" placeholder="限小寫英文或數字，6個字元以上">
                        </div>
                        <div class="form-group">
                            <label for="example-nf-password">請再次輸入新密碼</label>
                            <input class="form-control passedit" type="password" name="password_new_again" onkeyup="value=value.replace(/[^0-9a-z]/g,'');" placeholder="限小寫英文或數字，6個字元以上">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                    <button type="button" class="btn btn-primary" onclick="$('#password_edit_form').submit();">確定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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

        $("#password_edit_form").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper:"span",
            rules: {
                password_new: {
                    required: true,
                    minlength: 5,
                    maxlength:30
                },
                password_new_again: {
                    required: true,
                    minlength: 5,
                    maxlength:30,
                    equalTo: "#password_new"
                }
            },
            messages: {
                password_new: {
                    required: "請輸入新密碼",
                    minlength: "請輸入5-30個字元英文或數字"
                },
                password_new_again: {
                    required: "請再次輸入新密碼",
                    minlength: "請輸入5-30個字元英文或數字",
                    equalTo: "兩次密碼輸入不一致"
                }
            }
        });
        var options_password_edit_form = {
            target: '',   // target element(s) to be updated with server response
            dataType: 'JSON',
            beforeSubmit: showRequest_password_form,  // pre-submit callback
            success: showResponse_password_edit_form,  // post-submit callback
            error: showError_password_form
        };

        $('#password_edit_form').ajaxForm(options_password_edit_form);
    });

    function selectAll(selectStatus) {//傳入參數（全選框的選中狀態）
        //根據name屬性獲取到單選框的input，適用each方法循環設置所有單選框的選中狀態
        if (selectStatus) {
            $("input[type='checkbox']").each(function (i, n) {
                n.checked = true;
            });
        } else {
            $("input[type='checkbox']").each(function (i, n) {
                n.checked = false;
            });
        }
    }

    function selectAll2(selectStatus, selectname) {
        if (selectStatus) {
            $("input[data-name='" + selectname + "']").each(function (i, n) {
                n.checked = true;
            });
        } else {
            $("input[data-name='" + selectname + "']").each(function (i, n) {
                n.checked = false;
            });
        }
    }


    function showResponse_password_edit_form(jsonData, statusText, xhr, $form) {
        /*alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
            '\n\nThe output div should have already been updated with the responseText.');*/
        switch (jsonData.Statu) {
            case "ok":
                if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                    //$.alertMsg(data.Msg, "系统提示", function () { funcSuc(data); });
                    sweetAlert("修改成功");
                }
                $('#password_edit_modal').modal('hide');
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

                    });
                }
                break;
        }
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
</script>
</body>
</html>