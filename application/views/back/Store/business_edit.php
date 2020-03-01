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
                        商家管理
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Store/index')?>">回首页</a></li>
                        <li><?php echo isset($model->id)&&$model->id > 0?"商家編輯":"商家新增" ?></li>
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
                                    <?php echo isset($model->id)&&$model->id > 0?"商家編輯":"商家新增" ?> <small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" v-model="model.id">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">帳號</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="account" v-model="model.account" type="text" placeholder="帳號">
                                        </div>
                                    </div>
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
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">商家分類</label>
                                        <div class="col-md-3">
                                            <select class="form-control selectpicker" name="cate_id" id="cate_id" v-model="model.cate_id" data-live-search="true">
                                                <option value="">選擇</option>
                                                <template v-for="cate in model.category">
                                                    <option :value="cate.id" >{{cate.name}}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">商家名稱</label>
                                        <div class="col-md-7">
                                            <input class="form-control" type="text" name="name"  id="name" v-model="model.name" placeholder="請輸入商家名稱">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">商家介紹</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" rows="3" name="introduction" v-model="model.introduction"  placeholder="請輸入商家介紹"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">商店LOGO</label>
                                        <div class="col-md-7">
                                            <button class="btn btn-sm btn-default" id="fileon" onclick="document.getElementById('logo1').click();" type="button">瀏覽</button>
                                            <input type="file" multiple="true"  data-input="false" id="logo1" obj_op="media_logo" onchange="select_files(this)" accept="image/jpeg,image/jpg,image/png,image/svg" data-badge="false" style="display:none;">
                                            <span>檔案格式: JPG、PNG  限制大小: 3MB</span>
                                        </div>
                                    </div>

                                    <div class="form-group logoss">
                                        <label class="col-md-2 control-label sr-only">預覽圖片 </label>
                                        <div class="col-md-7">
                                            <div class="sort_img_list">
                                                <template v-for="(logo_img,logo_img_index) in media_logo_list">
                                                    <div class="sort_img">
                                                        <div class="form-group-t">
                                                            <button type="button" class="btn btn-warning" @click="del_logo_img(logo_img_index)">刪除</button>
                                                        </div>
                                                        <input type="hidden" name="logo_img_src_list[]" :value="logo_img.name">
                                                        <div class="form-group">
                                                            <div id="preimg">
                                                                <div class='imgContainer'>
                                                                    <img title='图片' class="src_list" :src="logo_img.src"  onerror=this.onerror=null;this.src="assets/images/no.jpg" alt='图片'/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-2 control-label">店家圖</label>
                                        <div class="col-md-7">
                                            <button class="btn btn-sm btn-default" id="Button1" onclick="document.getElementById('pic1').click();" type="button">瀏覽</button>
                                            <input type="file" multiple="" data-input="false" id="pic1" obj_op="media_pic" onchange="select_files(this)" accept="image/jpeg,image/jpg,image/png,image/svg" data-badge="false" style="display:none;">
                                            <span>檔案格式: JPG、PNG  限制大小: 3MB</span>
                                        </div>
                                    </div>
                                    <div class="form-group picss ">
                                        <label class="col-md-2 control-label sr-only">預覽圖片 </label>
                                        <div class="col-md-7">
                                            <div class="sort_img_list">
                                                <template v-for="(pic_img,pic_img_index) in media_pic_list">
                                                    <div class="sort_img">
                                                        <div class="form-group-t">
                                                            <button type="button" class="btn btn-warning" @click="del_pic_img(pic_img_index)">刪除</button>
                                                        </div>
                                                        <input type="hidden" name="pic_img_src_list[]" :value="pic_img.name">
                                                        <div class="form-group">
                                                            <div id="preimg">
                                                                <div class='imgContainer'>
                                                                    <img title='图片' class="src_list" :src="pic_img.src"  onerror=this.onerror=null;this.src="assets/images/no.jpg" alt='图片'/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">地址</label>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text"  onkeyup="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" name="postal"  id="postal" v-model="model.postal"  value="" placeholder="郵遞區號">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="county"  id="county" v-model="model.county" placeholder="縣市">
                                        </div>
                                        <div class="col-md-2">
                                            <input class="form-control" type="text" name="district"  id="district" v-model="model.district" placeholder="區">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="address" id="address" v-model="model.address" placeholder="地址">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">電話</label>
                                        <div class="col-md-8">
                                            <input class="form-control" type="text" name="phone" id="phone" v-model="model.phone" placeholder="ex:02-29901122">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">營業時間</label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" name="business" rows="3" v-model="model.business" placeholder="請輸入營業時間"></textarea>
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
                                            <button class="btn btn-sm btn-primary" type="button" onclick="SendAjax()">確認</button>
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
    var validator;
    $(function () {
        validator = $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper: "span",
            rules: {
                account: {
                    required: true,
                    minlength: 5,
                    maxlength: 30
                },
                type: {
                    required: true,
                },
                cate_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
                pass: {
                    minlength: 5,
                    maxlength: 30
                },
                pass_again: {
                    minlength: 5,
                    maxlength: 30,
                    equalTo: "#pass"
                }
            },
            messages: {
                account: {
                    required: "請輸入賬號",
                    minlength: "請輸入5-30個字元"
                },
                type: {
                    required: "請選擇商家類別",
                },
                cate_id: {
                    required: "請選擇商家分類",
                },
                name: {
                    required: "請輸入商家名稱",
                },
                pass: {
                    minlength: "請輸入5-30個字元英文或數字"
                },
                pass_again: {
                    minlength: "請輸入5-30個字元英文或數字",
                    equalTo: "兩次密碼輸入不一致"
                }
            }
        });

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

    Vue.http.options.emulateJSON = true;

    var vue_obj = new Vue({
        el: '#main-container',
        data: {
            model: [],
            media_logo_list: [],
            media_pic_list: [],
            files_arr: [],
            is_media_logo_load: true,
            is_media_pic_load: true,
        },
        mounted: function () {
            var json_model = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($model) ? $model : null)))?>'.replace(/\+/g," ")));
            if (json_model) {
                this.model = json_model;
                var this_= this;
                if (json_model.logo && json_model.logo.length > 0) {
                    $.each(json_model.logo, function (index, value) {
                        this_.media_logo_list.push({name: value, src: value});
                    });
                }
                if (json_model.pic && json_model.pic.length > 0) {
                    $.each(json_model.pic, function (index, value) {
                        this_.media_pic_list.push({name: value, src: value});
                    });
                }
            }
        },
        methods: {
            del_logo_img:function (index) {
                this.media_logo_list.splice(index,1);
            },
            del_pic_img:function (index) {
                this.media_pic_list.splice(index,1);
            },
        },
        // 使用一个监听。可以减少很多代码
        watch: {
            media_logo_list: function () {
                this.$nextTick(function () {
                    if(vue_obj.is_media_logo_load)
                    {
                        $(".sort_img_list").sortable({
                            connectWith: ".sort_img",
                            stop: function () {

                            }
                        }).disableSelection();

                        vue_obj.is_media_logo_load = false;
                    }

                });
            },
            media_pic_list: function () {
                this.$nextTick(function () {
                    if(vue_obj.is_media_pic_load)
                    {
                        $(".sort_img_list").sortable({
                            connectWith: ".sort_img",
                            stop: function () {

                            }
                        }).disableSelection();
                        vue_obj.is_media_pic_load = false;
                    }
                });
            }
        }
    });

    function SendAjax() {
        if (!$('#addform').valid()) {
            validator.focusInvalid();
            return false;
        }

        //$("#contents").html(CKEDITOR.instances["contents"].document.getBody().getHtml());
        //获取form的dom对象
        var fm = document.getElementById('addform');
        //将form数据用formData打包

        var fd = new FormData(fm);

        $.each(vue_obj.files_arr, function (index, value) {
            $.each(vue_obj.media_logo_list, function (logo_index, media_logo) {
                if (media_logo.name == value.name) {
                    fd.append('media_logo' + logo_index, vue_obj.files_arr[index]);
                }
            });
            $.each(vue_obj.media_pic_list, function (pic_index, media_pic) {
                if (media_pic.name == value.name) {
                    fd.append('media_pic' + pic_index, vue_obj.files_arr[index]);
                }
            });
        });

        $.ajax({
            type: 'post',
            url: '<?php echo base_url('back/Store/business_edit') ?>',
            data: fd,
            cache: false,
            contentType: false, //必须
            processData: false, //必须
            dataType: 'json',
            success: showResponse,
            error: showError
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
                    vue_obj.files_arr.push(obj.files[i]);
                    if (obj_op == "media_logo") {
                        vue_obj.media_logo_list.push({name: obj.files[i].name, src: src});
                    }
                    if (obj_op == "media_pic") {
                        vue_obj.media_pic_list.push({name: obj.files[i].name, src: src});
                    }
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
        var file = $(obj)
        file.after(file.clone().val(""));
        file.remove();
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