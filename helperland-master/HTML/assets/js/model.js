// ---------------OPEN_MODEL------------------
function open_model(popup_name){
    // HIDE ALL MODELS...
    $('.model').removeClass('active_model');
    $('.popup_main').addClass('d_none');
    $('.sidenav').animate({'right':'-250px'}, 500);
    $('.admin_tab_list').animate({'left':'-272px'}, 500);

    // SELECT THE POPUP CLASS
    const popup_id = `${popup_name}_popup`;
    // FOR SHOWING MODEL AND POPUP
    $('.model').addClass('active_model');
    $(`#${popup_id}`).removeClass('d_none');
    $('.backlight_container').addClass('backlight');
    $('body').css({'overflow-y':'hidden'});

}

// ---------------CLOSE_MODEL------------------
function close_model(){
    $('.backlight_container').removeClass('backlight');
    $('.model').removeClass('active_model');
    $('.popup_main').addClass('d_none');
    if($(window).width() <= 1280){
        $('.book_service_right').addClass('d_none');
    }
    $('body').css({'overflow-y':'auto'});
}

$('.model_close_btn').click(()=>{
    close_model();
})

$('.backlight_container').click(()=>{
    close_model();
});

// --------------FOR_PAYMENT_SUMMARY-----------------
// ADD D_NONE CLASS TO BOOK_SERVICE_RIGHT...
if($(window).width() <= 1280){
    $('.book_service_right').addClass('d_none');
}

// OPEN BOOK_SERVICE_RIGHT...
$('.payment_summary_btn').click(()=>{
    $('.book_service_right').toggleClass('d_none');
    $('.backlight_container').toggleClass('backlight');
    $('body').css({'overflow':'hidden'});
});

// CLOSE INCLUDED SERVICES_POPUP...
$('.included_services_close_btn').click(()=>{
    $('.model').removeClass('active_model');
    $('#included_services_popup').addClass('d_none');
    if($(window).width() >= 1280){
        $('.backlight_container').removeClass('backlight');
        $('body').css({'overflow-y':'auto'});
    }
});

// --------------ADDRESS FORM TOGGLE-----------------
function address_form_toggle(){
    $('.address_form').toggleClass('d_none');
    $('#open_address_form_btn').toggleClass('d_none');
}

$('#open_address_form_btn').click(()=>{
    address_form_toggle();
});

$('#close_address_form_btn').click(()=>{
    address_form_toggle();
});
