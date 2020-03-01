function Ajax_Post_ID_msg(id, msg, url, tabelName) {
    sweetAlert({
        title: msg,
        text: null,
        type: warning,//warning error success
        showCancelButton: true,
        cancelButtonClass: 'btn-white btn-md waves-effect',
        confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
        confirmButtonText: 'OK',
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                type: 'post',
                url: url,
                cache: false,
                dataType: 'json',
                data: { "id": id },
                success: function (jsonData) {
                    Ajax_success(jsonData, tabelName)
                },
                error: Ajax_error
            });
        }

    });
}

function Ajax_Post_Select_msg(msg, url, tabelName, msg2) {
    sweetAlert({
        title: msg,
        text: null,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#33A0E8",
        confirmButtonText: "確定",
        cancelButtonText: "取消",
        cancelButtonClass: 'btn-white btn-md waves-effect',
        confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            var selectid = xianshiid(tabelName);
            if (selectid != "") {
                $.ajax({
                    type: 'post',
                    url: url,
                    cache: false,
                    dataType: 'json',
                    data: { "selectid": selectid.join(",") },
                    success: function (jsonData) {
                        Ajax_success(jsonData, tabelName);
                    },
                    error: Ajax_error
                });
            }
            else {
                sweetAlert(msg2);
            }
        } else { }
    });

}

function Ajax_Post_Select_data_msg(msg, data, url, tabelName, msg2) {
    sweetAlert({
        title: msg,
        text: null,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#33A0E8",
        confirmButtonText: "確定",
        cancelButtonText: "取消",
        cancelButtonClass: 'btn-white btn-md waves-effect',
        confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            var selectid = xianshiid(tabelName);
            if (selectid != "") {
                data["selectid"] = selectid.join(",");
                $.ajax({
                    type: 'post',
                    url: url,
                    cache: false,
                    dataType: 'json',
                    data: data,
                    success: function (jsonData) {
                        Ajax_success(jsonData, tabelName)
                    },
                    error: Ajax_error
                });
            }
            else {
                sweetAlert(msg2);
            }
        } else { }
    });

}

function Ajax_success(jsonData, tabelName) {
    switch (jsonData.Statu) {
        case "ok":
            if (jsonData.Msg && $.trim(jsonData.Msg) != "") {
                //$.alertMsg(data.Msg, "系統提示", function () { funcSuc(data); });
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
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (jsonData.BackUrl && $.trim(jsonData.BackUrl) != "") {
                        if (window.top) { window.top.location = jsonData.BackUrl; } else {
                            window.location = jsonData.BackUrl;
                        }
                    } else {

                    }
                    $('#' + tabelName + '').bootstrapTable('refresh');
                });
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
                    cancelButtonClass: 'btn-white btn-md waves-effect',
                    confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
                    closeOnConfirm: true,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (jsonData.BackUrl && $.trim(jsonData.BackUrl) != "") {
                        if (window.top) { window.top.location = jsonData.BackUrl; } else {
                            window.location = jsonData.BackUrl;
                        }
                    } else {

                    }
                });
            }
            break;
    }
}

function Ajax_error() {
    sweetAlert({
        title: "服务器繁忙，请稍后重试",
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

//获取选择id
function xianshiid(tabelName) {
    if (tabelName != "" && tabel_date.length > 3) {
    }
    else {
        tabelName = 'table-javascript';
    }
    var selects = $('#' + tabelName + '').bootstrapTable('getSelections');
    ids = $.map(selects, function (row) {
        return row.id;
    });
    return ids;
}

function WdatePicker_sTime(idname) {
    $("#" + idname + "2").val('');
    WdatePicker({});
    //WdatePicker({ minDate: '%y-%M-#{%d}' });
}
function WdatePicker_eTime(idname) {
    var stime = $("#" + idname + "1").val();
    if (stime.length > 0) {
        WdatePicker({ minDate: '#F{$dp.$D(\'' + idname + '1\',{d:+1});}' });
    } else {
        sweetAlert("请先选择开始时间");
        $("#" + idname + "2").blur();
    }
}

function tabel_date(value, row, index) {
    if (value) {
        return value.substring(0, 10);
    }
    return value;
}
function tabel_date_time(value, row, index) {
    if (value) {
        return value.substring(0, 19).replace("T", " ");
    }
    return value;
}

//获得日期加时间
function ChangeDateFormat(jsondate) {
    if (jsondate) { if (jsondate.length > 0) { } else { return ""; } } else { return ""; }
    jsondate = jsondate.replace("/Date(", "").replace(")/", "");
    if (jsondate.indexOf("+") > 0) {
        jsondate = jsondate.substring(0, jsondate.indexOf("+"));
    } else if (jsondate.indexOf("-") > 0) {
        jsondate = jsondate.substring(0, jsondate.indexOf("-"));
    }
    var date = new Date(parseInt(jsondate, 10));
    var month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;
    var currentDate = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
    var Hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
    var Minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    var Seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
    return date.getFullYear() + "-" + month + "-" + currentDate + " " + Hours + ":" + Minutes + ":" + Seconds;
}
//获得日期
function dateFromStringWithTime(str) {
    if (str == null || str == undefined) {
        return '';
    }
    var match;
    if (!(match = str.match(/\d+/))) {
        return false;
    }
    var date = new Date();
    date.setTime(match[0] - 0);
    return DateToStr(date);
}
//日期转化为字符串格式： yyyy-mm-dd
function DateToStr(dt) {
    var str = "";
    if (dt.getFullYear) {
        var y, m, d;
        y = dt.getFullYear();
        m = dt.getMonth() + 1; //1-12
        m = "" + m;
        d = "" + dt.getDate();
        if (m.length != 2) {
            m = "0" + m;
        }
        if (d.length != 2) {
            d = "0" + d;
        }
        str = "" + y + "-" + m + "-" + d;
    }
    return str;
}