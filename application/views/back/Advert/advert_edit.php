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
                        廣告管理
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首页</a></li>
                        <li><a class="link-effect" href="<?php echo base_url('back/Advert/advert_list')?>">廣告列表</a></li>
                        <li><?php echo isset($model->id)&&$model->id > 0?"廣告編輯":"廣告新增" ?></li>
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
                                    <?php echo isset($model->id)&&$model->id > 0?"廣告編輯":"廣告新增" ?> <small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" v-model="model.id">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">廣告名稱</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="name" v-model="model.name" type="text" placeholder="廣告名稱">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-2 control-label">活動圖片</label>
                                        <div class="col-md-7">
                                            <button class="btn btn-sm btn-default" onclick="document.getElementById('pic1').click();" type="button">瀏覽</button>
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
                                        <label class="col-md-2 control-label">廣告類型</label>
                                        <div class="col-md-8">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="0" v-model="model.type" name="type"><span></span> 內部商家
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="1" v-model="model.type" name="type"><span></span> 內部活動
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="2" v-model="model.type" name="type"><span></span> 外部連結
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="model.type==0">
                                        <label class="col-md-2 control-label">商家</label>
                                        <div class="col-md-7">
                                            <select class="selectpicker" name="store" data-live-search="true">
                                                <option value="">請選擇商家</option>
                                                <option v-for="store in model.store_list" :selected="store.id==model.store_id" :value="store.id">{{store.store_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="model.type==1">
                                        <label class="col-md-2 control-label">活動</label>
                                        <div class="col-md-7">
                                            <select class="selectpicker" name="activitie" data-live-search="true">
                                                <option value="">請選擇活動</option>
                                                <option v-for="activitie in model.activitie_list" :selected="activitie.id==model.activitie_id" :value="activitie.id">{{activitie.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="model.type==2">
                                        <label class="col-md-2 control-label">連結</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="link" v-model="model.link" type="text" placeholder="連結">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">排序</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="sort" oninput="value=value.replace(/[^\d]/g,'')" v-model="model.sort" type="text" placeholder="排序">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">上下架時間</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="up_date" id="up_date" type="text" placeholder="上下架時間">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-md-2 control-label">狀態</label>
                                        <div class="col-md-8">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="0" v-model="model.status" name="status"><span></span> 關閉
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="1" v-model="model.status" name="status"><span></span> 開啟
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
        calenders("#up_date", true, false);
        validator = $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper: "span",
            rules: {
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 200
                },
                store_list:{
                    required: true,
                },
                activitie_list:{
                    required: true,
                },
                link:{
                    required: true,
                }
            },
            messages: {
                account: {
                    required: "請輸入廣告名稱",
                    minlength: "請輸入2-200個字元"
                },
                store_list:{
                    required: "請選擇商家",
                },
                activitie_list:{
                    required: "請選擇活動",
                },
                link:{
                    required: "請輸入連接",
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
            media_pic_list: [],
            files_arr: [],
            is_media_pic_load: true,
        },
        mounted: function () {
            var json_model = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($model) ? $model : null)))?>'.replace(/\+/g," ")));
            if (json_model) {
                this.model = json_model;
                var this_= this;
                if (json_model.banner && json_model.banner.length > 0) {
                    $.each(json_model.banner, function (index, value) {
                        this_.media_pic_list.push({name: value, src: value});
                    });
                }
                $("#up_date").val(json_model.up_date);
            }
        },
        methods: {
            del_pic_img:function (index) {
                this.media_pic_list.splice(index,1);
            },
        },
        // 使用一个监听。可以减少很多代码
        watch: {
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
            $.each(vue_obj.media_pic_list, function (pic_index, media_pic) {
                if (media_pic.name == value.name) {
                    fd.append('media_pic' + pic_index, vue_obj.files_arr[index]);
                }
            });
        });

        $.ajax({
            type: 'post',
            url: '<?php echo base_url('back/Advert/advert_edit') ?>',
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