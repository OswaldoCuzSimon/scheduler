<!doctype html>
<html lang=''>
<head>
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/table.css">
	<link rel="stylesheet" href="css/forms.css">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="js/tabs.js" type="text/javascript"></script>
	
	<script src="js/table.js" type="text/javascript"></script>
	<script src="js/profesor.js" type="text/javascript"></script>
	<script src="js/form.js" type="text/javascript"></script>
	<title>Scheduler</title>
</head>
<body>
	<?php include 'tabs.php' ?>
	
	<div class="form">
	<h1>Agregar profesor</h1>
	<!--action="profesor_add.php"-->
	<form class="formulario" id="profesor_form" method="post">
		<div class="top-row">
			<div class="field-wrap">
				<label>Id profesor:<span class="req">*</span></label><input id="id" type="text" required autocomplete="off" />
			</div>
			<div class="field-wrap">
				<button id="buscar" class="button button-block"/>buscar</button>
			</div>
		</div>
		<div class="top-row">
			<div class="field-wrap">
				<label>Nombre profesor:<span class="req">*</span></label><input id="nombre" type="text"required autocomplete="off"/>
			</div>
		</div><br>
		<div class="top-row">
			<div class="field-wrap">
				<label>Carga academica:<span class="req">*</span></label>
			</div>
		</div>
				<div class="select-style"><select id="cargaAcademica" size="1">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select></div>
		<br>
		<div class='tab'>
		<table id="header-fixed" border='0' cellpadding='0' cellspacing='0'>
			<tr class='days'><th>Hora </th> <th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>
			<tr row= "1"><td class='time'> 7:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td></tr>
			<tr row= "2"><td class='time'> 8:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row= "3"><td class='time'> 9:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row= "4"><td class='time'>10:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row= "5"><td class='time'>11:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row= "6"><td class='time'>12:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row= "7"><td class='time'>13:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row= "8"><td class='time'>14:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row= "9"><td class='time'>15:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row="10"><td class='time'>16:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row="11"><td class='time'>17:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row="12"><td class='time'>18:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
			<tr row="13"><td class='time'>19:00</td> <td col="1"></td> <td col="2"></td> <td col="3"></td> <td col="4"></td> <td col="5"></td> </tr>
		</table>
		</div>
		<div id="letrero"></div>
		<div class="top-row">
			<div class="field-wrap">
				<button id="eliminar" class="button button-block"/>eliminar</button>
			</div>
			<div class="field-wrap">
				<input type="submit" class="button button-block" value="Agregar"/>
			</div>
		</div>
	</form>
		

	<!--
	alert-success
	alert-info
	alert-warning
	alert-danger
	-->
</div>
</body>
<script>
tabSelected("#profesor");
</script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/forms_after.js" type="text/javascript"></script>
<html>
