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
    <main id="main-container" v-cloak>
        <!-- Page 中間標題頭部 -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        <?= isset($title)?$title:"編輯頁"?>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首页</a></li>
                        <li><a class="link-effect" href="<?= isset($list)?$list:"/"?>"><?= isset($list_title)?$list_title:"列表"?></a></li>
                        <li><?php echo isset($model->id)&&$model->id > 0?isset($title)?$title:"編輯頁":isset($title)?$title:"新增頁" ?></li>
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
                                        <button type="button" class="text-default" id="cancel_edit"><i class="fa fa-2x fa-times-circle"></i></button>
                                    </li>
                                </ul>
                                <h3 class="block-title">
                                    <?php echo isset($model->id)&&$model->id > 0?isset($title)?$title:"編輯頁":isset($title)?$title:"新增頁" ?><small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="<?php echo base_url('back/Members/member_edit')?>" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" value="<?php echo isset($model['id'])?$model['id']:""?>">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">贈品名</label>
                                        <div class="col-md-7">
                                            <input @input="textarea_num()" maxlength="8" type="text" class="form-control" v-model="model.name" name="name" />
                                            <div class="text-right">{{name}}/8</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">機率</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.odds" name="odds" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">庫存</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.stock" name="stock" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">狀態</label>
                                        <div class="col-md-7">
                                            <label class="css-input switch switch-success">
                                                <input type="checkbox" v-model="model.state"><span></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group" v-if="model.id&&model.id>0">
                                        <label class="col-md-2 control-label">建立時間</label>
                                        <div class="col-md-8">
                                            <!--編輯才出現或者加類form-control-static-->
                                            <div class="form-control-static">{{model.created_at}}</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-2 text-right">
                                            <button class="btn btn-lg btn-inverse" type="button" @click="model_edit">確認</button>
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
        calenders("#activities_time", true, true);

    });
    $(function () {



        $.validator.addMethod("check_code",function(value,element,params){
            var check = /(^[A-Z]{3}).*/;
            return this.optional(element)||(check.test(value));
        },"請輸入三位大寫英文字母！");

        validator = $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper: "div",
            rules: {
                title: {
                    required: true
                },
                content: {
                    required: true
                },
                integral: {
                    required: true
                },
                activities_time: {
                    required: true
                },
                has_upimg: {
                    required: true
                },
            },
            messages: {
                title: {
                    required: "請輸入標題",
                },
                content: {
                    required: "請輸入內容",
                },
                integral: {
                    required: "請輸入積分",
                },
                activities_time: {
                    required: "請選擇時間",
                },
                has_upimg: {
                    required: "請選擇圖片",
                },

            },
            errorPlacement: function (error, element) { //指定错误信息位置
                var eid = element.attr('name'); //获取元素的name属性
                if(eid == "has_upimg"){

                    console.log(eid);
                    error.appendTo(element.parent().parent()); //将错误信息添加当前元素的父结点后面
                }
                else {
                    error.insertAfter(element);
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
            model: {},
            update_file: {},
            name:8,
            api_model_edit:"<?php echo isset($edit)?$edit:""?>",
        },
        mounted: function () {
            var json_model = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($model) ? $model : null)))?>'.replace(/\+/g," ")));
            if (json_model) {
                this.model = json_model;
                if(this.model.state=="1"){
                    this.model.state=true;
                }else{
                    this.model.state=false;
                }
                if(this.model.imgs){
                    this.update_file = {name: '設備圖', file: null, src: this.model.imgs, type: 'img'};
                }

            }
			this.textarea_num();

        },
        methods: {
        	textarea_num:function () {
				var textarea_num=this.model.name.length;
				this.name = 8-textarea_num;
			},
            tirgger_file: function (event) {
                var file = event.target.files; // (利用console.log输出看file文件对象)
                if (file) {
                    var fileSize = file[0].size / 1024;
                    var fileName = file[0].name;
                    var fileType = file[0].type;
                    if (fileSize > (10*1024))//10M
                    {
                        var jacked = humane.create({
                            baseCls: 'humane-jackedup',
                            addnCls: 'humane-jackedup-error',
                            timeout: 2000
                        })
                        jacked.log("已過濾超過10M的文件");
                    } else {
                        this.update_file = {
                            name: fileName,
                            file: file,
                            src: getObjectURL(file[0]),
                            type: "img"
                        };
                        this.model.imgs="1";
                        $("#has_upimg").focus();
                    }
                }
                //console.log(file);
            },
            model_edit:function () {
                if (!$('#addform').valid()) {
                    validator.focusInvalid();
                    return false;
                }
                addBodyload();

                var fd = new FormData();
                if(this.update_file&&this.update_file.file){
                    fd.append("up_file", this.update_file.file[0]);
                }
                fd.append("json_obj", JSON.stringify(this.model));
                this.$http.post(
                    this.api_model_edit,
                    fd,
                    {'Content-Type': 'Multipart/form-data'}
                ).then(
                    function (response) {
                        //console.log(response.data.Data);
                        if (response.data && response.data.Statu) {
                            switch (response.data.Statu) {
                                case "ok":
                                    if (response.data.Msg && $.trim(response.data.Msg) != "") {
                                        var jacked = humane.create({baseCls: 'humane-jackedup', addnCls: 'humane-jackedup-success', timeout: 2000})
                                        jacked.log(response.data.Msg);

                                    }
                                    if (response.data.BackUrl && $.trim(response.data.BackUrl) != "") {
                                        if (window.top) { window.top.location = response.data.BackUrl; } else {
                                            window.location = response.data.BackUrl;
                                        }
                                    } else {
                                        window.location.reload();
                                    }
                                    break;
                                case "err":
                                    if (response.data.Msg && $.trim(response.data.Msg) != "") {
                                        //$.alertMsg(data.Msg, "系統提示", function () { funcErr(data); });
                                        var jacked = humane.create({baseCls: 'humane-jackedup', addnCls: 'humane-jackedup-error', timeout: 2000})
                                        jacked.log(response.data.Msg);
                                    }
                                    break;
                            }
                        }
                        removeBodyload();
                    }, function (response) {
                        // 响应错误回调
                        console.log(response);
                        var jacked = humane.create({baseCls: 'humane-jackedup', addnCls: 'humane-jackedup-error', timeout: 2000})
                        jacked.log("系統忙碌中，請您稍後重新嘗試。");
                        removeBodyload();
                    }
                )
            },
        },
        // 使用一个监听。可以减少很多代码
        watch: {
            // model: function () {
            //     this.$nextTick(function () {
            //         $('#addform').valid();
            //     });
            // },

        }
    });

</script>
</body>
</html>
