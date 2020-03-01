$(document).bind("ajaxSend", function () {
    addBodyload();
}).bind("ajaxComplete", function () {
    removeBodyload();
}).bind("ajaxError", function () {
    removeBodyload();
});

function addBodyload() {
    $(document.body).append('<div id="load"><div class="spinner">' +
        '<div class="bounce1"></div>' +
        '<div class="bounce2"></div>' +
        '<div class="bounce3"></div>' +
        '</div></div>'
        );
}
function removeBodyload() {
    var obj = $("#load");
    obj.remove();
}