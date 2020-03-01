



$(document).ready(function () {
    $(".fancybox").fancybox({
        openEffect: 'none',
        closeEffect: 'none'
    });



    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
        },
        speed: 1000,
        slidesPerView: 1,
        autoplay: {
            delay: 6500,
            disableOnInteraction: true,
        }
    });
});

$(document).on('click', '.onclik_auto', function () {
    $(this).parent(".p_img_wear").addClass("heightauto");
})
$(document).on('click', '.onclick_more', function () {

    if ($(this).parent(".feed-element").hasClass('p_show')) {
        $(this).parent(".feed-element").removeClass("p_show");
        $(this).parent(".feed-element").addClass("p_hide");
        $(".p_img_wear").removeClass("heightauto");
        $(this).text("全文");
    }
    else {
        $(this).parent(".feed-element").removeClass("p_hide");
        $(this).parent(".feed-element").addClass("p_show");
        $(this).text("收起");
    }
})

$(document).on('click', '.btn-open', function () {

    if ($(this).hasClass('btn-shut')) {
        $(this).removeClass("btn-shut");
        $(this).parents(".tag-zone").removeClass("tag_box");
    }
    else {
        $(this).addClass("btn-shut");
        $(this).parents(".tag-zone").addClass("tag_box");
    }

})
$(document).on('click', '.b-open', function () {

    if ($(this).hasClass('btn-shut')) {
        $(this).removeClass("btn-shut");
        $(this).parents(".BusinessHours").removeClass("showh");
    }
    else {
        $(this).addClass("btn-shut");
        $(this).parents(".BusinessHours").addClass("showh");
    }

})


window.onload = function () {
   

}