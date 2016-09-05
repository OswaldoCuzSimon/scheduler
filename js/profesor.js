$(function(){

	String.prototype.allReplace = function(obj) {
		var retStr = this;
		for (var x in obj) {
			retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
			//retStr = retStr.replace(x, obj[x]);
		}
		return retStr;
	};
	$("#profesor_form button[id=buscar").submit(function(event){

		event.preventDefault();
		console.log("buscar");
	});
	$("#profesor_form button[id=eliminar]").click(function(event){
		event.preventDefault();
		$("#profesor_form")[0].reset()
	});
	$("#profesor_form input[type=submit]").click(function( event ) {
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
		
		var alerta = "<div class='alert alert-#type_alert alert-dismissible' role='alert'>"+
				"<button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='cerrar()'><span aria-hidden='true'>&times;</span></button>"+
					"<strong> #type_alert! </strong>#letrero_text</div>";

		if (tabla.length <= 0) {
			var type_alert='danger';
			var letrero_text = 'No se puede agregar un profesor sin carga academica';
			$('#letrero').append(alerta.allReplace({'#type_alert':type_alert,'#letrero_text':letrero_text}) );
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
			
			var letrero_text = data.message;
			
			if(data.success==true){
				var type_alert='success';
			}else{
				var type_alert='danger';
			}
			$('#letrero').append(alerta.allReplace({'#type_alert':type_alert,'#letrero_text':letrero_text}) );
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			var type_alert='danger';
				var letrero_text = data.message;
				$('#letrero').append(alerta.allReplace({'#type_alert':type_alert,'#letrero_text':letrero_text}) );
		});

		
		
	});
});