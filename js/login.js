$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});
$(function(){

	String.prototype.allReplace = function(obj) {
		var retStr = this;
		for (var x in obj) {
			retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
			//retStr = retStr.replace(x, obj[x]);
		}
		return retStr;
	};
	
	$("#login_form input[type=submit]").click(function( event ) {
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
		var url = "/scheduler/loginc.php";
		var email = $('#email').val();
		var password = $('#password').val();
		
		var alerta = "<div class='alert alert-#type_alert alert-dismissible' role='alert'>"+
				"<button type='button' class='close' data-dismiss='alert' aria-label='Close' onclick='cerrar()'><span aria-hidden='true'>&times;</span></button>"+
					"<strong> #type_alert! </strong>#letrero_text</div>";


		
		$.ajax({
			type: 	"POST",
			url: 	url,
			dataType: "json",
			data: { email		: email,
					password	: password,
				},
		}).done(function( data, textStatus, jqXHR ) {
			
			var letrero_text = data.message;
			
			if(data.success==true){
				window.location.href = "index.php";
				console.log("entro");
			}else{
				var type_alert='danger';
				$('#letrero').append(alerta.allReplace({'#type_alert':type_alert,'#letrero_text':letrero_text}) );
			}
			
		}).fail(function( jqXHR, textStatus, errorThrown ) {
			var type_alert='danger';
				var letrero_text = "Peticion no enviada";
				console.log(textStatus);
				$('#letrero').append(alerta.allReplace({'#type_alert':type_alert,'#letrero_text':letrero_text}) );
		});

		
		
	});
});