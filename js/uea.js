$(function(){
	$("#dias").bind('change', function (e) {
		var dias = $(this).children("select").val();

		var head = "";
		for (var i = 1; i <=dias; i++) {
			head += "<th style='width: 16%''>Dia "+i+"</th>\n";
		}
		head+="<th style='width: 20%''>horas</th>";

		var body="";
		for (var i = 1; i <=dias; i++) {
			body += "<td><input type='number' min='0' class='form-control select-num' autocomplete='off' value='0' /></td>\n";
		}
		body+="<td id='restantes'>0</td>";

		$('#tablehead').html(head);
		$('#tablebody').html(body);
	});

	$("#horas").bind('change', function (e) {
		//var horas = $(this).children("select").val();

		//$('#restantes').text(horas);
	});
});