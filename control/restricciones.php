<?php
function couples($callback,$grupos) {
	$violat=0;
	$grupos = array_values($grupos);
	for ($c1=0; $c1 < sizeof($grupos)-1; $c1++) { 
		for ($c2=$c1+1; $c2 < sizeof($grupos); $c2++) { 
			$violat += $callback($grupos[$c1],$grupos[$c2]); //$this->traslape($grupo[$c1],$grupo[$c2]);
		}
	}
	return $violat;
}
function array_unchunk($array){
    return call_User_Func_Array('array_Merge',$array);
}
class Restrcciones{
	private $numcursos;
	private $numprof;
	private $numdias;
	private $prefProfUEA;
	private $prefProfHoras;
	private $grupos;
	private $ueaCursos;
	private $duracion;
	private $BITS = 39;
	private $HORA_MAX=13;
	/**
	 *@param UEA[] $cursos Arreglo de ueas
	 *@param Profesor[] $profesor Arreglo de profesores
	 *@param int -[][][] $profUEA Matrices de preferencia de los profesores
	 *@param int [][] $grupo arreglo que indica los grupos
	 */
	public function __construct($cursos,$profesores,$profUEA,$grupos){
		/*
		 *prefProfUEA arreglo bidimensional de tamaño numprof
		 * prefProfHoras arreglo de tamaño numprof, cada entra es una matriz HORA_MAX*numdias 
		 * grupos arreglo de tamaño numero de grupos
		 * duracion arreglo de tamaño numcursos indica la duracion semanal del curso
		 */
		$this->numcursos	= sizeof($cursos);
		$this->numprof	= sizeof($profesores);
		$this->numdias	= 5;
		$this->prefProfUEA = $profUEA;
		$this->prefProfHoras = [];
		$this->grupos = $grupos;
		$this->ueaCursos = [];
		$this->duracion = [];
		foreach ($cursos as $id_curso => $curso) {
			$this->duracion[] = $curso->getHorasSemana();
			$this->ueaCursos[] = $curso->getClave();
		}
		foreach ($profesores as $profesor_id => $profesor) {
			$this->prefProfHoras[] = $profesor->getAvailability();
		}
	}
	/**
	 * @param int $number numero decimal
	 * @return int[] regresea un arreglo con $number en binario
	 *///probado
	public function intToBinaryArray($number,$size) {
		$binStr = str_split(sprintf( "%0".$size."d",decbin($number) ) ); 
		foreach ($binStr as $key => &$value) {
			$value = intval($value);
		}
		return  $binStr;
	}
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
	/**
	 * convierte un curso con representacion binario a un arreglo con representacion decimal
	 * @param int[][][] $curso curso en representacion binaria
	 * @return int[][] curso en representacion decimal
	 */
	public function toArrayDec($curso){
		//probado
		for ($d=0; $d < $this->numdias; $d++) {
			$curso[$d][0]= $this->binaryArrayToInt($curso[$d][0]);
			$curso[$d][1]= $this->binaryArrayToInt($curso[$d][1]);
		}
		$curso[$this->numdias]=$this->binaryArrayToInt($curso[$this->numdias]);
		return $curso;
	}
	/**
	 * convierte un curso con representacion binario a un arreglo con representacion decimal
	 * @param int[][][] $curso curso en representacion binaria
	 * @return int[][] curso en representacion decimal
	 */
	public function toSimpleArray($horarios){
		//probado
		
		$newh = array_unchunk($horarios);
		foreach ($newh as $key => &$value) {
			$value = is_array($value)? $value : [$value];
		}
		$newh = array_unchunk($newh);
		return $newh;
	}
	/**
	 * convierte un array de cursos con representacion binario a un arreglo con representacion decimal
	 * @param int[][][] $curso curso en representacion binaria
	 * @return int[][] curso en representacion decimal
	 */
	public function toSimpleArrayBin($individuo){
		$sizes = [4,3,4,3,4,3,4,3,4,3,4];
		foreach ($individuo as $key => &$value) {
			$value = $this->intToBinaryArray($value,$sizes[$key%sizeof($sizes)]);
		}
		return array_unchunk($individuo);
	}
	public function withStrKey($horario){
		$copy = [];
		$dias = ['lu','ma','mi','ju','vi'];

		for ($d=0; $d < $this->numdias; $d++) {
			$copy[$dias[$i]]['ini'] = $horario[$d][0];
			$copy[$dias[$i]]['duraci'] = $horario[$d][1];
		}
		$copy['prof'] = $horario[$this->numdias];
		return $copy;
	}
	public function groupby($clase, $horarios){
		if ($clase == 'profesor') {
			$horario_profesor = [];
			//for ($prof=0; $prof < $this->numprof; $prof++) {
			for ($prof=0; $prof < 16; $prof++) { 
				$aux =array_filter($horarios, function($horario) use($prof){
					return($horario[$this->numdias] == $prof);
				});
				if($aux != null  && sizeof($aux)>1 ){
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
			return $horario_grupo;
		}
		return $horarios;
	}
	public function horarioToMatriz($cursos_profesor){
		$horario = [];
		for ($dia=0; $dia < $this->numdias; $dia++) { 
			for ($hora=0; $hora < $this->HORA_MAX; $hora++) { 
				$horario[$hora][$dia]=0;
			}
		}
		foreach ($cursos_profesor as $curso) {
			for ($dia=0; $dia < $this->numdias; $dia++) { 
				for ($i=$curso[$dia][0]; $i < $curso[$dia][0]+$curso[$dia][1]; $i++) { 
					$horario[$i][$dia] = 1;
				}
			}
		}
		return $horario;
	}
	public function print_horario($horario){
		echo "l m m j v<br>";
		//$horas = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00',
		//'13:00', '14:00', '15:00','16:00','17:00','18:00','19:00'];


		for ($hora=0; $hora < $this->HORA_MAX; $hora++) {
			$row = "";//$horas[$hora].' ';
			for ($dia=0; $dia < $this->numdias; $dia++) { 
				$row .= $horario[$hora][$dia].' ';
			}
			echo $row."<br>";
		}
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
		if( ($a1 <= $a2 && $a2 <= $b1) &&
			($a1 <= $b2 && $b2 <= $b1) ){
			return abs($b2-$a2);
		}

		return max(0,($b1-$a2) );
	}
	public function consistencia($horarios){
		$violat = 0;
		foreach ($horarios as $prof=>$curso){
			if($curso[$this->numdias]>$this->numprof)
				$violat++;
			for ($dia=0; $dia < $this->numdias; $dia++) {
				if($curso[$dia][1]!=0 && ($curso[$dia][0]+$curso[$dia][1] >= $this->HORA_MAX) ){
					$violat+=abs($curso[$dia][0]+$curso[$dia][1] - $this->HORA_MAX) ;
				}
			}
		}
		return $violat;
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
		return $violat;
	}
	public function traslapeGrupo($horarios){
		$horario_grupo = $this->groupby('grupo',$horarios);
		$violat = 0;
		foreach ($horario_grupo as $grupo) {
			$violat += couples(function($c1,$c2){
				return $this->traslape($c1,$c2);
			},$grupo);
		}
		return $violat;
		
	}
	public function cargaAcademica($horarios){
		$horario_profesores = $this->groupby('profesor',$horarios);
		$violat = 0;
		foreach ($horario_profesores as $prof => $cursos_profesor) {
			$carga = $this->calcularCargaHoras($cursos_profesor);//se calcula las horas que imparte clase a la semana
			if($carga==0)
				$violat += 1;
		}
		// cacula la diferencia para saber si un profesor se quedo sin asignar curso
		return $violat;
		$violat = $numprof - sizeof($horario_profesores); 
	}
	public function calcularCargaHoras($cursos_profesor){
		$carga = 0;
		foreach ($cursos_profesor as $curso) {
			for ($dia=0; $dia < $this->numdias; $dia++) { 
				$carga += $curso[$dia][1];
			}
		}
		
		return $carga;
	}
	public function preferenciaProfesores($horarios){
		$horario_profesores = $this->groupby('profesor',$horarios);
		$violat = 0;
		foreach ($horario_profesores as $prof =>$cursos_profesor) {
			$horario_prof = $this->horarioToMatriz($cursos_profesor);
			//$this->print_horario($horario_prof);
			for ($hora=0; $hora < $this->HORA_MAX; $hora++) {
				for ($dia=0; $dia < $this->numdias; $dia++) {
					if(!array_key_exists($prof,$this->prefProfHoras) || 
						!array_key_exists($hora,$this->prefProfHoras[$prof]) || 
						!array_key_exists($dia,$this->prefProfHoras[$prof][$hora]) ){
						continue;
					}
					$wants = $this->prefProfHoras[$prof][$hora][$dia];
					if($wants==0 && $horario_prof[$hora][$dia]==1){
						$violat += 1;
					}
				}
			}
		}
		return $violat;
	}
	public function duracionCursos($horarios){
		$violat = 0;
		foreach ($horarios as $key => $curso) {
			$duracion = $this->duracionCurso($curso);
			$violat += $duracion == $this->duracion[$key] ? 0:abs($duracion - $this->duracion[$key]);
			//echo "duracion: ".$this->duracion[$key]." dif: ".abs($duracion - $this->duracion[$key])."<br>";
		}
		return $violat;
	}
	public function preferenciaUEA($horarios){
		$violat = 0;
		//var_dump($ueaCursos);
		foreach ($horarios as $id_curso => $curso) {
			$prof_id = $curso[$this->numdias];
			if(array_key_exists($prof_id,$this->prefProfUEA) ){
				$prefprofesor = $this->prefProfUEA[$prof_id];
				if(!in_array($this->ueaCursos[$id_curso],$prefprofesor) ){
					$violat++;
				}
			}
		}
		return $violat;
	}
	public function duracionCurso($curso){
		$duracion = 0;
		for ($dia=0; $dia < $this->numdias; $dia++) { 
			$duracion += $curso[$dia][1];
		}
		return $duracion;
	}
	public function limpiarDuracionCursos($horarios){
		$violat = 0;
		foreach ($horarios as $key => &$curso) {
			$duracion = $this->duracionCurso($curso);
			if(  $duracion < $this->duracion[$key] ) {
				$dia=0;
				while ( $duracion < $this->duracion[$key] ){
					$curso[$dia][1]=$curso[$dia][1]+1;
					$dia = ($dia+1)%$this->numdias;
					$duracion = $this->duracionCurso($curso);

				}
			}else if($duracion > $this->duracion[$key] ){
				$dia=0;
				while ( $duracion > $this->duracion[$key] ){
					$curso[$dia][1]=max($curso[$dia][1]-1,0);
					$dia = ($dia+1)%$this->numdias;
					$duracion = $this->duracionCurso($curso);
				}
			}
			//echo "duracion: ".$this->duracion[$key]." dif: ".abs($duracion - $this->duracion[$key])."<br>";
		}
		//echo "duracion: ".$this->duracionCursos($horarios)."<br>";
		return $horarios;
	}

}
?>