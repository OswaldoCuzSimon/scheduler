<?php
function printHorario($horarios,$horas,$profesores){
	foreach ($grupo as $key => $grupo) {
		$head = "<tr class='days'><th>Nombre del curso</th><th>Nombre del profesor</th> <th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";
		foreach ($grupo as $idcurso => $curso) {
			$row = "<th>$cursos[$idcurso]</th><th>profesores[$idprofesor]</th>";
			for ($d=0; $d < 5; $d++) {

				$hora = $horas[$curso[$d][1]]==0? " ":$horas[$curso[$d][0]]." ".$horas[$curso[$d][1]];
				$row .= "<th>".$hora."</th>";
			}
		}
	}
}