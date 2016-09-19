<?php
include '../model/modelo.php';
include 'clases.php';

$modelo = new modelo();

$profesor = new Profesor(2,'Alarcon',3);
if(!$modelo->addProfesor($profesor,1)){
	echo "profesor no agregado";
}

?>