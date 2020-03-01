<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <base href="<?php  echo base_url();?>"/>
    <title><?php echo lang('message_excel_import')//excel導入?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/plugins/sweetalert/css/sweetalert.css" rel="stylesheet">
    <link href="assets/css/ajaxSendLoad.css" rel="stylesheet">
    <script src="assets/plugins/sweetalert/js/sweetalert.min.js"></script>
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/ajaxSendLoad.js"></script>
</head>

<body>
<select id="api">
    <option value="">選擇api</option>
    <option value="updata_excel_store">匯入商家</option>
</select>
<button type="button" class="btn btn-info" style="margin-right:10px;" id="upBtn" onclick="document.getElementById('fileElem').click();">選擇excel文件</button>
<input type="file" id="fileElem" name="fileElem" accept="xls/xlsx" onchange="handleFiles(this)" style="display:none;" />

</body>
<script>
    function handleFiles(obj) {
        var api=$("#api").val();
        if(api&&api.length>0)
        {
        var files = obj.files
        var formdata = new FormData();

        // if(adminID&&adminID>0)
        // {}else{
        //     var file = $("#fileElem")
        //     file.after(file.clone().val(""));
        //     file.remove();
        //     sweetAlert("請先選擇所屬管理員");
        //     return false;
        // }
        //
        formdata.append("filepath", files[0]);
        // formdata.append("adminID", adminID);

        $.ajax({
            type: 'post',
            url: "<?php echo base_url('back/Admin/')?>"+api,
            data: formdata,
            cache: false,
            contentType: false, //必须
            processData: false, //必须
            dataType: 'json',
            enctype: 'multipart/form-data',
            success: function (jsonData) {
                switch (jsonData.Statu) {
                    case "ok":
                        if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                            sweetAlert({
                                title: jsonData.Msg,
                                text: null,
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#33A0E8",
                                confirmButtonText: "確定",
                                cancelButtonText: "取消",
                                cancelButtonClass: 'btn-white btn-md waves-effect',
                                confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
                                closeOnConfirm: true,
                                closeOnCancel: false,
                                timer: 1000
                            }, function (isConfirm) {
                            });
                        }
                        //$('#table-javascript').bootstrapTable('refreshOptions',{pageNumber:1})
                        break;
                    case "err":
                        if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                            //$.alertMsg(data.Msg, "系统提示", function () { funcErr(data); });
                            sweetAlert({
                                title: jsonData.Msg,
                                text: null,
                                type: "error",
                                showCancelButton: false,
                                confirmButtonColor: "#33A0E8",
                                confirmButtonText: "確定",
                                cancelButtonText: "取消",
                                cancelButtonClass: 'btn-white btn-md waves-effect',
                                confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
                                closeOnConfirm: true,
                                closeOnCancel: false
                            }, function (isConfirm) {

                            });
                        }
                        break;
                }
                var file = $("#fileElem")
                file.after(file.clone().val(""));
                file.remove();
            },
            error: function () {
                sweetAlert({
                    title: "服務器繁忙，請稍後再試",
                    text: null,
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#33A0E8",
                    confirmButtonText: "確定",
                    cancelButtonText: "取消",
                    cancelButtonClass: 'btn-white btn-md waves-effect',
                    confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
                    closeOnConfirm: true,
                    closeOnCancel: false
                }, function (isConfirm) {

                });
                var file = $("#fileElem")
                file.after(file.clone().val(""));
                file.remove();
            }
        });}else{
            alert("請選擇api");
            var file = $("#fileElem")
            file.after(file.clone().val(""));
            file.remove();
        }
    }
</script>
</html>