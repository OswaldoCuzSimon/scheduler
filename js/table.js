$(function(){
	$("td").click(function(event){
		var at = $(this).attr('class');
		console.log( $(this).parent().attr("row") +" "+ $(this).attr("col"));
		if(at=="time"){
			return;
		}else if(at==null){
			$(this).attr('class','cs335 green');
		}else{
			$(this).removeAttr( "class" );
		}
	});
});
