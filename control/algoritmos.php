<?php
//include 'restricciones.php';
//include '../model/modelo.php';
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

	public function __construct($BITS,$numcursos,$size_pob,$PROB_MUT,$num_repeat,$restric){
		$this->BITS=$BITS;
		$this->numcursos=$numcursos;
		$this->size_pob = $size_pob;
		$this->PROB_MUT = $PROB_MUT;
		$this->restric = $restric;
		$this->num_repeat = $num_repeat;
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
	private function reverseKeys($ranks,$prob_cross){
		//echo "prob_cross: <br>";
		//var_dump($prob_cross);
		$mayor = array_keys($ranks);
		$menor = array_reverse(array_keys($ranks) );
		$aux = [];
		for ($i=0; $i < sizeof($menor); $i++) { 
			$aux[$menor[$i] ] = $prob_cross[$mayor[$i] ];
		}
		//echo "prob_cross: <br>";
		//var_dump($aux);
		return $aux;
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
		$prob_cross = $this->reverseKeys($ranks,$prob_cross);
		$ruleta = [];
		$rulSize = 10**$precision;
		foreach ($prob_cross as $idCruso=>$p) {
			for ($i=0; $i < $p*$rulSize; $i++) { 
				$ruleta[] = $idCruso;
			}
		}
		if(sizeof($ruleta) > $rulSize){unset($ruleta[0]);}
		else if(sizeof($ruleta) < $rulSize){
			$el = array_pop($ruleta);
			$ruleta = array_pad($ruleta, $rulSize, $el);
		}
		//echo "ruleta size: ".sizeof($ruleta)."<br>";
		//echo "<br>ruleta:";var_dump(array_count_values($ruleta) );
		//var_dump($poblacion);
		$parent1 = $poblacion[$ruleta[rand(0,$rulSize-1)] ];
		$parent2 = $poblacion[$ruleta[rand(0,$rulSize-1)] ];

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
			$ranks = [];
			foreach ($poblacion as $key =>$individuo) {
				$ranks[] = $this->fitness($individuo);
				//$ranks[] = $key;
			}
			//echo "<br>pob ini ranks:<br>";
			//var_dump($ranks);
			$new_pob[] = $this->elitismo($poblacion);
			//echo "elitismo:<br>";echo $this->fitness($new_pob[0])."<br>";
			//echo "Genetic::calcula<br>".sizeof($new_pob) < $this->size_pob;
			while( sizeof($new_pob) < $this->size_pob ) { 
				$parent= $this->seleccion($poblacion);
				//echo "<br>padres:<br>".$this->fitness($parent[0] )." ".$this->fitness($parent[1])."<br>";
				$children = $this->cruza($parent[0],$parent[1]);
				$new_pob[]=$this->truncate($this->mutacion( $children[0] ) );
				$new_pob[]=$this->truncate($this->mutacion( $children[1] ) );
				//echo "generarPoblacion<br>";
			}
			$poblacion = $new_pob;
			//echo "iteracion: $t<br>";
		}
		$ranks = [];

		foreach ($poblacion as $key =>$individuo) {
			$ranks[] = $this->fitness($individuo);
			//$ranks[] = $key;
		}
		return [$poblacion,$ranks];
	}
	function truncate($individuo){

		$horario = $this->restric->toMultiArray($individuo);
		$horario = $this->restric->toMultiArrayDec($horario);

		$horario = $this->restric->limpiarDuracionCursos($horario);
		$duracion = $this->restric->duracionCursos($horario);
		//duracion:echo "duracion: $duracion <br>";

		$individuo2 = $this->restric->toSimpleArray($horario);
		$individuo2 = $this->restric->toSimpleArrayBin($individuo2);
		
		return $individuo2;

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
		$ranks = [];
		foreach ($poblacion as $id => $individuo)
			$ranks[$id] = $this->fitness($individuo);
		asort($ranks);
		foreach ($ranks as $id => $rank) {
			return $poblacion[$id];
		}
	}
}
