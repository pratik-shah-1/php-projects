// ACCORDION IMPLEMENTATION...
const acc_btn = $(".accordion_btn");
const acc_content = $(".accordion_content");

for (let i = 0; i < acc_btn.length; i++) {

	acc_btn[i].addEventListener("click", function() {		
		const panel = acc_content[i];
		var btn_icon;// RIGHT OR DOWN ANGLE BUTTON
		if(acc_btn[i].getElementsByTagName('img')[0]!==undefined)
			btn_icon = acc_btn[i].getElementsByTagName('img')[0];
		else
			btn_icon = acc_btn[i].getElementsByTagName('i')[0];
	
		if(panel.style.maxHeight){//close
			btn_icon.style = `transform:rotate(0deg)`
			panel.style.maxHeight = null;
		}
		else{//open
			btn_icon.style = `transform:rotate(90deg)`;
			panel.style.maxHeight = panel.scrollHeight + 'px';
		}
	});
}