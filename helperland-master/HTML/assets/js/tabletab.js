const table_tab_btn = $('.table_tab_btn');
const table_tab_content = $('.table_tab_content');

for(let i=0; i<table_tab_btn.length; i++){
    table_tab_btn[i].addEventListener('click', ()=>{
        $('.table_tab_btn').removeClass('active_table_tab');
        $('.table_tab_content').addClass('d_none');
        if(i!==0){
            table_tab_btn[i].classList.add('active_table_tab');
        }
        table_tab_content[i].classList.remove('d_none');
    });
}