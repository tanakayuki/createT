/**
 * Created by tanakayuuki on 2014/12/02.
 */

/********************
 *共通のセンター寄せに使う幅をもとめる
 *
 *********************/
    function respon_width() {
        $(window).width();
        width_wrapper = $(window).width();
        width_cont = $("#C_cont").width() + $("#L_cont").width();
        console.log(width_cont);
        console.log(width_wrapper);
        $('#wapper').css('width', width_wrapper);
        $('#content').css('width', width_cont);
    }


/********************
 *bodyの表示フェード
 *
 *********************/
function body_fade() {
    $(function () {
        $("body").css({opacity: '0'});
        setTimeout(function () {
            $("body").stop().animate({opacity: '1'}, 500);
        }, 300);
    });
}