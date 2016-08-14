<!doctype html>
<html lang=''>
<head>
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/forms.css">
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="js/tabs.js" type="text/javascript"></script>
	<title>Scheduler</title>
</head>
<body>
	<?php include 'tabs.php' ?>
	<div class="form">
	<h1>Agregar UEA</h1>
	<form action="/" method="post">
		<div class="top-row">
			<div class="field-wrap">
				<label>Clave UEA:<span class="req">*</span></label><input type="text" required autocomplete="off" />
			</div>
			<div class="field-wrap">
				<button class="button button-block"/>buscar</button>
			</div>
		</div>
		<div class="top-row">
			<div class="field-wrap">
				<label>Nombre UEA:<span class="req">*</span></label><input type="text" required autocomplete="off" />
			</div>
			<div class="field-wrap">
				<label>Cupo:<span class="req">*</span></label><input type="text"required autocomplete="off"/>
			</div>
		</div>
		<div class="top-row">
			<div class="field-wrap">
				<label>Carrera:<span class="req">*</span></label>
			</div>
		</div>
				<div id="carreras" class="select-style"><select size="1">
					<option value= "1">Diseño</option>
					<option value= "2">Ciencias de la Comunicación</option>
					<option value= "3">Tecnologias y Sistemas de Información</option>
					<option value= "4">Administración</option>
					<option value= "5">Derecho</option>
					<option value= "6">Estudios Socioterritoriales</option>
					<option value= "7">Humanidades</option>
					<option value= "8">Biologia Molecular</option>
					<option value= "9">Ingenieria Biologica</option>
					<option value="10">Ingenieria en Computacion</option>
					<option value="11">Matematicas Aplicadas</option>
				</select></div><br>
		<div class="top-row">
			<div class="field-wrap">
				<label>Grupo:<span class="req">*</span></label><input type="text" required autocomplete="off" />
			</div>
			<div class="field-wrap">
				<label>Seriacion:<span class="req">*</span></label><input type="text" required autocomplete="off" />
			</div>
		</div>
		<div class="top-row">
			<div class="field-wrap">
				<input type="button" class="button button-block" value="eliminar"/>
			</div>
			<div class="field-wrap">
				<input type="button" class="button button-block" value="Agregar"/>
			</div>
		</div>
		<div class="top-row">
				<label>Dias que se impartira el curso:<span class="req">*</span></label>
		</div>
		<div class="select-style"><select size="1">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select></div>
			
	</form>
	</div>
</body>
<script>
tabSelected("#uea");
</script>
<html>
