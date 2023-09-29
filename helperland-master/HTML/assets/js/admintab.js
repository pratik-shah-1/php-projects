const admin_tab_btn = $('.admin_tab_btn');
const admin_tab_content = $('.admin_tab_content');

for(let i=0; i<admin_tab_btn.length; i++){
    admin_tab_btn[i].addEventListener('click', ()=>{

        $('.admin_tab_btn').removeClass('active_admin_tab_btn');
        admin_tab_btn[i].classList.add('active_admin_tab_btn');

        $('.admin_tab_content').addClass('d_none');
        admin_tab_content[i].classList.remove('d_none');

    });
}
