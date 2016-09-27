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
	
	<title>Scheduler</title>
</head>
<body>
<div>
<?php include 'tabs.php' ?>
</div>

<div class="form">
	<h1>Preferencia de profesores para dictar cursos</h1>
	<form action="/" method="post">
		<!--<div class="top-row">
			<div class="field-wrap">
				<label for="sel2">profesor 1:</label>
			</div>
			<div class="field-wrap">
				<div class="form-group"><select multiple class="form-control" id="sel2" size="3">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select></div>
			</div>-->
			<?php

			$profesores = ["Abel Garcia Najera","Netz Romero","Luis Alarcon"];
			$ueas = ["Calculo II", "Taller de matematicas","Programacion estructurada","Estructura de datos","Interfaces de usuario","Base de datos","Mineria de datos"];

			$field_ueas = "<div class='field-wrap'> <div class='form-group'><select multiple class='form-control' size='3'>";
			foreach ($ueas as $key => $value) {
				$field_ueas .= sprintf("<option value='%d'>%s</option>",$key,$value);
			}
			$field_ueas .= "</select></div></div>";

			foreach ($profesores as $key => $value) {
				$field_profesor = sprintf("<div class='field-wrap'><label>%s:</label></div>",$value);
				echo "<div class='top-row'>".$field_profesor.$field_ueas."</div>";
			}
			
			?>
		
		<div class="top-row">
			<div class="field-wrap">
				<input type="button" class="button button-block" value="Agregar"/>
			</div>
		</div>
	</form>
</div>

</body>
<script>tabSelected("#profesor_uea");</script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/forms.css">
<html>
