<?php
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
}
function couples($callback,$grupos) {
	$violat=0;
	for ($c1=0; $c1 < sizeof($grupos)-1; $c1++) { 
		for ($c2=$c1+1; $c2 < sizeof($grupos); $c2++) { 
			$violat += $callback($grupos[$c1],$grupos[$c2]); //$this->traslape($grupo[$c1],$grupo[$c2]);
		}
	}
	return $violat;
}
$grupos = [1,2,3,5,6];
echo couples(function($c1,$c2){
	echo $c1." ".$c2."<br>";
	return $c1;
},$grupos);
class Restrcciones{
	private $numcursos;
	private $numprof;
	private $numdias;
	private $prefProfHoras;
	private $prefProfCursos;
	private $profUEA;
	private $grupos;
	private $BITS = 39;
	private $HORA_MAX=13;

	/**
	 *@param UEA[] $uea Arreglo de ueas
	 *@param Profesor[] $profesor Arreglo de profesores
	 *@param int -[][][] $profUEA Matrices de preferencia de los profesores
	 *
	 */
	/*public function __construct($uea,$profesor,$profUEA){
		$this->numcursos	= sizeof($uea);
		$this->numprof	= sizeof($profesor);
		$this->numdias	= sizeof($profUEA);
		$this->prefProfHoras = array();

		for ($i=0; $i < $numprof; $i++) { 
			$this->prefProfHoras[$i] = $profesor[$i]->getAvailability;
		}
		$this->prefProfCursos = $profUEA;
	}*/
	public function __construct($uea,$profesor,$profUEA){
		$this->numcursos	= $uea;
		$this->numprof	= $profesor;
		$this->numdias	= 5;
		$this->prefProfHoras = $uea;
		$this->prefProfCursos = $profesor;
		$this->grupos = [[0,1,2,3,4]];
	}
	/**
	 * @param int $number numero decimal
	 * @return int[] regresea un arreglo con $number en binario
	 *///probado
	private function intToBinaryArray($number) {return str_split(decbin($number)); }
	/**
	 * @param int [] $number arreglo binario
	 * @return intregresea un entero con $number en decimal
	 *///probado
	private function binaryArrayToInt($number) { return bindec(join($number)); }
	/**
	 * @param int[][] $horarios representacion binaria de una individuo
	 * @return int[][][][] regresa el mismo arreglo separado en multiarreglos
	 */
	public function toMultiArray($horarios){
		//probado
		$newh = array_chunk($horarios,$this->BITS);
		foreach ($newh as $c => $curso) {
			$newh[$c]=array_chunk($curso, 7);
			for ($i=0; $i < sizeof($newh[$c])-1; $i++) { 
				$newh[$c][$i]=array_chunk($newh[$c][$i],4);
			}
		}
		return $newh;
	}
	/**
	 * @param int[][] $horarios representacion binaria de una individuo en multiarreglos
	 * @return int[][][][] regresa el arreglo con representacion decimal
	 */
	public function toMultiArrayDec($horarios){
		$new= [];
		foreach ($horarios as $horario) {
			$new[] = $this->toArrayDec($horario);
		}
		return $new;
	}
	public function toArrayDec($horario){
		//probado
		for ($d=0; $d < $this->numdias; $d++) {
			$horario[$d][0]= $this->binaryArrayToInt($horario[$d][0]);
			$horario[$d][1]= $this->binaryArrayToInt($horario[$d][1]);
		}
		$horario[$this->numdias]=$this->binaryArrayToInt($horario[$this->numdias]);
		return $horario;
	}
	public function groupby($clase, $horarios){
		if ($clase == 'profesor') {
			$horario_profesor = [];
			for ($prof=0; $prof < $this->numprof; $prof++) { 
				$aux =array_filter($horarios, function($horario) use($prof){
					return($horario[$this->numdias] == $prof);
				});
				//var_dump($aux);
				if($aux != null){
					$horario_profesor[$prof] = $aux;
				}
			}
			return $horario_profesor;
		}else if($clase == 'grupo'){
			$horario_grupo = [];
			foreach ($this->grupos as $key => $grupo) {
				$aux = [];
				foreach ($grupo as $curso => $value) {
					$aux[]=$horarios[$value];
				}
				$horario_grupo[] = $aux;
			}// agrupa por grupos XD
		}
		return $horarios;
	}

		/**
	 * cacula el peso de la violacion si hay varios cursos asignados al mismo tiempo a un profesor
	 * @param int[][][] $horario_profesor El horario de un profesor
	 * @return int El peso de la violacion
	 *///3 bytes para horas, 4 para hora de inicio 5 por profesor,
	public function unCursoAlaVez($horarios){
		$horario_profesor = $this->groupby('profesor',$horarios);
		$violat = 0;

		foreach ($horario_profesor as $horario) {
			$violat += couples(function($c1,$c2){
				return $this->traslape($c1,$c2);
			},$horario);
		}
		return $violat;//var_dump($horario_profesor);
	}

	public function traslape($c1,$c2){
		$violat = 0;
		for ($dia=0; $dia < $this->numdias; $dia++) {
			if($this->HORA_MAX<=$c1[$dia][0] || $this->HORA_MAX<=$c2[$dia][0] 
				|| $c1[$dia][0]+$c1[$dia][1] >= $this->HORA_MAX
				|| $c2[$dia][0]+$c2[$dia][1] >= $this->HORA_MAX){

				//si hay horas de inicio despues de las 19:00 horas
				// si hay horas de duracion que sobrepasan las 19:00 horas
				continue;
			}
			if($c1[$dia][1]!=0 && $c2[$dia][1]!=0){
				$inter = $this->interseccion( $c1[$dia][0],$c1[$dia][0]+$c1[$dia][1], $c2[$dia][0],$c2[$dia][0]+$c2[$dia][1] ); 
				if( $inter ){
					echo sprintf("dia: %d hora: %d<br>",$dia,$inter);
					$violat += $inter;
				}
			}
		}
		return $violat;
	}
	public function interseccion($a1,$b1,$a2,$b2){
		//probado
		if( $a1>$a2){
			//se asegura que el primer intervalo comience con el numero menor
			$c  = $a1;
			$a1 = $a2;
			$a2 = $c;
			$c  = $b1;
			$b1 = $b2;
			$b2 = $c;
		}
		//echo sprintf("[$a1,$b1] [$a2,$b2]<br>");
		if( ($a1 <= $a2 && $a2 <= $b1) &&
			($a1 <= $b2 && $b2 <= $b1) ){
			return abs($b2-$a2);
		}

		return max(0,($b1-$a2) );
	}
	public function traslapeGrupo($horarios){
		$horario_grupo = $this->groupby('grupo',$horarios);
		$violat = 0;
		foreach ($horario_grupo as $grupo) {
			$violat += couples(function($c1,$c2){
				return $this->traslape($c1,$c2);
			},$grupo);
		}
		//var_dump($horario_grupo);
		return $violat;
		
	}
	public function calcularCargaHoras($horario_profesor){
		
	}
	public function preferenciaProfesores($horario_profesor){
		
	}
}
?>