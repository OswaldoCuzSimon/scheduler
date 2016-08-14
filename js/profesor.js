$(function(){
	$( "#profesor_form" ).submit(function( event ) {
		
		var seleccion = $(".cs335, .green");

		var tabla = [seleccion.length];

		seleccion.each(function(id,val){
			var objcell = $(val);
			var col = parseInt( objcell.attr("col") );
			var row = parseInt( objcell.parent().attr("row") );
			var iar = (row-1)*5+col-1;
			tabla[id]=iar;
			//console.log(tabla[id]);
		});


		event.preventDefault();
	});

});