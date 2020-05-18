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
                        <li><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首頁</a></li>
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
                                        <label class="col-md-2 control-label">類型</label>
                                        <div class="col-md-7">
                                            <select class="form-control" name="type" id="type" placeholder="類型" v-model="model.type">
                                                <option value="">請選擇</option>
                                                <option value="1">團體</option>
                                                <option value="2">個人</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">標題</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.title" name="title" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">報名資格</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.qualification" name="qualification" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">活動注意事項</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.announcements_activities" name="announcements_activities" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">報名注意事項</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.announcements_apply" name="announcements_apply" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">參賽辦法</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" v-model="model.entry" name="entry" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">比賽期間</label>
                                        <div class="col-md-7">
                                            <input placeholder="比賽期間" value="<?php echo isset($model['competition_period'])?$model['competition_period']:""; ?>"  name="competition_period" id="competition_period" class=" form-control dateStart" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">報名期間</label>
                                        <div class="col-md-7">
                                            <input placeholder="報名期間" value="<?php echo isset($model['apply_period'])?$model['apply_period']:""; ?>"  name="apply_period" id="apply_period" class=" form-control dateStart" type="text" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">賽程時間表</label>
                                        <div class="col-md-7">
                                            <div class="btn btn_en btn-success" onclick="document.getElementById('upload1').click();"><i class="fa fa-image"></i>瀏覽
                                                <input type="file" data-input="false" @change="tirgger_file_img_schedule($event,'up_img')" id="upload1" accept="image/*" data-badge="false" style="display:none;">
                                                <input type="text" :value="model.img_schedule" name="has_img_schedule" id="has_img_schedule" style="opacity: 0;position: absolute;" />
                                            </div>
                                            <span style="color: red;" v-if="size1">尺寸限制：1920＊1080</span>
                                        </div>
                                    </div>
                                    <div class="form-group picss" v-show="img_schedule&&img_schedule.name&&img_schedule.name.length>0">
                                        <label class="col-md-2 control-label sr-only"></label>
                                        <div class="col-md-7">
                                            <div class="sort_img_list">
                                                <div class="sort_img">
                                                    <div class="form-group-t">
                                                        <button type="button" class="btn btn-warning" @click="img_schedule={};model.img_schedule='';size1=0;">刪除</button>
                                                    </div>
                                                    <div class="form-group-z">
                                                        <div id="preimg">
                                                            <div class='imgContainer'>
                                                                <a :download="img_schedule.name" :data-name="img_schedule.name" target="_blank" :href="img_schedule.src"><img style="width: 200px;height: 200px" title='分類圖' class="src_list" :src="img_schedule.src"  onerror=this.onerror=null;this.src="assets/images/no.jpg" alt='图片'/></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">計分方式</label>
                                        <div class="col-md-7">
                                            <div class="btn btn_en btn-success" onclick="document.getElementById('upload').click();"><i class="fa fa-image"></i>瀏覽
                                                <input type="file" data-input="false" @change="tirgger_file_img_scoring($event,'up_img')" id="upload" accept="image/*" data-badge="false" style="display:none;">
                                                <input type="text" :value="model.img_scoring" name="has_img_scoring" id="has_img_scoring" style="opacity: 0;position: absolute;" />
                                            </div>
                                            <span style="color: red;" v-if="size2">尺寸限制：1440＊216</span>
                                        </div>
                                    </div>
                                    <div class="form-group picss" v-show="img_scoring&&img_scoring.name&&img_scoring.name.length>0">
                                        <label class="col-md-2 control-label sr-only"></label>
                                        <div class="col-md-7">
                                            <div class="sort_img_list">
                                                <div class="sort_img">
                                                    <div class="form-group-t">
                                                        <button type="button" class="btn btn-warning" @click="img_scoring={};model.img_scoring='';size2=0;">刪除</button>
                                                    </div>
                                                    <div class="form-group-z">
                                                        <div id="preimg">
                                                            <div class='imgContainer'>
                                                                <a :download="img_scoring.name" :data-name="img_scoring.name" target="_blank" :href="img_scoring.src"><img style="width: 200px;height: 200px" title='分類圖' class="src_list" :src="img_scoring.src"  onerror=this.onerror=null;this.src="assets/images/no.jpg" alt='图片'/></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">獎項</label>
                                        <div class="col-md-7">
                                            <div class="btn btn_en btn-success" onclick="document.getElementById('upload2').click();"><i class="fa fa-image"></i>瀏覽
                                                <input type="file" name="upimg" data-input="false"  @change="tirgger_file($event,'up_img')" id="upload2" accept="image/*" data-badge="false" style="display: none">
                                                <input type="text" :value="update_file" name="has_upimg" id="has_upimg" style="opacity: 0;position: absolute;" />
                                            </div>
                                            <span style="color: red;" v-if="size3">尺寸限制：227＊185</span>
                                        </div>
                                    </div>
                                    <div  class="form-group picss" v-show="update_file&&update_file.length>0" >
                                        <label class="col-md-2 control-label sr-only"></label>
                                        <div class="col-md-7">
                                            <div class="sort_img_list" v-for="(x,x_index) in update_file" style="float: left;width: 150px;height: 250px;margin-left: 10px;">
                                                <div class="sort_img" >
                                                    <div class="form-group-t">
                                                        <button type="button" class="btn btn-warning" @click="update_file.splice(x_index,1);awards_explain.splice(x_index,1);delimg(x_index);">刪除</button>
                                                    </div>
                                                    <div class="form-group-z">
                                                        <div id="preimg">
                                                            <div class='imgContainer'>
                                                                <a :download="x.name" :data-name="x.name" target="_blank" :href="x.src"><img style="width: 150px;height: 150px" title='分類圖' class="src_list" :id="'img'+x_index" :src="x.src"  onerror=this.onerror=null;this.src="assets/images/no.jpg" alt='图片'/></a>
                                                            </div>
					                                        <input type="text" class="form-control" v-model="awards_explain[x_index]" :name="'awards_explain'+x_index" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">上架時間</label>
                                        <div class="col-md-7">
                                            <input placeholder="比賽期間" value="<?php echo isset($model['added_at'])?$model['added_at']:""; ?>"  name="added_at" id="added_at" class=" form-control dateStart" type="text" readonly>
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
	$(function () {
        calenders("#competition_period", true, true);
        calenders("#apply_period", true, true);
        calenders("#added_at", false, true);

    });
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
                // has_upimg: {
                //     required: true
                // },
                has_img_schedule: {
                    required: true
                },
               has_img_scoring: {
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
                has_img_schedule: {
                    required: "請選擇賽程圖",
                },
                has_img_scoring: {
                    required: "請選擇計分圖",
                },

            },
            errorPlacement: function (error, element) { //指定错误信息位置
                var eid = element.attr('name'); //获取元素的name属性
                if(eid == "has_upimg"){

                    console.log(eid);
                    error.appendTo(element.parent().parent()); //将错误信息添加当前元素的父结点后面
                }else if(eid == "has_img_schedule"){
                	 console.log(eid);
                    error.appendTo(element.parent().parent()); //将错误信息添加当前元素的父结点后面
                }else if(eid == "has_img_scoring"){
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
            },
            label_list:{},
            small_class_list:{},
            update_file: [],
            awards_explain:[],
            img_scoring: {},
            img_schedule: {},
            size1:0,//初始為0，尺寸不對就為1
            size2:0,//初始為0，尺寸不對就為1
            size3:0,//初始為0，尺寸不對就為1
            api_model_edit:"<?php echo isset($api_edit)?$api_edit:""?>",
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
                if(this.model.awards_imgs){
                    for (let k in this.model.awards_imgs) {
                        this.update_file.push ({name: '設備圖', file: null, src: this.model.awards_imgs[k], type: 'img'});
                    }
                    this.is_pass(3);
                }
                if(this.model.img_scoring){
                    this.img_scoring = {name: '設備圖', file: null, src: this.model.img_scoring, type: 'img'};
                    this.is_pass(2);
                }
                if(this.model.img_schedule){
                    this.img_schedule = {name: '設備圖', file: null, src: this.model.img_schedule, type: 'img'};
                    this.is_pass(1);
                }
                if(this.model.awards_explain){
                	// console.log(this.model.awards_explain);
                    this.awards_explain=this.model.awards_explain;
                }
                
            }
        },
        methods: {
            delimg:function(event){
                if(this.model.awards_imgs.length>0){
                    this.model.awards_imgs.splice(event,1);
                }
                // if(this.model.awards_explain.length>0){
                //     this.model.awards_explain.splice(event,1);
                // }
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
           	//處理img_scoring圖片
            tirgger_file_img_scoring: function (event) {

                var file = event.target.files; // (利用console.log输出看file文件对象)
                console.log(file);
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
                        this.img_scoring = {
                            name: fileName,
                            file: file,
                            src: getObjectURL(file[0]),
                            type: "img"
                        };
                        console.log(this.class_name);
                        this.model.img_scoring="1";
                        this.is_pass(2);
                        $("#has_img_scoring").focus();
                    }
                }
                //console.log(file);
            },
            //處理img_schedule圖片
            tirgger_file_img_schedule: function (event) {

                var file = event.target.files; // (利用console.log输出看file文件对象)
                console.log(file);
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
                        this.img_schedule = {
                            name: fileName,
                            file: file,
                            src: getObjectURL(file[0]),
                            type: "img"
                        };
                        this.model.img_schedule="1";
                        this.is_pass(1);
                        $("#has_img_schedule").focus();
                    }
                }
                //console.log(file);
            },
            //處理多張圖片
            tirgger_file: function (event) {
                var file = event.target.files; // (利用console.log输出看file文件对象)
               	console.log(file);
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
                        if(this.update_file.length<15){
                            this.update_file.push ({
                                name: fileName,
                                file: file,
                                src: getObjectURL(file[0]),
                                type: "img"
                            });
                            this.awards_explain.push('');
                        }else{
                            var jacked = humane.create({
                                baseCls: 'humane-jackedup',
                                addnCls: 'humane-jackedup-error',
                                timeout: 2000
                            })
                            jacked.log("只能上傳十五張圖片");
                        }

                        this.model.pic="1";
                        this.is_pass(3);
                        $("#has_upimg").focus();
                    }
                }
                //console.log(file);
            },
            is_pass:function(num){
                //this赋值给this_，不然在sweetalert里面会冲突
				let this_=this;
                //递归，num=4跳出
                if(num ==4 ){
                	return;
                	// this.model_edit();
                }
                console.log(num);
                switch(num) {
				     case 1:
				        var img = new Image;
			    		img.onload = function(){        
			    		    console.log(img.height);
			    		    console.log(img.width);
			 	   			var width = img.width;
			 	   			var height=img.height;
			 	   			var filesize = img
			 	   			if(width!=1920 || height!=1080){
                				this_.size1=1;	
			 	   			}else{
                				this_.size1=0;	
			 	   			}
			    		};
			 	   		img.οnerrοr=function(){
			 	   	    	alert("error!");
			 	   	    };
			 	   	    img.src=this.img_schedule.src;
				        break;
				     case 2:
				        var img = new Image;
			    		img.onload = function(){        
			    		    console.log(img.height);
			    		    console.log(img.width);
			 	   			var width = img.width;
			 	   			var height=img.height;
			 	   			var filesize = img
			 	   			if(width!=1440 || height!=216){
			 	   			    this_.size2=1;	
			 	   			}else{
			 	   				this_.size2=0;	
			 	   			}
			    		};
			 	   		img.οnerrοr=function(){
			 	   	    	alert("error!");
			 	   	    };
			 	   	    img.src=this.img_scoring.src;
				        break;
				    case 3:
				    	var pass=1;
				    	for(k in this.update_file){
				    		//获取图片尺寸
				    		var img = $("#img"+k);
							this.dispose_img(img, function(dimensions){
								if(dimensions.w != 227 || dimensions.h !=185){
									pass=2;
								}
							});
				    	}
				    	console.log(pass);
				    	if(pass==2){
				    		this_.size3=1;	
				    	}else{
				    		this_.size3=0;	
				    	}
				        break;    
				     default:
				        console.log(3);
				        break;
				} 
            },
            dispose_img:function(oImg, callback){
            	var nWidth, nHeight;
			　　nWidth = oImg.naturalWidth;
			　　nHeight = oImg.naturalHeight;
			　　callback({w: nWidth, h:nHeight});
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
                if(this.img_schedule&&this.img_schedule.file){
                    fd.append("img_schedule", this.img_schedule.file[0]);
                }
                if(this.img_scoring&&this.img_scoring.file){
                    fd.append("img_scoring", this.img_scoring.file[0]);
                }
                fd.append("competition_period",document.getElementById('competition_period').value);
                fd.append("apply_period",document.getElementById('apply_period').value);
                fd.append("added_at",document.getElementById('added_at').value);
                fd.append('awards_explain',JSON.stringify(this.awards_explain));
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
