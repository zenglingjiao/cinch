<!-- Apps Modal -->
<!-- Opens from the button in the header -->
<div class="modal fade" id="apps-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-sm modal-dialog modal-dialog-top">
        <div class="modal-content">
            <!-- Apps Block -->
            <div class="block block-themed block-transparent">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">我是筛选前端后端</h3>
                </div>
                <div class="block-content">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <a class="block block-rounded" href="index.html">
                                <div class="block-content text-white bg-default">
                                    <i class="si si-speedometer fa-2x"></i>
                                    <div class="font-w600 push-15-t push-15">Backend</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a class="block block-rounded" href="frontend_home.html">
                                <div class="block-content text-white bg-modern">
                                    <i class="si si-rocket fa-2x"></i>
                                    <div class="font-w600 push-15-t push-15">Frontend</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Apps Block -->
        </div>
    </div>
</div>
<!-- END Apps Modal -->

<!-- 模态框（Modal） -->
<div class="modal fade" id="password_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">密碼修改</h4>
            </div>
            <div class="modal-body">
                <form id="password_form" action="<?php echo base_url('back/Admin/password_change')?>" autocomplete="off" method="post" onsubmit="return false;">
                    <div class="form-group">
                        <label for="example-nf-email">請輸入密碼</label>
                        <input class="form-control passedit" name="password" type="text" id="example-nf-email" name="password" placeholder="原密碼">
                    </div>
                    <div class="form-group">
                        <label for="example-nf-password">請輸入新密碼</label>
                        <input class="form-control passedit" type="password" name="password_new" id="password_new" onkeyup="value=value.replace(/[^0-9a-z]/g,'');" placeholder="限小寫英文或數字，6個字元以上">
                    </div>
                    <div class="form-group">
                        <label for="example-nf-password">請再次輸入新密碼</label>
                        <input class="form-control passedit" type="password" name="password_new_again" onkeyup="value=value.replace(/[^0-9a-z]/g,'');" placeholder="限小寫英文或數字，6個字元以上">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-primary" onclick="$('#password_form').submit();">確定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<input type="text" style="display:none;" id="tabel_history">
<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/jquery-ui-1.10.4.min.js"></script>
<script src="assets/js/core/jquery.slimscroll.min.js"></script>
<script src="assets/js/core/jquery.scrollLock.min.js"></script>

<script src="assets/js/core/jquery.appear.min.js"></script>
<script src="assets/js/core/jquery.countTo.min.js"></script>
<script src="assets/js/core/jquery.placeholder.min.js"></script>
<script src="assets/js/core/js.cookie.min.js"></script>
<script src="assets/plugins/slick/slick.min.js"></script>
<script src="assets/plugins/chartjs/Chart.min.js"></script>
<script src="assets/js/app.js"></script>

<script src="assets/plugins/jquery.form/jquery.form.min.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/plugins/jquery-validation/localization/messages_zh_TW.min.js"></script>
<script src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>
<script src="assets/js/ajaxSendLoad.js"></script>
<script src="assets/js/function_ajax.js"></script>
<script src="assets/js/serializeJson.js"></script>
<script src="assets/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="assets/plugins/bootstrap-table/locale/bootstrap-table-zh-TW.js"></script>
<script src="assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="assets/plugins/daterangepicker/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/js/date-helper.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/humane.js"></script>
<script src="assets/plugins/bootstrap-select/bootstrap-select.js"></script>
<script src="assets/plugins/bootstrap-select/defaults-zh_TW.js"></script>
<!-- Page JS Code -->
<script src="assets/plugins/simditor/module.js"></script>
<script src="assets/plugins/simditor/hotkeys.js"></script>
<script src="assets/plugins/simditor/uploader.js"></script>
<script src="assets/plugins/simditor/simditor.js"></script>


<script>
    $(function () {
        // Init page helpers (Slick Slider plugin)
        App.initHelpers('slick');
        $("#cancel_edit").click(function(){
            window.history.go(-1);
        });

        var num = $("#tabel_history").val();
        if (num && num > 0) {
            if ($('#table-javascript')) {
                $('#table-javascript').bootstrapTable('refreshOptions', { pageNumber: parseInt(num) });
                //$('#table-javascript').bootstrapTable('selectPage',parseInt(xx));
            }
        }


        $("#password_form").validate({
            errorClass: "jq-validate-textcolor-red",
            wrapper:"span",
            rules: {
                password: {
                    required: true
                },
                password_new: {
                    required: true,
                    minlength: 5,
                    maxlength:30
                },
                password_new_again: {
                    required: true,
                    minlength: 5,
                    maxlength:30,
                    equalTo: "#password_new"
                }
            },
            messages: {
                password: {
                    required: "請輸入原密碼"
                },
                password_new: {
                    required: "請輸入新密碼",
                    minlength: "請輸入5-30個字元英文或數字"
                },
                password_new_again: {
                    required: "請再次輸入新密碼",
                    minlength: "請輸入5-30個字元英文或數字",
                    equalTo: "兩次密碼輸入不一致"
                }
            }
        });
        var options_password_form = {
            target: '',   // target element(s) to be updated with server response
            dataType: 'JSON',
            beforeSubmit: showRequest_password_form,  // pre-submit callback
            success: showResponse_password_form,  // post-submit callback
            error: showError_password_form
        };

        $('#password_form').ajaxForm(options_password_form);
    });

    function showRequest_password_form(formData, jqForm, options) {

    }

    // post-submit callback
    function showResponse_password_form(jsonData, statusText, xhr, $form) {
        /*alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
            '\n\nThe output div should have already been updated with the responseText.');*/
        switch (jsonData.Statu) {
            case "ok":
                if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                    //$.alertMsg(data.Msg, "系统提示", function () { funcSuc(data); });
                    sweetAlert({
                        title:jsonData.Msg,
                        text:'等待跳轉',
                        timer:2000,
                        showConfirmButton:false
                    });
                    if (jsonData.BackUrl && $.trim(jsonData.BackUrl) != "") {
                        if (window.top) { window.top.location = jsonData.BackUrl; } else {
                            window.location = jsonData.BackUrl;
                        }
                    } else {

                    }
                }
                $('#password_modal').modal('hide');
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
    }

    function showError_password_form() {
        sweetAlert({
            title: "系統忙碌中，請您稍後重新重試。",
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
    // Toggle Scroll to Top button
    $(window).scroll(function(){

        var position = $(window).scrollTop();

        if(position >= 200)	{
            $('.scroll-to-top').addClass('active')
        }
        else	{
            $('.scroll-to-top').removeClass('active')
        }
    });
    //Scroll to Top
    $(".scroll-to-top").click(function()	{
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
</script>