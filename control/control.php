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
/*
$indi = $genetic->generarIndividuo();

$horarios = $restric->toMultiArray($indi);
$horarios = $restric->toMultiArrayDec($horarios);
var_dump($horarios);

//echo $restric->traslapeProfesor($horarios[0],$horarios[1]);
echo $restric->traslapeGrupo($horarios);
*/
$indi = $genetic->generarIndividuo();

$horarios = $restric->toMultiArray($indi);
$horarios = $restric->toMultiArrayDec($horarios);

$horarios[0][5]=1;
$horarios[1][5]=1;
$horarios[2][5]=1;
$horarios[3][5]=2;
$horarios[4][5]=2;

//var_dump($horarios);
$horario_profesores = $restric->groupby('profesor',$horarios);
//var_dump($horario_profesores[1]);
$violat = $restric->preferenciaProfesores($horarios);
echo $violat."<br>";
//$restric->print_horario($restric->horarioToMatriz($horario_profesores[1]) );
//$restric->print_horario($restric->horarioToMatriz($horario_profesores[2]) );
//$restric->print_horario($horario);

?>