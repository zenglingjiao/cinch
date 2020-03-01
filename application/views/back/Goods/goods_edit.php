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
                        <li><a class="link-effect" href="<?= isset($api_list)?$api_list:"/"?>"><?= isset($list_title)?$list_title:"列表"?></a></li>
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
                                        <label class="col-md-2 control-label">上傳帳號</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.up_user" name="up_user" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">物品名稱</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.name" name="name" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">物品圖</label>
                                        <div class="col-md-3">
                                            <div class="btn btn_en btn-success" onclick="document.getElementById('upload').click();"><i class="fa fa-image"></i>瀏覽
                                                <input type="file" name="upimg" data-input="false"  @change="tirgger_file($event,'up_img')" id="upload" accept="image/*" data-badge="false" style="display: none">
                                                <input type="text" :value="update_file" name="has_upimg" id="has_upimg" style="opacity: 0;position: absolute;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="(x,x_index) in update_file" class="form-group picss" v-show="update_file&&x.name&&update_file.length>0">
                                        <label class="col-md-2 control-label sr-only"></label>
                                        <div class="col-md-7">
                                            <div class="sort_img_list">
                                                <div class="sort_img" >
                                                    <div class="form-group-t">
                                                        <button type="button" class="btn btn-warning" @click="update_file.splice(x_index,1);delimg(x_index);">刪除</button>
                                                    </div>
                                                    <div class="form-group-z">
                                                        <div id="preimg">
                                                            <div class='imgContainer'>
                                                                <a :download="x.name" :data-name="x.name" target="_blank" :href="x.src"><img title='分類圖' class="src_list" :src="x.src"  onerror=this.onerror=null;this.src="assets/images/no.jpg" alt='图片'/></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">物品分類</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="goods_type_id" id="goods_type_id" placeholder="取物方式" v-model="model.goods_type_id">
                                                <option value="">請選擇</option>
                                                <template v-for="(x,x_index) in small_class_list">
                                                    <option :value="x.id">{{x.name}}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">取物方式</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="purchase_way" id="purchase_way" placeholder="取物方式" v-model="model.purchase_way">
                                                <option value="">請選取物方式</option>
                                                <option>面交</option>
                                                <option>全家店到店</option>
                                                <option>黑貓宅急便</option>
                                                <option>OX快送</option>
<!--                                                <option>面交</option>-->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="model.purchase_way=='面交'">
                                        <label class="col-md-2 control-label">面交地點</label>
                                        <div class="col-md-7">
                                            <div class="input-group" v-for="(x,x_index) in m_place">
                                                <input type="text" class="form-control" v-model="m_place[x_index]" name="m_place" />
                                                <span class="input-group-btn" v-if="x_index>0||(m_place.length>1&&x_index>=0)">
                                                    <button class="btn btn-default" type="button" @click="m_place.splice(x_index,1)"><i class="fa fa-minus"></i></button>
                                                </span>
                                                <span class="input-group-btn" v-if="m_place.length-1==x_index">
                                                    <button class="btn btn-default" type="button" @click="m_place.push('')"> <i class="fa fa-plus"></i> </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">使用次數</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="use_number" id="use_number" v-model="model.use_number" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">存放時間</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="storage_titme" id="storage_titme" v-model="model.storage_titme" />
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="storage_titme_units" id="storage_titme_units" placeholder="存放時間" v-model="model.storage_titme_units">
                                                <option value="">請選擇</option>
                                                <option>日</option>
                                                <option>月</option>
                                                <option>週</option>
                                                <option>年</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">狀態標籤</label>
                                        <div class="col-md-6">
<!--                                            <template v-for="(x,x_index) in m_place1">-->

                                                <label v-for="(x,x_index) in label_list" class="css-input css-radio css-radio-warning push-10-r">
                                                    <input type="checkbox" :checked="model.state_label.indexOf(x.name)>=0"  @click="toggleCheckSingle(x.name,$event)" name="state_label"><span></span>{{x.name}}
                                                </label>

<!--                                            </template>-->
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" @click="custom_label.push('')"> <i class="fa fa-plus"></i> </button>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label"></label>
                                        <div class="col-md-7">
                                            <div class="input-group" v-for="(x,x_index) in custom_label" >
                                                <input type="text" class="form-control" v-model="custom_label[x_index]" name="custom_label" />
                                                <span class="input-group-btn" v-if="x_index>=0">
                                                    <button class="btn btn-default" type="button" @click="custom_label.splice(x_index,1)"><i class="fa fa-minus"></i></button>
                                                </span>
                                                <span class="input-group-btn" v-if="custom_label.length-1==x_index">
                                                    <button class="btn btn-default" type="button" @click="custom_label.push('')"> <i class="fa fa-plus"></i> </button>
                                                </span>
                                            </div>
                                        </div>
<!--                                        <label class="col-md-2 control-label"></label>-->
<!--                                        <div class="col-md-6" v-for="(x,x_index) in m_place2">-->
<!--                                            <input type="text" class="form-control" name="use_number" id="use_number" v-model="model.use_number" />-->
<!--                                            <span class="input-group-btn" v-if="x_index>0||(m_place.length>1&&x_index>=0)">-->
<!--                                                    <button class="btn btn-default" type="button" @click="m_place2.splice(x_index,1)"><i class="fa fa-minus"></i></button>-->
<!--                                                </span>-->
<!--                                            <span class="input-group-btn">-->
<!--                                                    <button class="btn btn-default" type="button" @click="m_place2.push('')"> <i class="fa fa-plus"></i> </button>-->
<!--                                                </span>-->
<!--                                        </div>-->
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label">運費</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="freight" id="freight" v-model="model.freight" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="0" v-model="model.freight_pt" name="freight_pt"><span></span> 贈物方式
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="1" v-model="model.freight_pt" name="freight_pt"><span></span> 取物方式
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
                state_label:[]
            },
            m_place:[""],
            m_place1:[""],
            custom_label:[],
            label_list:{},
            small_class_list:{},
            update_file: [],
            api_model_edit:"<?php echo isset($api_edit)?$api_edit:""?>",
        },
        mounted: function () {
            var json_model = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($model) ? $model : null)))?>'.replace(/\+/g," ")));
            var label_list = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($label_list) ? $label_list : null)))?>'.replace(/\+/g," ")));
            var small_class_list = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($small_class_list) ? $small_class_list : null)))?>'.replace(/\+/g," ")));
            if(small_class_list){
                this.small_class_list= small_class_list;
            }
            if(label_list){
               this.label_list= label_list;
            }
            if (json_model) {
                this.model = json_model;
                if(this.model.state=="1"){
                    this.model.state=true;
                }else{
                    this.model.state=false;
                }
                if(this.model.pic){
                    for (let k in this.model.pic) {
                        this.update_file.push ({name: '設備圖', file: null, src: this.model.pic[k], type: 'img'});
                    }
                }
                if(this.model.m_place){
                    this.m_place=JSON.parse(this.model.m_place);
                }
                if(this.model.custom_label){
                    this.custom_label=JSON.parse(this.model.custom_label);
                }
                if(this.model.state_label){
                    this.model.state_label=JSON.parse(this.model.state_label);
                }
            }
        },
        methods: {
            delimg:function(event){
                if(this.model.pic.length>0){
                    this.model.pic.splice(event,1);
                }
            },
            //多选框
            toggleCheckSingle(id,e) {
                if(e.target.checked) {
                    if(this.model.state_label.indexOf(id) === -1) {
                        this.model.state_label.push(id)
                    }
                } else {
                    if(this.model.state_label.indexOf(id) !== -1) {
                        const thisIndex = this.model.state_label.indexOf(id)
                        this.model.state_label.splice(thisIndex,1)
                    }
                }
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
                        if(this.update_file.length<3){
                            this.update_file.push ({
                                name: fileName,
                                file: file,
                                src: getObjectURL(file[0]),
                                type: "img"
                            });
                        }else{
                            var jacked = humane.create({
                                baseCls: 'humane-jackedup',
                                addnCls: 'humane-jackedup-error',
                                timeout: 2000
                            })
                            jacked.log("只能上傳三張圖片");
                        }

                        this.model.pic="1";
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
                if(this.update_file&&this.update_file.length>0){
                    var has_upimg='';
                    for (let k in this.update_file) {
                        if(this.update_file[k].file) {
                            fd.append("up_file" + k, this.update_file[k].file[0]);
                        }else{
                            has_upimg +=this.update_file[k].src+',';
                        }
                    }
                    fd.append("has_upimg", has_upimg.substring(0,has_upimg.length-1));
                    // fd.append("up_file", this.update_file.file[0]);
                }
                fd.append('m_place',JSON.stringify(this.m_place));
                fd.append('custom_label',JSON.stringify(this.custom_label));
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