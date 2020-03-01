jQuery(document).ready(function ($) {
    getCanSee();
    ////»ñÈ¡ÆÁÄ»¿í¸ß
    function getCanSee() {
        W = jQuery(window).width();
        H = jQuery(window).height()-2;
        navH = jQuery('nav').height() + 20;
        pageH = H - navH;
        console.log(W);
        console.log(pageH);
        jQuery('#page-box').css('height', pageH + 'px');
    }
    jQuery(window).on('resize', function () {
        getCanSee();
    });
})