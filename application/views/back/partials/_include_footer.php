<!-- 底部 -->
<footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
    <div class="pull-right">
        WebSite<i class="fa fa-heart text-city"></i> by <a class="font-w600" href="" target="_blank">非比</a>
    </div>
    <div class="pull-left">
        當前時間：<span id="time"></span> &copy; <span class="js-year-copy"></span>
    </div>
</footer>
<!-- END 底部 -->
<a href="#" class="scroll-to-top hidden-print btn-primary"><i class="fa fa-chevron-up fa-lg"></i></a>
<script>
    function tick() {
        var today;
        today = new Date();
        var yy = today.getYear();
        if (yy < 1900) yy = yy + 1900;
        var MM = today.getMonth() + 1;
        var dd = today.getDate();

        var hh = today.getHours();
        if (hh < 10) hh = '0' + hh;
        var mm = today.getMinutes();
        if (mm < 10) mm = '0' + mm;
        //        var ss = today.getSeconds();
        //        if(ss<10) ss = '0' + ss;

        var ww = today.getDay();
        var arr = new Array(" 星期日", " 星期一", " 星期二", " 星期三", " 星期四", " 星期五", " 星期六")

        //document.getElementById("time").innerHTML =  yy + "年" + MM + "月" + dd + "日 " + hh + ":" + mm + ":" + ss + "  " +arr[ww] ;
        //window.setTimeout("tick()", 1000);
        document.getElementById("time").innerHTML = yy + "年" + MM + "月" + dd + "日 " + hh + ":" + mm + "  " + arr[ww];
        window.setTimeout("tick()", 60000);
    }
    tick();
</script>