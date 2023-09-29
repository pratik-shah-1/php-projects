function open_loader(){
    // SET LOADER
    $('.backlight_container').addClass('loader');
    $('body').css({'overflow-y':'hidden'});
}

function close_loader(){
    // CLOSE LOADER
    $('.backlight_container').removeClass('loader');
    $('body').css({'overflow-y':'auto'});
}