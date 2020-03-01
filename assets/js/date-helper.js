//daterangepicker
//bootstrap-datetimepicker
$(".datepicker-input").datetimepicker({
    minView: "month", //选择日期后，不会再跳转去选择时分秒
    language: 'zh-TW',
    format: 'yyyy-mm-dd',
    todayBtn: 1,
    autoclose: 1,
    clearBtn:true,//清除按钮
});
$(".datepicker-time-input").datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    language: 'zh-TW',
    weekStart: 1,
    todayBtn: 1,//显示‘今日’按钮
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 0,  //Number, String. 默认值：0, 'hour'，日期时间选择器所能够提供的最精确的时间选择视图。
    minuteStep: 5,
    clearBtn: true,//清除按钮
});
/**
 * 初始化日期范围选择控件
 */
function InitDateRangeControlForQueryPanel(daterangebtn, text) {
    if (text && text.length > 0) { } else { text="請選擇日期區間"}
    var $daterangebtn = $(daterangebtn);
    $daterangebtn.daterangepicker(
        {
            ranges: {
                '清空': [null, null],
                '今天': [moment(), moment().add(1, 'days')],
                '昨天': [moment(), moment().subtract(1, 'days')],
                '7天': [moment().subtract(7, 'days'), moment()],
                '30天': [moment().subtract(30, 'days'), moment()],
                '這個月': [moment().startOf('month'), moment().endOf('month')],
                '上個月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'right', //日期選擇框的彈出位置
            //buttonClasses: ['btn btn-default'],
            //applyClass: 'btn-small btn-primary blue',
            //cancelClass: 'btn-small',
            format: 'YYYY-MM-DD HH:mm:ss', //控件中from和to 顯示的日期格式
            locale: {
                applyLabel: '確定',
                cancelLabel: '取消',
                fromLabel: '起始時間',
                toLabel: '結束時間',
                customRangeLabel: '自定義',
                daysOfWeek: ['日', '壹', '二', '三', '四', '五', '六'],
                monthNames: ['壹月', '二月', '三月', '四月', '五月', '六月',
                    '七月', '八月', '九月', '十月', '十壹月', '十二月'],
                firstDay: 1
            },
            startDate: null, //startDate和endDate 的值如果跟 ranges 的兩個相同則自動選擇ranges中的行. 這裏選中了清空行
            endDate: null
        },
        function (start, end) {
            var s = start.format('YYYY-MM-DD');
            var e = end.format('YYYY-MM-DD');
            var t = s + ' 至 ' + e;

            if (start._isValid == false && end._isValid == false) {
                s = "";
                e = "";
                t = text
            }

            $daterangebtn.find('span').html(t);
            $daterangebtn
                .next().val(s)
                .next().val(e);
        }
    );
}

/**
 * 日历
 * @@param obj eles 日期输入框
 * @@param boolean dobubble    是否为双日期（true）
 * @@param boolean secondNot    有无时分秒（有则true）
 * @@return none
 **/
function calenders(eles,dobubble,secondNot){
    var singleNot,formatDate;
    if(dobubble ==true){
        singleNot = false;
    }else{
        singleNot = true;
    }
    if(secondNot ==true){
        formatDate = "YYYY-MM-DD HH:mm:ss";
    }else{
        formatDate = "YYYY-MM-DD";
    }

    $(eles).daterangepicker({
        "singleDatePicker": singleNot,
        "timePicker": secondNot,
        "timePicker24Hour": secondNot,
        "timePickerSeconds": secondNot,
        "showDropdowns":true,
        "timePickerIncrement" :1,
        "linkedCalendars": false,
        "autoApply":true,
        "autoUpdateInput":false,
        "locale": {
            "direction": "ltr",
            "format": formatDate,
            "separator": "~",
            "applyLabel": "確定",
            "cancelLabel": "取消",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "日",
                "一",
                "二",
                "三",
                "四",
                "五",
                "六"
            ],
            "monthNames": [
                "一月",
                "二月",
                "三月",
                "四月",
                "五月",
                "六月",
                "七月",
                "八月",
                "九月",
                "十月",
                "十一月",
                "十二月"
            ],
            "firstDay": 1
        }
    }, function(start,end, label) {
        if(secondNot ==true&&dobubble ==true){
            $(eles).val($.trim(start.format('YYYY-MM-DD HH:mm:ss')+'~'+end.format('YYYY-MM-DD HH:mm:ss')));
        }else if(secondNot ==false&&dobubble ==true){
            $(eles).val($.trim(start.format('YYYY-MM-DD')+'~'+ end.format('YYYY-MM-DD')));
        }else if(secondNot ==false&&dobubble ==false){
            $(eles).val(start.format('YYYY-MM-DD'));
        }else if(secondNot ==true&&dobubble ==false){
            $(eles).val(start.format('YYYY-MM-DD HH:mm:ss'));
        }
    });
    //清空
    $(eles).siblings('.clearBtns').click(function(){
        $(eles).val('');
    })
}


function calenders_edit(eles,dobubble,secondNot){
    var singleNot,formatDate;
    if(dobubble ==true){
        singleNot = false;
    }else{
        singleNot = true;
    }
    if(secondNot ==true){
        formatDate = "YYYY-MM-DD HH:mm:ss";
    }else{
        formatDate = "YYYY-MM-DD";
    }

    $(eles).daterangepicker({
        "singleDatePicker": singleNot,
        "timePicker": secondNot,
        "timePicker24Hour": secondNot,
        "timePickerSeconds": secondNot,
        "showDropdowns":true,
        "timePickerIncrement" :1,
        "linkedCalendars": false,
        "autoApply":true,
        "autoUpdateInput":false,
        "locale": {
            "direction": "ltr",
            "format": formatDate,
            "separator": "~",
            "applyLabel": "確定",
            "cancelLabel": "取消",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "日",
                "一",
                "二",
                "三",
                "四",
                "五",
                "六"
            ],
            "monthNames": [
                "一月",
                "二月",
                "三月",
                "四月",
                "五月",
                "六月",
                "七月",
                "八月",
                "九月",
                "十月",
                "十一月",
                "十二月"
            ],
            "firstDay": 1
        }
    }, function(start,end, label) {
        if(secondNot ==true&&dobubble ==true){
            //$(eles).val($.trim(start.format('YYYY-MM-DD HH:mm:ss') + '~' + end.format('YYYY-MM-DD HH:mm:ss')));
            $(eles)
                .next().val($.trim(start.format('YYYY-MM-DD HH:mm:ss')))
                .next().val($.trim(end.format('YYYY-MM-DD HH:mm:ss')));
        }else if(secondNot ==false&&dobubble ==true){
            //$(eles).val($.trim(start.format('YYYY-MM-DD')+'~'+ end.format('YYYY-MM-DD')));
            $(eles)
                .next().val($.trim(start.format('YYYY-MM-DD')))
                .next().val($.trim(end.format('YYYY-MM-DD')));
        } else if (secondNot == false && dobubble == false) {
            //$(eles).val(start.format('YYYY-MM-DD'));
            $(eles)
                .next().val($.trim(start.format('YYYY-MM-DD')))
        } else if (secondNot == true && dobubble == false) {
            //$(eles).val(start.format('YYYY-MM-DD HH:mm:ss'));
            $(eles)
                .next().val($.trim(start.format('YYYY-MM-DD HH:mm:ss')))

        }
    });
    //清空
    $(eles).siblings('.clearBtns').click(function(){
        $(eles).val('');
        $(eles).next().val('')
            .next().val('');
    })
}