const navbar = $('#home_navbar')[0];			
const logo = $('.logo')[0];

//--------------HOME PAGE > NAVBAR_SCROLL_EVENT------------------
window.onscroll = function() {
    scrollFunction()
};

function scrollFunction() {
    if(navbar!==undefined){
        if (document.documentElement.scrollTop > 50) {
            // WHEN WE GO BOTTOM...
            navbar.style.height = '64px';
            navbar.style.backgroundColor = 'rgba(82,82,82,0.8)';
            logo.style.width = '73px';
            logo.style.height = '54px';
            logo.style.paddingTop = '6px';
            logo.style.paddingBottom = '4px';
            $('.navbar_focus_btn').removeClass('transparent');
        } 
        else {
            // WHEN WE GO TOP...
            navbar.style.backgroundColor = 'transparent';
            navbar.style.height = '130px';
            logo.style.width = '175px';
            logo.style.height = '130px';
            $('.navbar_focus_btn').addClass('transparent');
        }    
    }
}
