jQuery(document).ready(function ($) {
    // Initialize Tabs
    jQuery('[data-toggle="tabs"] a, .js-tabs a').click(function (e) {
        e.preventDefault();
        jQuery(this).tab('show');
    });
    if (hasClass(document.querySelector("div"), 'top-height')) {
        console.log(".navbar-brand .navbar");
        document.getElementsByClassName("navbar-brand")[0].style.height = "70px";
        document.getElementsByClassName("navbar-nav")[0].setAttribute('style', ' margin-top: 5px;');
        document.getElementsByClassName("navbar-toggle")[0].setAttribute('style', ' margin-top: 18px;');
        document.getElementsByClassName("navbar")[0].style.height = "70px";
    } else {
        console.log("wz");
    }
})

$(document).on('click', '.country_box .item.end .fa-angle-right', function () {
    var box = jQuery(this).parents().siblings('.items');
    var n = jQuery(this).parents().siblings('.items').children().length;
    var c = 52;
    box.css("width", 52 * n + "px");
    jQuery(this).attr("class", "fa fa-angle-left");

})
$(document).on('click', '.country_box .item.end .fa-angle-left', function () {
        jQuery(this).parents().siblings('.items').css("width", "");
        jQuery(this).attr("class", "fa fa-angle-right");

})
function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}
window.onload = function () {
   
    $("#loading").hide();
}