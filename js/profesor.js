$(function(){
	$( "#profesor_form" ).submit(function( event ) {
		event.preventDefault();
		var seleccion = $(".cs335, .green");

		var tabla = [];
		seleccion.each(function(id,val){
			var objcell = $(val);
			var col = parseInt( objcell.attr("col") );
			var row = parseInt( objcell.parent().attr("row") );
			var iar = (row-1)*5+col-1;
			tabla[id]=iar;
			console.log(tabla[id]);
		});
		var url = "/scheduler/profesor_add.php";
		var id = $('#id').val();
		var nombre = $("#nombre").val();
		var cargaAcademica = $('#cargaAcademica').val();
		
		if (tabla.length <= 0) {
			var type_alert='danger';
				var letrero_text = 'No se puede agregar un profesor sin carga academica';
				var alerta = "<div class='alert alert-"+type_alert+" alert-dismissible' role='alert'>"+
					"<button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='cerrar()'><span aria-hidden='true'>&times;</span></button>"+
						"<strong>"+type_alert+"! </strong>"+letrero_text+"</div>";
				$('#letrero').append(alerta);
				return;
		}

		$.ajax({
			type: 	"POST",
			url: 	url,
			dataType: "json",
			data: { id		: id,
					nombre	: nombre,
					cargaAcademica : cargaAcademica,
					tablaSize : tabla.length,
					tabla	: tabla,
				},
		}).done(function( data, textStatus, jqXHR ) {
			var type_alert='success';
				var letrero_text = data.message;
				var alerta = "<div class='alert alert-"+type_alert+" alert-dismissible' role='alert'>"+
					"<button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='cerrar()'><span aria-hidden='true'>&times;</span></button>"+
						"<strong>"+type_alert+"! </strong>"+letrero_text+"</div>";
				$('#letrero').append(alerta);
		})
		.fail(function( jqXHR, textStatus, errorThrown ) {
			var type_alert='danger';
				var letrero_text = data.message;
				var alerta = "<div class='alert alert-"+type_alert+" alert-dismissible' role='alert'>"+
					"<button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='cerrar()'><span aria-hidden='true'>&times;</span></button>"+
						"<strong>"+type_alert+"! </strong>"+letrero_text+"</div>";
				$('#letrero').append(alerta);
		});

		
		
	});
});