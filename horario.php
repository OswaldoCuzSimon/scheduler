<!doctype html>
<html lang='es'>
<head>
	<meta charset='utf-8'>
	<!--<link rel="stylesheet" href="css/table.css">
	<link rel="stylesheet" href="css/forms.css">-->
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script src="js/tabs.js" type="text/javascript"></script>
	<title>Scheduler</title>
</head>
<body>
<?php
	include '/control/control.php';
	include '/control/clases.php';
	include '/control/restricciones.php';
	include '/model/modelo.php';
	include '/control/algoritmos.php';
	$control = new Control();

	$table = $control->printHorario($control->solucionarGenetic());
	echo $table;

	//$control->prueba();
?>
</body>
</html>