<?php






include '../model/modelo.php';
include 'clases.php';
include 'restricciones.php';
include 'algoritmos.php';



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

echo $horarios[0][5]."<br>".
$horarios[1][5]."<br>".
$horarios[2][5]."<br>".
$horarios[3][5]."<br>".
$horarios[4][5]."<br>";

//var_dump($horarios);
//$horario_profesores = $restric->groupby('profesor',$horarios);
//var_dump($horario_profesores[1]);
//$violat = $restric->preferenciaProfesores($horarios);
//var_dump($horarios);
echo $restric->preferenciaUEA($horarios)."<br>";
//$restric->print_horario($restric->horarioToMatriz($horario_profesores[1]) );
//$restric->print_horario($restric->horarioToMatriz($horario_profesores[2]) );
//$restric->print_horario($horario);

?>