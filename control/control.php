<?php






include '../model/modelo.php';
include 'clases.php';
include 'restricciones.php';
include 'algoritmos.php';

/*$modelo = new modelo();

$profesor = new Profesor(2,'Alarcon',3);
if(!$modelo->addProfesor($profesor,2)){
	echo "profesor no agregado<br>";
}
*/

$restric = new Restrcciones(1,16,3);
$genetic = new Genetic(0,0,0);

$indi = $genetic->generarIndividuo();

$horarios = $restric->toMultiArray($indi);
$horarios = $restric->toMultiArrayDec($horarios);
var_dump($horarios);

//echo $restric->traslapeProfesor($horarios[0],$horarios[1]);
echo $restric->traslapeGrupo($horarios);
?>