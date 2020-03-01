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
                                    <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:""?>">
                                    <div class="form-group" v-if="model.id&&model.id>0">
                                        <label class="col-md-2 control-label">訂單編號</label>
                                        <div class="col-md-7">
                                            <label class="control-label">{{model.order_no}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">會員帳號</label>
                                        <div class="col-md-7" v-if="model.id&&model.id>0">
                                            <label class="control-label">{{model.member_account}}</label>
                                        </div>
                                        <div class="col-md-7" v-else>
                                            <input type="text" class="form-control" v-model="model.member_account" name="member_account" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">商品分類</label>
                                        <div class="col-md-7" v-if="model.id&&model.id>0">
                                            <label class="control-label">{{model.goods_type}}</label>
                                        </div>
                                        <div class="col-md-7" v-else>
                                            <select class="form-control" name="goods_type" id="goods_type" placeholder="商品分類" v-model="model.goods_type">
                                                <option value="">請選取物方式</option>
                                                <template v-for="(x,x_index) in small_class_list">
                                                    <option :value="x.id">{{x.name}}</option>
                                                </template>
                                                <!--                                                <option>面交</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">商品名稱</label>
                                        <div class="col-md-7" v-if="model.id&&model.id>0">
                                            <label class="control-label">{{model.goods_name}}</label>
                                        </div>
                                        <div class="col-md-7" v-else>
<!--                                            <input type="text" class="form-control" v-model="model.goods_name" name="goods_name" />-->
<!--                                            <select class="form-control" name="goods_type" id="goods_type" >-->
                                            <select class="form-control selectpicker" placeholder="商品分類" v-model="model.goods_name" name="goods_name" id="goods_name" data-live-search="true">
                                                <option value="">選擇</option>
                                                <template v-for="(x,x_index) in goods_data">
                                                    <option :value="x.name">{{x.name}}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">贈物方帳號</label>
                                        <div class="col-md-7" v-if="model.id&&model.id>0">
                                            <label class="control-label">{{model.donor_account}}</label>
                                        </div>
                                        <div class="col-md-7" v-else>
                                            <label class="control-label">{{good_list[model.goods_name]}}</label>

                                            <input type="hidden"  class="form-control" v-model="model.donor_account=good_list[model.goods_name]"  name="donor_account" />
                                        </div>
                                    </div>
<!--                                    <div class="form-group">-->
<!--                                        <label class="col-md-2 control-label">狀態</label>-->
<!--                                        <div class="col-md-7">-->
<!--                                            <label class="css-input switch switch-success">-->
<!--                                                <input type="checkbox" v-model="model.state"><span></span>-->
<!--                                            </label>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <div class="form-group" v-if="model.id&&model.id>0">
                                        <label class="col-md-2 control-label">狀態</label>
                                        <div class="col-md-7">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="1" v-model="model.state" name="state"><span></span> 待出貨
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="2" v-model="model.state" name="state"><span></span> 已出貨
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="3" v-model="model.state" name="state"><span></span> 已完成
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
        $('.selectpicker').selectpicker({
            language: 'zh_CN',
            // 设置下拉方向始终向下
            dropupAuto: false,
            size: 4
        });

        $.validator.addMethod("check_code",function(value,element,params){
            var check = /(^[A-Z]{3}).*/;
            return this.optional(element)||(check.test(value));
        },"請輸入三位大寫英文字母！");

        validator = $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper: "div",
            rules: {
                class_type: {
                    required: true
                },
                name: {
                    required: true,
                },
                has_upimg: {
                    required: true
                },
            },
            messages: {
                class_type: {
                    required: "請選擇主分類",
                },
                name: {
                    required: "分類名稱不可為空",
                },
                has_upimg: {
                    required: "請選擇分類圖",
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
            model: {
                goods_name:'',
            },
            good_list: {},
            small_class_list:{},
            goods_data:{},
            api_model_edit:"<?php echo isset($edit)?$edit:""?>",
        },
        mounted: function () {
            var json_model = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($model) ? $model : null)))?>'.replace(/\+/g," ")));
            var good_list = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($goods_list) ? $goods_list : null)))?>'.replace(/\+/g," ")));
            var small_class_list = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($small_class_list) ? $small_class_list : null)))?>'.replace(/\+/g," ")));
            var goods_data = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($goods_data) ? $goods_data : null)))?>'.replace(/\+/g," ")));
            if(goods_data){
                this.goods_data= goods_data;
            }
            if(small_class_list){
                this.small_class_list= small_class_list;
            }
            if (json_model) {
                this.model = json_model;

            }
            console.log(good_list);
            if (good_list) {
                this.good_list = good_list;
            }
        },
        methods: {
            model_edit:function () {
                if (!$('#addform').valid()) {
                    validator.focusInvalid();
                    return false;
                }
                addBodyload();
                this.$http.post(
                    this.api_model_edit,
                    this.model,
                    {emulateJSON: true}
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