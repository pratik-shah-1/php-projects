const dropdown_btn = $('.dropdown_btn');
const dropdown_menu = $('.dropdown_menu');

for(let i=0; i<dropdown_btn.length; i++){
    dropdown_btn[i].addEventListener('click', ()=>{
        dropdown_menu[i].classList.toggle('d_none');
        for(let j=0; j<dropdown_btn.length; j++){
            if(j!==i){
                dropdown_menu[j].classList.add('d_none');
            }
        }
    });
}

window.onclick = function(event) {
    if (!event.target.matches('.dropdown_btn')) {
        const dropdowns = $(".dropdown_menu");
        for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].classList.add('d_none');
        }
    }
}

for(let i=0; i<dropdown_btn.length; i++){
   dropdown_btn[i].addEventListener('click',function(event){
        event.stopPropagation();
    });
}
