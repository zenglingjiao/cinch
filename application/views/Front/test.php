<!DOCTYPE html>
<html lang="zh=TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Cinch</title>
    <link href="http://www.cch.com/assets/assets/css/style.css?1.0" rel="stylesheet">
    <script type="text/javascript" src="http://www.cch.com/assets/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.cch.com/assets/assets/js/md5.js"></script>
    <script src="http://www.cch.com/assets/assets/js/md5.js"></script>
</head>
<body>
    <div class="header">
        <img src="http://www.cch.com/assets/assets/images/logo.png" />
    </div>
    <div class="title_wrap">
        <div class="text-center title_box">
            <h2 class="index-title" id="task_name">
                <!--新春鼠來寶--><?php echo isset($res['data']['task_name']) ? $res['data']['task_name'] :'';?>
            </h2>
            <div class="index_small">
                <img src="http://www.cch.com/assets/assets/images/icon_qj.png" />
                <span id="task_date">
                    <!--2020/01/01-2020/02/28--><?php echo isset($res['data']['task_date']) ? $res['data']['task_date'] :'';?>
                </span>
            </div>
            <p id="task_pex">
                <!--新春來送禮，新的一年裡，2020，祝大家越來越瘦，越來越美--><?php echo isset($res['data']['task_pex']) ? $res['data']['task_pex'] :'';?>
            </p>
        </div>
    </div>
    <div class="main_wrap">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="m_body">
                        <img src="http://www.cch.com/assets/assets/images/icon_renzu.png" />
                        <div class="letd">組隊人數</div>
                        <div class="txt" id="task_mb">
                            <!--20--><?php echo isset($res['data']['task_mb']) ? $res['data']['task_mb'] :'';?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="m_body">
                        <img src="http://www.cch.com/assets/assets/images/icon_fs.png" />
                        <div class="letd">計分方式</div>
                        <div class="txt" id="task_score">
                            <!--體重數降低--><?php echo isset($res['data']['task_score']) ? $res['data']['task_score'] :'';?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list_wrap">
                <div class="list-item">
                    <div class="list-group-item d-flex align-items-center">
                        <img src="http://www.cch.com/assets/assets/images/icon_xz.png" class="mr-2">
                        <div class="">
                            <h4 class="list-title">目標</h4>
                            <div class="list-body" id="task_target">
                                <!--在10個月內瘦身10kg，希望著重大腿--><?php echo isset($res['data']['task_target']) ? $res['data']['task_target'] :'';?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="i-title d-flex">任務獎項</div>
            </div>


            <div class="list_wrap array_wrap" id="taskranking">

            	<?php 
            		$data=isset($res['data']['task_reward']) ? $res['data']['task_reward'] : [];
            		$arr=['','一','二','三'];
	            	foreach ($data as $key => $value) {
	            		
            	?>
            	<div class="list-item">
                    <div class="list-group-item d-flex align-items-center">
                        <span class="array mr-2"><?= $value['top']; ?></span>
                        <span class="list-name">第<?= $arr[$value['top']]; ?>名</span>
                        <span class="ml-auto txt"><?= $value['reward']; ?></span>
                    </div>
                </div>
            	<?php }?>
                <!--<div class="list-item">-->
                <!--    <div class="list-group-item d-flex align-items-center">-->
                <!--        <span class="array mr-2">1</span>-->
                <!--        <span class="list-name">第一名</span>-->
                <!--        <span class="ml-auto txt">纖奇雪花200ML*5罐</span>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="list-item">-->
                <!--    <div class="list-group-item d-flex align-items-center">-->
                <!--        <span class="array mr-2">2</span>-->
                <!--        <span class="list-name">第二名</span>-->
                <!--        <span class="ml-auto txt">瘦身魔泉*2瓶*5罐</span>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="list-item">-->
                <!--    <div class="list-group-item d-flex align-items-center">-->
                <!--        <span class="array mr-2">3</span>-->
                <!--        <span class="list-name">第三名</span>-->
                <!--        <span class="ml-auto txt">雪花*1瓶</span>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div class="list-item">-->
                <!--    <div class="list-group-item d-flex align-items-center">-->
                <!--        <span class="array mr-2">4</span>-->
                <!--        <span class="list-name">第四名</span>-->
                <!--        <span class="ml-auto txt">纖齊保重丸*1瓶</span>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
            <div class="btn btn-block btn-anniu btn-lg">加入任務</div>

        </div>
    </div>
<script>
    var share_model;
    $(function () {
        (function ($) {
            $.getUrlParam = function (name) {
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
                var r = window.location.search.substr(1).match(reg);
                if (r != null) return unescape(r[2]); return null;
            }
        })(jQuery);
		
        var partnerID = $.getUrlParam('partnerID');
        var token = $.getUrlParam('token');
        var formData = $.getUrlParam('formData');

		jQuery.support.cors = true;
        var url='http://60.250.137.141/';
		console.log(token);
        $.ajax({
            url: url+'CinchAPP/team.php',
            type: 'post',
            data:'partnerID='+partnerID+'&invoke=lcqrtask&token='+token+'&formData='+formData,
            success: function (res) {
                // 隐藏 loading
                // 只有请求成功（状态码为200）才会执行这个函数
                //console.log(res)
                $("#task_name").html("");
                $("#task_date").html("");
                $("#task_pex").html("");
                $("#task_mb").html("");
                $("#task_score").html("");
                $("#task_target").html("");
                if(res&&res.length>0){
                    share_model = JSON.parse(res);
                    if(share_model&&share_model.code=="ok"){
                        $("#task_name").html(share_model.data.task_name);
                        $("#task_date").html(share_model.data.task_date);
                        $("#task_pex").html(share_model.data.task_pex);
                        $("#task_mb").html(share_model.data.task_mb);
                        $("#task_score").html(share_model.data.task_score);
                        $("#task_target").html(share_model.data.task_target);
						share_model.data.task_reward.orEach(function (item,item_index) {
                            $("#taskranking").append('<div class="list-item">' +
                                '                    <div class="list-group-item d-flex align-items-center">' +
                                '                        <span class="array mr-2">'+item.top+'</span>' +
                                '                        <span class="list-name">第'+['','一','二','三'][parseInt(item.top)]+'名</span>' +
                                '                        <span class="ml-auto txt">'+item.reward+'</span>' +
                                '                    </div>' +
                                '                </div>')
                        })
                    }
                   // get_taskranking(partnerID,formData)
                }
            },
            error: function (xhr) {
                // 隐藏 loading
                // 只有请求不正常（状态码不为200）才会执行
                console.log('error', xhr);
            },
            complete: function (xhr) {
                // 不管是成功还是失败都是完成，都会执行这个 complete 函数
                console.log('complete', xhr)
            }
        })
    });

   

</script>
</body>
</html>
