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
                        會員管理
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首页</a></li>
                        <li><a class="link-effect" href="<?php echo base_url('back/Members/member_list')?>">會員列表</a></li>
                        <li><?php echo isset($model->id)&&$model->id > 0?"會員編輯":"會員新增" ?></li>
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
                                    <?php echo isset($model->id)&&$model->id > 0?"會員編輯":"會員新增" ?> <small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="<?php echo base_url('back/Members/member_edit')?>" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:""?>">

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">姓名</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.nick_name" name="nick_name" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">電子信箱</label>
                                        <div class="col-md-7">
                                            <div v-if="model.id&&model.id>0"class="form-control-static">{{model.email}}</div>
                                            <input v-else class="form-control"  v-model="model.email" name="email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">手機號碼</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.phone" name="phone" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">地址</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.address" name="address" />
                                        </div>
                                    </div>

                                    <div class="form-group" v-if="model.id&&model.id>0">
                                        <label class="col-md-2 control-label">密碼</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="userpassword" v-model="model.userpassword"  placeholder="填入為修改密碼，不填則不修改" />
                                        </div>
                                    </div>
                                    <div class="form-group" v-else>
                                        <label class="col-md-2 control-label">密碼</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.userpassword" name="userpassword" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">積分</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.integral" name="integral" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">評級</label>
                                        <div class="col-md-7">
                                            <select class="form-control" v-model="model.lev" name="lev">
                                                <template v-for="(x,x_index) in user_ratings">
                                                    <option :value="x.id">{{x.title}}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">興趣分類</label>
                                        <div class="col-md-7">
                                            <div class="input-group" v-for="(x,x_index) in xq">
                                                <input type="text" class="form-control" v-model="xq[x_index]" name="hobby" />
                                                <span class="input-group-btn" v-if="x_index>0||(xq.length>1&&x_index>=0)">
                                                    <button class="btn btn-default" type="button" @click="xq.splice(x_index,1)"><i class="fa fa-minus"></i></button>
                                                </span>
                                                <span class="input-group-btn" v-if="xq.length-1==x_index">
                                                    <button class="btn btn-default" type="button" @click="xq.push('')"> <i class="fa fa-plus"></i> </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group" v-if="model.id">
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
        $.validator.addMethod("check_code",function(value,element,params){
            var check = /(^[A-Z]{3}).*/;
            return this.optional(element)||(check.test(value));
        },"請輸入三位大寫英文字母！");

        validator = $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper: "span",
            rules: {
                nick_name: {
                    required: true,
                    minlength: 2,
                    maxlength: 30
                },
                email: {
                    required: true,
                    minlength: 5,
                    maxlength: 30
                },
                userpassword: {
                    // required: true,
                    minlength: 5,
                    maxlength: 30
                },
                pass_again: {
                    required: true,
                    minlength: 5,
                    maxlength: 30,
                    equalTo: "#pass"
                },
                role: {
                    required: true
                },
                code:{
                    required: true,
                    check_code:true,
                },
                responsible_area:{
                    required: true
                }
            },
            messages: {
                nick_name: {
                    required: "請輸入姓名",
                    minlength: "請輸入2-30個字元"
                },
                email: {
                    required: "請輸入Email",
                    minlength: "請輸入5-30個字元"
                },
                userpassword: {
                    // required: "請輸入密碼",
                    minlength: "請輸入5-30個字元英文或數字"
                },
                pass_again: {
                    required: "請再次輸入密碼",
                    minlength: "請輸入5-30個字元英文或數字",
                    equalTo: "兩次密碼輸入不一致"
                },
                role: {
                    required: "請選擇企業性質"
                },
                code:{
                    required: "請輸入代碼"
                },
                responsible_area:{
                    required: "請輸選擇負責區域"
                }
            }
        });



    });

    Vue.http.options.emulateJSON = true;

    var vue_obj = new Vue({
        el: '#main-container',
        data: {
            model: {},
            user_ratings: {},
            xq:[""],
            api_model_edit:"<?php echo base_url('back/Members/member_edit')?>",
        },
        mounted: function () {
            var json_model = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($model) ? $model : null)))?>'.replace(/\+/g," ")));
            var user_ratings = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($user_ratings) ? $user_ratings : null)))?>'.replace(/\+/g," ")));
            if(user_ratings){
                this.user_ratings = user_ratings;
            }
            if (json_model) {
                this.model = json_model;
                if (json_model.hobby) {
                    this.xq=JSON.parse(json_model.hobby);
                }
            }
        },
        methods: {
            model_edit:function () {
                if (!$('#addform').valid()) {
                    validator.focusInvalid();
                    return false;
                }
                addBodyload();
                var xq_josn = JSON.stringify(this.xq);
                this.model.xq = xq_josn;
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
            // agent_list: function () {
            //     this.$nextTick(function () {
            //         $('.selectpicker').selectpicker('refresh');
            //     });
            // },

        }
    });

</script>
</body>
</html>