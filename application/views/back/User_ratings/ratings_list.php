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
                        <?php echo isset($h_title)?$h_title:"管理"?>
                        <small><a class="link-effect" href="<?php echo base_url('back/Admin/index')?>">回首頁</a></small>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <a href="<?php echo isset($edit)?$edit:""?>" class="btn btn-primary" title="新增">新增</a>
                </div>
            </div>
        </div>
        <!-- END Page 中間標題頭部 -->

        <!-- Page 內問中間默認開始 floating-->
        <div class="content">
            <div class="block">
                <div class="block-header">
                    <div class="message-table table-responsive smart-widget">
                        <div class="smart-widget-header">
                            <form class="form-inline no-margin herd-from-alert" id="form_search">
                                <div class="cleom">
                                    <div class="form-group">
                                        <label class="control-label" for="">關鍵字：</label>
                                        <input class="form-control" type="text" id="title" name="title" placeholder="輸入關鍵字">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="">狀態：</label>
                                        <select name="state" id="state" class="form-control">
                                            <option value=""></option>
                                            <option value="1">開啟</option>
                                            <option value="0">關閉</option>
                                        </select>
                                    </div>
<!--                                    <div class="form-group">-->
<!--                                        <label class="control-label" for="">建立時間：</label>-->
<!--                                        <input placeholder="建立時間" name="c_time" id="c_time" class=" form-control dateStart" type="text" readonly>-->
<!--                                    </div>-->

                                </div>
                                <div class="cleom">

                                    <button type="button" class="btn btn-info btn-clean" onclick="cleanForm()">清除</button> <button type="button" class="btn btn-success btn-query" onclick="$('#search').val('1');$('#table-javascript').bootstrapTable('refreshOptions',{pageNumber:1});">查詢</button>
                                    <div class="clearfix">
                                        <input id="search" name="search" type="hidden" />
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 表数据容器 -->
            <div class="message-table table-responsive smart-widget">

                <!--这是表格 -->
                <table class="table overview-table" id="table-javascript">

                </table>
                <!--表格结束 -->

            </div>
            <!-- END 表数据容器 -->
            <div class="message-table table-responsive smart-widget push-10" id="btn_box">
                <div class="smart-widget-header">
                    <div class="form-inline no-margin">
                        <div style="">
                            <div class="form-group">
                                <button type="button" class="btn btn-danger" onclick ="Ajax_Post_Select_msg('刪除選定項？ 刪除後無法還原！', '<?php echo isset($api_delete)?$api_delete:""?>', 'table-javascript', '至少選擇一條')">選擇刪除</button>
                            </div>
                        </div>
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
        calenders("#c_time", true, false);

    });

    $('#table-javascript').bootstrapTable({
        method: 'post',
        url: '<?php echo isset($api_list)?$api_list:""?>',
        striped: true,
        pagination: true,
        pageSize: 10,
        pageList: [10, 20, 50, 100, 200, 500, 1000],
        //search: true,
        sidePagination: 'server',
        showColumns: true,
        showRefresh: true,
        queryParams: queryParams,
        minimumCountColumns: 2,
        sortName: 'created_at',
        sortOrder: 'desc',
        clickToSelect: false,
        contentType: "application/x-www-form-urlencoded",
        classes: "table overview-table table-hover",
        toolbar: '#toolbar',
        formatLoadingMessage: function () {
            return "請稍後，正在加載...";
        },
        formatNoMatches: function () {  //没有匹配的结果
            return '無符合條件記錄';
        },
        onLoadError: function (data) {
            $('#table-javascript').bootstrapTable('removeAll');
        },
        //表格內部點擊
        onClickRow: function (row, $element, field) {
            //if (field == "STATE" || field == "id" || field == "third_login" || field == "name") { } else {
            //    window.location.href = "<?php //echo base_url('back/Goods/main_class_edit/')?>//" + row.id;
            //}
        },
        //表格頁面數據渲染數據後執行的方法
        onLoadSuccess: function () {
            //$("#md-show").wrap('<div class="reveal-overlay" style="display: block;"></div>');
            if($('#table-javascript').bootstrapTable("getOptions").totalRows<=1){
                $("#btn_box").css("margin-top","10px")
            }
            $('.xcheck').change(function () {
                if($(this).is(":checked"))
                {
                    poststate=1;
                }
                else{
                    poststate=0;
                }
                $.ajax({
                    type : 'post',
                    url : '<?php echo isset($state)?$state:""?>',
                    data: 'id=' + this.value + '&set=' + poststate+ '&field=state',
                    //async : false, //同步方式
                    success : function(redata) {
                        if(redata>0)
                        {

                        }
                        else
                        {
                            sweetAlert("狀態保存失敗");
                            $('#table-javascript').bootstrapTable('refresh');
                        }
                    }
                });

            });
            if ($("#tabel_history")) {
                var pageNum = $('#table-javascript').bootstrapTable('getOptions').pageNumber;
                $("#tabel_history").val(pageNum)
            }
        },
        columns: [{
            field: 'STATE',
            checkbox: true,
            visible:true,
            class:'iii'
        }, {
            field: 'id',
            title: 'ID',
            align: 'center',
            valign: 'bottom',
            sortable: false,
            visible:false
        },{
            field: 'sort',
            title: '排序',
            align: 'center',
            valign: 'center',
            sortable: true
        }, {
            field: 'title',
            title: '標題',
            align: 'center',
            valign: 'center',
            sortable: true
        },{
            field: 'imgs',
            title: '圖片',
            align: 'center',
            valign: 'center',
            // sortable: true
            formatter:function (value, row, index) {
              return  '<img class="img-avatar img-avatar48" src="'+value+'" alt="">';
            }
        }, {
            field: 'state',
            title: '關閉／開啟',
            align: 'center',
            valign: 'center',
            sortable: true,
            formatter:returnStatus
        },{
            field: 'created_at',
            title: '操作',
            align: 'center',
            valign: 'center',
            sortable: true,
            formatter:operateFormatter
        }
        ]
    });

    //设置传入参数
    function queryParams(params) {
        if ($("#search").val() == '1') {
            params = $.extend(params, $('#form_search').serializeJson());
            $("#search").val('0');
        } else {
            $("#search").val('0');
            params = $.extend(params, $('#form_search').serializeJson());
        }
        return params
    }

    function returnStatus(value, row, index) {
        if(value==1 || value == "1")
        {
            return '<label class="css-input switch switch-info"><input type="checkbox" value='+row.id+' class="xcheck" checked ><span></span></label>';
        }
        else
        {
            return '<label  class="css-input switch switch-info"><input type="checkbox" value='+row.id+' class="xcheck" name=""><span ></span></label>';
        }
    }

    function operateFormatter(value, row, index) {
        return [
            '<a class="btn btn-primary" href="<?php echo isset($edit)?$edit:""?>' + row.id + '" title="編輯">編輯</a>',
            //'   ',
            //'<a style="background-color:red;" class="btn btn-primary" href="<?php //echo isset($edit)?$edit:""?>//' + row.id + '" title="刪除">刪除</a>'
        ].join('');

    }

    function returnLong(value){
        if(value.length>30){
            return value.substring(0,25)+'...';
        }else{
            return value;
        }
    }

    function getDate(date) {
        if (date && date.length > 4) {
            return date.split(" ")[0];
        } else {
            return "";
        }
    }

    function getTime(value, row, index){
        return row.concertTime.split(" ")[1].substring(0,5);
    }

    function cleanForm(){
        $(':input','#form_search').not(':button, :submit, :reset, :hidden').val('').removeAttr('checked').removeAttr('selected');
        $('#table-javascript').bootstrapTable('refreshOptions',{pageNumber:1});
    }
</script>
</body>
</html>