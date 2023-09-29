// ------------------HORIZONTAL NAVTABS [FAQs, Profile, Book_Service]--------------------------
const tab_btn = $('.tab_btn');
const tab_content = $('.tab_content');
const faq_tabs = $('.faq_tabs');
const book_service_tabs = $('.book_service_tabs');
var faq_tab, book_service_tab;

if(faq_tabs.length){
	faq_tab = $('.faq_tabs').children();
}

if(book_service_tabs.length){
	book_service_tab = $('.book_service_tabs').children();
}

for(let i=0; i<tab_btn.length; i++){
	tab_btn[i].addEventListener('click', ()=>{
		$('.tab_content').addClass('d_none');
		tab_content[i].classList.remove('d_none');

		$('.tab_btn').removeClass('active_faq_tab active_profile_tab active_book_service_tab');
		if(faq_tab!==undefined)
			tab_btn[i].classList.add('active_faq_tab');
		else if(book_service_tab!==undefined)
			tab_btn[i].classList.add('active_book_service_tab');
		else
			tab_btn[i].classList.add('active_profile_tab');
	});
}