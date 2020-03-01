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
                        活動管理
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首页</a></li>
                        <li><a class="link-effect" href="<?php echo base_url('back/Activities/activitie_list')?>">活動列表</a></li>
                        <li><?php echo isset($model->id)&&$model->id > 0?"活動編輯":"活動新增" ?></li>
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
                                    <?php echo isset($model->id)&&$model->id > 0?"活動編輯":"活動新增" ?> <small></small>
                                </h3>
                            </div>
                            <div class="block-content block-content-narrow">
                                <form id="addform" class="js-validation-bootstrap form-horizontal" action="" method="post" novalidate="novalidate" autocomplete="off">
                                    <input type="hidden" name="id" v-model="model.id">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">活動名稱</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="name" v-model="model.name" type="text" placeholder="活動名稱">
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="model.store_list&&model.store_list.length>0">
                                        <label class="col-md-2 control-label">參與分店</label>
                                        <div class="col-md-7">
                                            <template v-for="store in model.store_list">
                                            <label class="css-input css-checkbox css-checkbox-warning push-10-r">
                                                <input type="checkbox" :checked="is_check_store(store.id)" :value="store.id" name="check_store[]"><span></span> {{store.store_name}}
                                            </label>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">使用期限永久</label>
                                        <div class="col-md-8">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="0" v-model="model.is_forever" name="is_forever"><span></span> 否
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="1" v-model="model.is_forever" name="is_forever"><span></span> 是
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" v-show="model.is_forever==0">
                                        <label class="col-md-2 control-label">使用時間</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="use_date" id="use_date" type="text" placeholder="使用時間">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-2 control-label">活動圖片</label>
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
                                        <label class="col-md-2 control-label">優惠方式</label>
                                        <div class="col-md-3">
                                            <select class="form-control selectpicker" name="preferential_id" id="preferential_id" data-live-search="true">
                                                <option value="">選擇</option>
                                                <template v-for="pre in model.preferentials">
                                                    <option :selected="pre.id==model.preferential_id" :value="pre.id">{{pre.name}}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">優惠內容</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" rows="3" name="preferential_content" v-model="model.preferential_content"  placeholder="優惠內容"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">注意事項</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" rows="3" name="points" v-model="model.points"  placeholder="注意事項"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">重複領取</label>
                                        <div class="col-md-8">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="0" v-model="model.is_re" name="is_re"><span></span> 不可以
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="1" v-model="model.is_re" name="is_re"><span></span> 可以
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">發放方式</label>
                                        <div class="col-md-8">
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="0" v-model="model.mode" name="mode"><span></span> 公開
                                            </label>
                                            <label class="css-input css-radio css-radio-warning push-10-r">
                                                <input type="radio" value="1" v-model="model.mode" name="mode"><span></span> 領取
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group" v-show="model.mode==1">
                                        <label class="col-md-2 control-label">虛擬卷發放數量</label>
                                        <div class="col-md-7">
                                            <div v-if="model.id>0">
                                                <label class="css-input css-radio css-radio-warning push-10-r">
                                                    <input type="radio" :value="model.is_up_fictitious_up" v-model="model.is_up_fictitious_up" name="is_up_fictitious_up"><span></span> {{model.is_up_fictitious_up==1?"序號匯入":"輸入數量"}}
                                                </label>
                                            </div>
                                            <div v-else>
                                                <label class="css-input css-radio css-radio-warning push-10-r">
                                                    <input type="radio" value="0" v-model="model.is_up_fictitious_up" name="is_up_fictitious_up"><span></span> 輸入數量
                                                </label>
                                                <label class="css-input css-radio css-radio-warning push-10-r">
                                                    <input type="radio" value="1" v-model="model.is_up_fictitious_up" name="is_up_fictitious_up"><span></span> 序號匯入
                                                </label>
                                            </div>

                                            <div style="display: flex;">
                                                <div v-show="model.is_up_fictitious_up==0" style=""><input class="form-control" name="fictitious" v-model="model.fictitious" v-on:input="model.fictitious=model.fictitious.replace(/[^\d]/g,'')" type="text" placeholder="虛擬卷發放數量"></div>
                                                <div v-show="model.is_up_fictitious_up==1" style="flex: 1;"><button class="btn btn-block btn-default" id="up_code" onclick="document.getElementById('up_code_file').click();" type="button">選擇excel導入序號 {{(model.fictitious_num&&model.fictitious_num>0)?'資料庫已存序號：'+model.fictitious_num:'0'}} {{(fictitious_code&&fictitious_code.length>0)?'當前excel分析數量：'+fictitious_code.length:''}}</button>
                                                    <input style="display: none;" type="file" id="up_code_file"  @change="update_file($event)" /></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" v-show="model.mode==1">
                                        <label class="col-md-2 control-label">實體卷發放數量</label>
                                        <div class="col-md-7">
                                            <input class="form-control" name="entity" v-model="model.entity" v-on:input="model.entity=model.entity.replace(/[^\d]/g,'')" type="text" placeholder="實體卷發放數量">
                                        </div>
                                    </div>

<!--                                    <div class="form-group" v-show="model.mode==1">-->
<!--                                        <label class="col-md-2 control-label">會員限制</label>-->
<!--                                        <div class="col-md-3">-->
<!--                                            <select class="form-control" name="limits" id="limits" v-model="model.limits">-->
<!--                                                <option value="0">無</option>-->
<!--                                                <option value="1" >等級1以上</option>-->
<!--                                                <option value="2" >等級2以上</option>-->
<!--                                                <option value="3" >等級3以上</option>-->
<!--                                                <option value="4" >等級4以上</option>-->
<!--                                                <option value="5" >等級5以上</option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                    </div>-->

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
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal_excel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_excel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel_excel">當前上傳Excel分析出的序號</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>序號</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(code,code_index) in fictitious_code">
                                <td>{{code}}</td>
                                <td><button type="button" class="btn btn-danger" @click="del_code(code_index)">刪除</button></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                        <!--                        <button type="button" class="btn btn-primary" data-dismiss="modal">確定</button>-->
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </main>
    <!-- END Main 中間容器 -->

    <?php $this->load->view('back/partials/_include_footer') ?>

</div>
<!-- END Page Container -->

<?php $this->load->view('back/partials/_include_last_js') ?>

<script>
    var validator;
    $(function () {
        calenders("#use_date", true, false);
        validator = $("#addform").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper: "span",
            rules: {
                name: {
                    required: true,
                    minlength: 2,
                    maxlength: 200
                }
            },
            messages: {
                account: {
                    required: "請輸入活動名稱",
                    minlength: "請輸入2-200個字元"
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
            fictitious_code: [],
        },
        mounted: function () {
            var json_model = JSON.parse(decodeURIComponent('<?php echo urlencode(json_encode((isset($model) ? $model : null)))?>'.replace(/\+/g," ")));
            if (json_model) {
                this.model = json_model;
                var this_= this;
                if (json_model.pic && json_model.pic.length > 0) {
                    $.each(json_model.pic, function (index, value) {
                        this_.media_pic_list.push({name: value, src: value});
                    });
                }
                $("#use_date").val(json_model.use_date);
            }
        },
        methods: {
            del_pic_img:function (index) {
                this.media_pic_list.splice(index,1);
            },
            is_check_store: function (store_id) {
                var is_check = false;
                if (this.model.check_store) {
                    $.each(this.model.check_store, function (index, value) {
                        if (value.store_id == store_id) {
                            is_check = true;
                            return true;
                        }
                    });
                }
                return is_check;
            },
            update_file: function (event) {
                var file = event.target.files;
                var fd = new FormData();
                fd.append('file', file[0]);
                addBodyload();
                this.$http.post(
                    "<?php echo base_url('back/Store/update_excel') ?>",
                    fd, {'Content-Type': 'Multipart/form-data'}
                ).then(
                    function (response) {
                        removeBodyload();
                        switch (response.data.Statu) {
                            case "ok":
                                //console.log(response.data.Data);
                                this.fictitious_code = response.data.Data;
                                $("#myModal_excel").modal("show");
                                break;
                            case "err":
                                sweetAlert(response.data.Msg);
                                break;
                        }
                    }, function (response) {
                        // 响应错误回调
                        sweetAlert("上傳失敗");
                        removeBodyload();
                    }
                )
                //上傳成功後 刪除vue文件對象
                $("#up_code_file").val("");
            },
            del_code:function (index) {
                this.fictitious_code.splice(index, 1);
            }
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

        vue_obj.fictitious_code.forEach(function (item,index) {
            fd.append('fictitious_code[]',item);
        })

        $.ajax({
            type: 'post',
            url: '<?php echo base_url('back/Activities/activitie_edit') ?>',
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