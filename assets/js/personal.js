jQuery(document).ready(function ($) {
    // Initialize Tabs
    jQuery('[data-toggle="tabs"] a, .js-tabs a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
    });
})
$(document).on('click', '.country_box .round', function () {
    var url = "./imarts-frontend/Cuisine-View.html";
    $("#myModal").modal({
        backdrop: 'static',     // 点击空白不关闭
        keyboard: false,        // 按键盘esc也不会关闭
       // remote: url    // 从远程加载内容的地址

    });

    //setIframeHeight(document.getElementById('external-frame'));
    window.setInterval("reinitIframe()", 200);
})

function reinitIframe() {
    var iframe = document.getElementById("external-frame");
    try {
        var bHeight = iframe.contentWindow.document.body.scrollHeight;
        var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
        var height = Math.max(bHeight, dHeight);
        iframe.height = height;
        console.log(height);
    } catch (ex) { }
}
function selectAll(selectStatus) {//传入参数（全选框的选中状态）
    //根据name属性获取到单选框的input，使用each方法循环设置所有单选框的选中状态
    if (selectStatus) {
        $("input[name='check']").each(function (i, n) {
            n.checked = true;
        });
    } else {
        $("input[name='check']").each(function (i, n) {
            n.checked = false;
        });
    }
}