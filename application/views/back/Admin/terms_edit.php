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
    <script src="assets/ckeditor/ckeditor.js"></script>
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
                        優惠
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首页</a></li>
                        <li><?php echo isset($model->id)&&$model->id > 0?"使用條款編輯":"使用條款編輯" ?></li>
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
                                    <?php echo isset($model->id)&&$model->id > 0?"使用條款編輯":"使用條款編輯" ?> <small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="<?php echo base_url('back/Admin/terms_edit')?>" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:""?>">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">條款內容</label>
                                        <div class="col-md-8">
<!--                                            <textarea id="editor" name="content" autofocus placeholder="條款內容"></textarea>-->
                                            <textarea id="content" name="content" autofocus placeholder="條款內容"><?php echo isset($model->content)?$model->content:""?></textarea>
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
        //var content_editor = new Simditor({
        //    textarea: $('#editor'),
        //    placeholder: '請輸入服務條款內容', // 编辑器默认值（默认为’’）
        //    toolbar: [
        //        'title',
        //        'bold',
        //        'italic',
        //        'underline',
        //        'strikethrough',
        //        'fontScale',
        //        'color',
        //        'ol'   ,         // # ordered list
        //        'ul'   ,         // # unordered list
        //        'blockquote',
        //        'code'     ,      //# code block
        //        'table',
        //        'link',
        //        'image',
        //        'hr'        ,     //# horizontal ruler
        //        'indent',
        //        'outdent',
        //        'alignment'
        //    ],
        //    toolbarFloat: true,
        //    toolbarFloatOffset: 0,
        //    tabIndent: true,
        //    upload: {
        //        url: '<?php //echo base_url('back/Admin/simditor_upload')?>//',
        //        // params: null, //参数
        //        fileKey: 'upload_file', //
        //        connectionCount: 3,//同时上传数量
        //        leaveConfirm: 'Uploading is in progress, are you sure to leave this page?' //如果在上传文件时离开页面，将显示消息;
        //    }
        //    //optional options
        //});
        //content_editor.setValue('<?php //echo isset($model->content)?$model->content:""?>//');

        ckeditor1 = CKEDITOR.replace('content', {
            language: 'zh-tw',
            height: 180,
            toolbarStartupExpanded:false,
            skin:'moono-lisa',
            toolbarGroups: [
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                {name: 'forms', groups: ['forms']},
                '/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                {name: 'links', groups: ['links']},
                {name: 'insert', groups: ['insert']},
                '/',
                {name: 'styles', groups: ['styles']},
                {name: 'colors', groups: ['colors']},
                {name: 'tools', groups: ['tools']},
                {name: 'others', groups: ['others']},
                {name: 'about', groups: ['about']}
            ]
        });
        ckeditor1.on('change', function (event) {
            $("#content").val(this.document.getBody().getHtml());
        });
        ckeditor1.on('blur', function (event) {

        });

        $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper:"span",
            rules: {
                content: {
                    required: true
                }
            },
            messages: {
                content: {
                    required: "請輸入條款內容"
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