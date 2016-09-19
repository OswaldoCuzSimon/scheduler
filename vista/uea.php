<!doctype html>
<html lang=''>
<head>
	<meta charset='utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<script src="js/tabs.js" type="text/javascript"></script>
	<script src="js/form.js" type="text/javascript"></script>
	<script src="js/uea.js" type="text/javascript"></script>
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
				<label>Grupo:<span class="req">*</span></label><input type="text" required autocomplete="off" />
			</div>
			<div class="field-wrap">
				<label>Seriacion:<span class="req">*</span></label><input type="text" required autocomplete="off" />
			</div>
		</div>

		<div class="top-row">
			<div class="field-wrap">
				<label>Carrera:<span class="req">*</span></label>
				<div id="carreras" class="select-style select-text"><select size="1">
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
			</div>
			<div class="field-wrap">
				<label>Tipo:<span class="req">*</span></label>
				<div id="tipo" class="select-style select-text"><select size="1">
					<option value="1">Obligatoria</option>
					<option value="2">Optativa</option>
					<option value="3">Repetidores</option>
				</select></div>
			</div>
		</div>
		<div class="top-row">
			<div class="field-wrap">
				<label>Trimestre:<span class="req">*</span></label>
				<div id="trimestre" class="select-style select-text"><select size="1">
					<option value="1">Otoño</option>
					<option value="2">Invierno</option>
					<option value="3">Primavera</option>
				</select></div>
			</div>
			<div class="field-wrap">
				<label>Nivel:<span class="req">*</span></label>
				<div id="nivel" class="select-style select-num"><select size="1">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>

				</select></div>
			</div>
		</div>
		<div class="top-row">
			<div class="field-wrap">
				<label>Dias:<span class="req">*</span></label>
				<div id="dias" class="select-style select-num"><select size="1">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select></div>
			</div>
			<div class="field-wrap">
				<label>Horas:<span class="req">*</span></label>
				<div id="horas" class="select-style select-num"><select size="1">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>

				</select></div>
			</div>
		</div>
		<!--<div class="container" style="width: 100%">
			<div style="width: 100%">
			<p>Distribucion de horario:</p>-->
			<!--<table class="table">
			<table>
				<thead>
					<tr >
						<th style="width: 16%">dia 1</th>
						<th style="width: 16%">dia 2</th>
						<th style="width: 16%">dia 3</th>
						<th style="width: 16%">dia 4</th>
						<th>dia 5</th>
						<th style="width: 20%">horas</th>
					</tr>
				</thead>
				<tbody>
					<tr >
						<td><input type="number" min="0" style="width: 100%"/></td>
						<td><input type="number" min="0" class="form-control select-num" autocomplete="off" value="0" /></td>
						<td><input type="number" min="0" class="form-control select-num" autocomplete="off" value="0" /></td>
						<td><input type="number" min="0" class="form-control select-num" autocomplete="off" value="0" /></td>
						<td><input type="number" min="0" class="form-control select-num" autocomplete="off" value="0" /></td>
						<td id="restantes"></td>
					</tr>
				</tbody>
			</table>
		<!--	</table>
		</div>-->
		

		<div class="top-row">
			<div class="field-wrap">
				<input id="clearform" type="button" class="button button-block" value="eliminar"/>
			</div>
			<div class="field-wrap">
				<input type="button" class="button button-block" value="Agregar"/>
			</div>
		</div>
	</form>
	</div>
</body>
<script>tabSelected("#uea");</script>
<script src="js/form.js" type="text/javascript"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/forms.css">
<!--<link rel="stylesheet" href="css/forms.css">-->
<html>
