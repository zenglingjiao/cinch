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
        backdrop: 'static',     // ����հײ��ر�
        keyboard: false,        // ������escҲ����ر�
       // remote: url    // ��Զ�̼������ݵĵ�ַ

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
function selectAll(selectStatus) {//���������ȫѡ���ѡ��״̬��
    //����name���Ի�ȡ����ѡ���input��ʹ��each����ѭ���������е�ѡ���ѡ��״̬
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