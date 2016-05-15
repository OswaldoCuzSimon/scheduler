function tabSelected(name){
	var tabs = $("#cssmenu ul li");
	tabs.attr("class","");
	$(name).attr("class", "active");
}
