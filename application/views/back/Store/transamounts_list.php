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
        span.btn{
            cursor: initial;
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
                        財務管理
                        <small><a class="link-effect" href="<?php echo base_url('back/Store/index')?>">回首頁</a></small>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <a href="#" class="btn btn-primary" title="匯出">匯出</a>
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
                                        <div class="form-material floating">
                                            <input class="form-control" type="text" id="name" name="name">
                                            <label for="name">會員</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <div class="input-daterange input-group">
                                                <input class="form-control" type="number" name="amount_min" placeholder="min">
                                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                                <input class="form-control" type="number" name="amount_max" placeholder="max">
                                            </div>
                                            <label for="use_end">消費金額</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-material floating">
                                            <select name="status" id="status" class="form-control">
                                                <option value=""></option>
                                                <option value="1">已完成</option>
                                                <option value="2">待審核</option>
                                                <option value="3">退回</option>
                                                <option value="4">已取消</option>
                                            </select>
                                            <label for="status">狀態</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-material">
                                            <div class="input-group">
                                                <input placeholder="建立時間" name="c_time" id="c_time" class=" form-control dateStart" type="text" readonly>
                                                <div class="input-group-addon clearBtns">x</div>
                                            </div>
                                            <label for="c_time">建立時間</label>
                                        </div>
                                    </div>

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
                <table class="table table-striped" id="table-javascript">

                </table>
                <!--表格结束 -->

            </div>
            <!-- END 表数据容器 -->


        </div>
        <!-- END Page 內問中間默認開始 -->
    </main>
    <!-- END Main 中間容器 -->

    <?php $this->load->view('back/partials/_include_footer') ?>

    <div class="modal fade" id="myModal_send_close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">取消原因</h4>
                </div>
                <div class="modal-body">
                    <form id="form_close">
                        <input type="hidden" id="tran_id" />
                        <textarea class="form-control" rows="3" name="close_record" id="close_record"></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="send_close()">送出</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <div class="modal fade" id="myModal_send_examine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">取消原因</h4>
                </div>
                <div class="modal-body">
                    <form id="form_close">
                        <input type="hidden" id="tran_id" />
                        <!-- Blockquotes -->
                        <div class="block">
                            <div class="block-content" id="ex_log">

                            </div>
                        </div>
                        <!-- END Blockquotes -->
                        <label for="close_record2">取消原因：</label>
                        <textarea class="form-control" rows="3" name="close_record2" id="close_record2"></textarea>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="tran_back()">再次送出</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

</div>
<!-- END Page Container -->
<?php $this->load->view('back/partials/_include_last_js') ?>

<script>
    var validator;
    $(function () {
        calenders("#c_time", true, false);
        validator = $("#form_close").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper: "span",
            rules: {
                close_record: {
                    required: true,
                    minlength: 2,
                    maxlength: 500
                }
            },
            messages: {
                close_record: {
                    required: "請輸入原因",
                    minlength: "請輸入2-500個字元"
                }
            }
        });
    });

    $('#table-javascript').bootstrapTable({
        method: 'post',
        url: '<?php echo base_url('back/Store/transamounts_list')?>',
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
        sortName: 'id',
        sortOrder: 'desc',
        clickToSelect: false,
        contentType: "application/x-www-form-urlencoded",
        classes: "table table-striped table-bordered table-hover",
        toolbar: '#toolbar',
        uniqueId:"id",
        formatLoadingMessage: function () {
            return "請稍後，正在加載...";
        },
        formatNoMatches: function () {  //没有匹配的结果
            return '無符合條件記錄';
        },
        onLoadError: function (data) {
            $('#table-javascript').bootstrapTable('removeAll');
        },
        onClickRow: function (row, $element, field) {
            //if (field == "STATE" || field == "id" || field == "name"|| field == "status") { } else {
            //    window.location.href = "<?php //echo base_url('back/Store/activitie_edit/')?>//" + row.id;
            //}
        },
        onLoadSuccess: function () {

            if ($("#tabel_history")) {
                var pageNum = $('#table-javascript').bootstrapTable('getOptions').pageNumber;
                $("#tabel_history").val(pageNum)
            }
        },
        columns: [{
            field: 'STATE',
            checkbox: true,
            visible:true
        }, {
            field: 'id',
            title: 'ID',
            align: 'center',
            valign: 'bottom',
            sortable: false,
            visible:false
        }, {
            field: 'amount',
            title: '消費金額',
            align: 'center',
            valign: 'bottom',
            sortable: true
        }, {
            field: 'points',
            title: '使用點數',
            align: 'center',
            valign: 'bottom',
            sortable: true
        }, {
            field: 'member',
            title: '會員',
            align: 'center',
            valign: 'bottom',
            sortable: true
        }, {
            field: 'status',
            title: '狀態',
            align: 'center',
            valign: 'bottom',
            sortable: true,
            formatter:function (value, row, index) {
                if(value&&value.length>0)
                {
                    if(value==1){
                        return '<span class="btn btn-minw btn-rounded btn-success" readonly>已完成</span> <button class="btn btn-minw btn-rounded btn-info" type="button" onclick="show_close('+row.id+')">取消訂單</button>'
                    }
                    if(value==2){
                        return '<span class="btn btn-minw btn-rounded btn-info" readonly>待審核</span>'
                    }
                    if(value==3){
                        return '<span class="btn btn-minw btn-rounded btn-warning" readonly>退回</span> <button class="btn btn-minw btn-rounded btn-info" type="button" onclick="show_examine('+row.id+')">查看原因</button>'
                    }
                    if(value==4){
                        return '<span class="btn btn-minw btn-rounded btn-danger" readonly>已取消</span>'
                    }

                }else{
                    return "";
                }
            }
        }, {
            field: 'created_at',
            title: '建立時間',
            align: 'center',
            valign: 'bottom',
            sortable: true
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
            return '<label class="css-input switch switch-info"><input type="checkbox" value='+row.id+' class="xcheck" name=""><span ></span></label>';
        }
    }

    function operateFormatter(value, row, index) {
        return [
            '<a class="btn btn-xs btn-primary" href="backstage/Back/qa_detail?action=edit&id=' + row.Id + '" title="編輯">編輯</a>'
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

    function show_close(id) {
        $("#tran_id").val(id);
        $("#close_record").val("");
        $("#myModal_send_close").modal("show");
    }
    function send_close() {
        if (!$('#form_close').valid()) {
            validator.focusInvalid();
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('back/Store/tran_close') ?>',
            data: {id:$("#tran_id").val(),close_record:$("#close_record").val()},
            cache: false,
            dataType: 'json',
            success: showResponse,
            error: showError
        });
    }


    function showResponse(jsonData, statusText, xhr, $form) {
        /*alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
            '\n\nThe output div should have already been updated with the responseText.');*/
        switch (jsonData.Statu) {
            case "ok":
                if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                    sweetAlert(jsonData.Msg);
                    $("#myModal_send_close").modal("hide");
                    $('#table-javascript').bootstrapTable('refresh');
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

    function show_examine(id) {
        $("#tran_id").val(id);
        $("#ex_log").html("");
        $("#close_record2").val("");
        var row = $("#table-javascript").bootstrapTable('getRowByUniqueId', id);
        if(row&&row.audit_record_json)
        {
            var json_obj = JSON.parse(row.audit_record_json);
            if(json_obj&&json_obj.length>0)
            {
                //console.log(json_obj[json_obj.length-1].requester);
                var html = "";
                json_obj.forEach(function (item,index) {
                    html = html+'<blockquote>' +
                        '                    <p>'+item.requester+'</p>' +
                        '                    <footer>'+item.request_time+'</footer>' +
                        '                </blockquote>' +
                        ((item.responder&&item.responder.length>0)?(
                            '                <blockquote class="blockquote-reverse">' +
                            '                    <p>'+item.responder+'</p>' +
                            '                    <footer>管理員 '+item.response_time+'</footer>' +
                            '                </blockquote>'
                        ):"")
                });
                $("#ex_log").html(html);
            }
        }
        $("#myModal_send_examine").modal("show");
    }
    function tran_back() {
        if (!$('#form_close').valid()) {
            validator.focusInvalid();
            return false;
        }
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('back/Store/tran_close') ?>',
            data: {id:$("#tran_id").val(),close_record:$("#close_record2").val()},
            cache: false,
            dataType: 'json',
            success: function (jsonData) {
                switch (jsonData.Statu) {
                    case "ok":
                        if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                            sweetAlert(jsonData.Msg);
                            $("#myModal_send_examine").modal("hide");
                            $('#table-javascript').bootstrapTable('refresh');
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

                            });
                        }
                        break;
                }
            },
            error: showError
        });
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