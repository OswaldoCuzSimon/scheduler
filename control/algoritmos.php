<?php
include 'restricciones.php';
function array_reverse_keys($ar){
	return array_reverse(array_reverse($ar,true),false);
}
function func($e){return -$e;}
function arrayCopy( array $array ) {
	$result = array();
	foreach( $array as $key => $val ) {
		if( is_array( $val ) ) {
			$result[$key] = arrayCopy( $val );
		} elseif ( is_object( $val ) ) {
			$result[$key] = clone $val;
		} else {
			$result[$key] = $val;
		}
	}
	return $result;
}
class Genetic{
	private $poblacion;
	private $BITS;
	private $numcursos;
	private $size_pob;
	private $PROB_MUT;
	private $restric;
	private $num_repeat;

	public function __construct($BITS,$numcursos,$size_pob,$PROB_MUT,$restric){
		$this->BITS=$BITS;
		$this->numcursos=$numcursos;
		$this->size_pob = $size_pob;
		$this->$PROB_MUT = $PROB_MUT;
		$this->restric = $restric;
	}
	function fitness ($individuo){
		$horarios = $this->restric->toMultiArray($individuo);
		$horarios = $this->restric->toMultiArrayDec($horarios);
		$rank = 0;
		// hard Constraints
		$rank += $this->restric->consistencia($horarios) + $this->restric->unCursoAlaVez($horarios) +
		$this->restric->traslapeGrupo($horarios) + $this->restric->cargaAcademica($horarios) +
		$this->restric->preferenciaProfesores($horarios) + $this->restric->duracionCursos($horarios);
		$rank = 2*$rank;
		// soft Constraints
		$rank += $this->restric->preferenciaUEA($horarios);
		return $rank;
	}
	function seleccion($poblacion){
		$ranks = [];

		foreach ($poblacion as $key =>$individuo) {
			$ranks[] = $this->fitness($individuo);
			//$ranks[] = $key;
		}
		$ranks = array_map('func',$ranks);
		asort($ranks);
		$ranks = array_map('func',$ranks);
		
		$sum = array_sum($ranks);
		$prob_cross = [];
		$precision = 3;
		foreach ($ranks as $key => $rank) {
			$prob_cross[$key] = round( $ranks[$key]/$sum ,$precision );
		}
				
		$ruleta = [];
		$rulSize = 10**$precision;
		foreach ($prob_cross as $idCruso=>$p) {
			for ($i=0; $i < $p*$precision; $i++) { 
				$ruleta[] = $idCruso;
			}
		}
		if(sizeof($ruleta) > $rulSize){unset($ruleta[0]);}
		else if(sizeof($ruleta) < $rulSize){
			$el = array_pop($ruleta);
			$ruleta = array_pad($ruleta, $rulSize, $el);
		}

		$parent1 = $poblacion[$ruleta[rand(0,$rulSize)] ];
		$parent2 = $poblacion[$ruleta[rand(0,$rulSize)] ];

		return [$parent1,$parent2];
	}
	
	public function cruza($indi1, $indi2){
		$pointcross = rand(0,sizeof($indi1));

		$child1 = array_merge(array_slice($indi1,0,$pointcross),array_slice($indi2,$pointcross));
		$child2 = array_merge(array_slice($indi2,0,$pointcross),array_slice($indi1,$pointcross) );
		
		return [$child1, $child2];
	}
	function mutacion($gen1){

		for ($i=0; $i < sizeof($gen1); $i++) { 
			$prob = mt_rand() / mt_getrandmax();
			if($prob<=$this->PROB_MUT){
				$gen1[$i] = ($gen1[$i] + 1) / 2;
			}
		}
		return $gen1;
	}
	function calcula(){
		$poblacion = $this->generarPoblacion($this->size_pob);
		for ($t=0; $t < $this->num_repeat; $t++) { 
			$new_pob = [];
			//Elitismo
			$new_pob[] = $this->elitismo($poblacion);
			while( sizeof($new_pob) < $this->size_pob ) { 
				$parent= $this->seleccion($poblacion);
				$children = $this->cruza($parent[0],$parent[1]);
				$new_pob[]=$this->mutacion( $children[0] );
				$new_pob[]=$this->mutacion( $children[1] );
			}
			$poblacion = $new_pob;
		}
		return $poblacion;
	}
	function generarPoblacion($size){
		$pob = [];

		for ($i=0; $i < $size; $i++) { 
			$pob[] = $this->generarIndividuo();
		}
		return $pob;
	}
	public function generarIndividuo(){
		$array = [];
		$tam = $this->BITS*$this->numcursos;
		for ($i=0; $i < $tam; $i++) { 
			$array[] = rand(0,1);
		}
		return $array;
	}
	function elitismo($poblacion){
		foreach ($poblacion as $key => $value)
			return $value;
	}
}

$restric = new Restrcciones(5,5,0);
$genetic = new Genetic(39,5,5,0.0001,$restric);
/*$gen1 = [[[1,2,3],[4,5,6],[7,8,9]],[[10,11,12],[13,14,15],[16,17,18]],[[19,20,21],[22,23,24],[25,26,27]]];
$gen2 = [[[28,29,30],[31,32,33],[34,35,36]],[[37,38,39],[40,41,42],[43,44,45]],[[46,47,48],[49,50,51],[52,53,54]]];

$genetic->cruza($gen1,$gen2);*/

$pob = $genetic->generarPoblacion(3);
$genetic->seleccion($pob);
