$(window).scroll(function(){

    let height = $(window).scrollTop() + $(window).height();

    if(height>800)
        $('.go_top_btn').removeClass('d_none');
    else
        $('.go_top_btn').addClass('d_none');

});

$('.go_top_btn').click(()=>{
    $("html, body").animate({scrollTop:0}, 500);
});

$('#cookie_submit_btn').click(()=>{
    $('.cookie').hide();
});

