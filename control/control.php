<?php


/**
* 
*/
class Control{
	private $model;
	private $view;

	private $idx_uea=[]; //de clave temporal a original
	private $idx_profesores=[];
	private $idx_grupos = [];
	private $profesores_idx;
	private $uea_idx;//de original a temporal
	private $grupos_idx;

	private $cursos;
	private $profesores;
	private $profuea;
	private $grupos;
	private $uea;

	private $profesores_name;
	function __construct() {
		$this->modelo = new Modelo();
		//$this->view = new View();
	}
	public function regresarIndex($horarios){
		$hora = ['7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00',
		'20:00','NA'];
		$hl = sizeof($hora) -1;

		foreach ($this->profesores as $prof_id => $prof) {
			$this->profesores_name[$prof_id] = $prof->getNombre(); 
		}
		//var_dump($horarios);
		foreach ($horarios as $curso_id => &$horario) {
			for ($i=0; $i < 5; $i++) {
				//echo "curso: $curso_id i:$i hl: $hl hor: ".$horario[$i][0]." ".$horario[$i][1]."<br>";
				//print_r($horario);echo "<br>";
				$ind = min($hl,$horario[$i][0] );
				
				$horario[$i][0]=$hora[ $ind];
				$horario[$i][1]=$hora[min($hl,$ind+$horario[$i][1] ) ];
				if ($horario[$i][1]==0) {
					$horario[$i][1]='';
					$horario[$i][0]='';
				}
				
				
			}
			$nombre = $this->idx_profesores[$horario[5] ];
			$nombre = isset($this->profesores_name[ $nombre ]) ? $this->profesores_name[ $nombre ] : 'NA';
			$horario[5] = $nombre ;
		}
		for ($i=0; $i < sizeof($horarios); $i++) { 
			$value = $horarios[$i];
			unset($horarios[$i]);
			$horarios[$this->idx_cursos[$i] ] = $value;
		}
		//var_dump($horarios);
		return $horarios;
	}
	public function mapearIndex(){
		$this->idx_grupos=array_keys($this->grupos);
		for ($i=0; $i < sizeof($this->uea); $i++) { 
			$this->idx_uea[$i]=$this->uea[$i]->getClave();
		}
		for ($i=0; $i < sizeof($this->profesores); $i++) { 
			$this->idx_profesores[$i] = $this->profesores[$i]->getProfesor_id();
			$this->profesores[$i]->setProfesor_Id($i);
		}
		foreach ($this->cursos as $id_curso => $curso) {
			$this->idx_cursos[] = $curso->getClave();
		}

		$this->profesores_idx = array_flip($this->idx_profesores);
		$this->uea_idx = array_flip($this->idx_uea);//de original a temporal
		$this->grupos_idx = array_flip($this->idx_grupos);

		//var_dump($this->idx_profesores);
		//var_dump($this->profesores_idx);
		//var_dump($this->idx_uea);
		//var_dump($this->uea_idx);

		$this->profuea = array_values($this->profuea);
		$this->grupos = array_values($this->grupos);


		foreach ($this->profuea as $prof_id => &$this->ueas) {
			for ($j=0; $j < sizeof($this->ueas); $j++) { 
				$this->ueas[$j]=$this->idx_uea[ $this->ueas[$j] ];
			}
		}
		foreach ($this->grupos as $grupo_id => &$this->ueas) {
			for ($j=0; $j < sizeof($this->ueas); $j++) { 
				$this->ueas[$j]=$this->idx_uea[ $this->ueas[$j] ];
			}
		}
		for ($i=0; $i < sizeof($this->cursos); $i++) { 
			$this->cursos[$i]->setClave( $this->idx_uea[ $this->cursos[$i]->getClave() ] );
		}
	}
	function solucionarGenetic(){
		$this->cursos = $this->modelo->getCursos(1);
		$this->profesores = array_values($this->modelo->getProfesores(1) );
		$this->profuea = $this->modelo->getProfesorUEA(1);
		$this->grupos = $this->modelo->getGrupos(1);
		$this->uea    = $this->modelo->getUEA(1);

		/*** REINDEXAR ***/
		//$this->mapearIndex();

		$restric = new Restrcciones($this->cursos,$this->profesores,$this->profuea,$this->grupos);

		$genetic = new Genetic(39,sizeof($this->cursos),10,0.1,20,$restric);
		$result = $genetic->calcula();
		//echo "Control::solucionarGenetic <br>";
		$poblacion = $result[0];
		$ranks = $result[1];
		//var_dump($poblacion);
		
		//var_dump($horarios);
		
		$horarios = $this->bestSolution($poblacion,$ranks);
		$horarios = $restric->toMultiArray($poblacion[0]);
		$horarios = $restric->toMultiArrayDec($horarios);
		//$horarios = $this->regresarIndex($horarios);
		return $horarios;
	}
	public function bestSolution($poblacion,$ranks){
		//var_dump($ranks);
		asort($ranks);
		var_dump($ranks);
		foreach ($ranks as $id => $rank) {
			return $poblacion[$id];
		}
	}
	public function printHorario($horario){
		
		$cursos = array_values( $this->modelo->getCursos(1) );
		$profesores = array_values( $this->modelo->getProfesores(1) );
		$head = "<tr class='days'><th>Nombre del curso</th><th>Nombre del profesor</th> <th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th><th>Duracion</th></tr>\n";
		$body = "";
		//var_dump($horario);
		
		foreach ($horario as $idcurso => $curso) {
			$lu=$this->indexToHora($curso[0][0],$curso[0][1]);
			$ma=$this->indexToHora($curso[1][0],$curso[1][1]);
			$mi=$this->indexToHora($curso[2][0],$curso[2][1]);
			$ju=$this->indexToHora($curso[3][0],$curso[3][1]);
			$vi=$this->indexToHora($curso[4][0],$curso[4][1]);
			$row =  sprintf("<tr>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				</tr>",
				$cursos[$idcurso]->getNombre(),
				$profesores[$curso[5] ]->getNombre(),
				$lu,$ma,$mi,$ju,$vi,$cursos[$idcurso]->getHorasSemana() );
			$body .= $row; 
			
		}
		
		//echo $row;
		return "<table style='width:100%'>".$head.$body."</table>";
	}
	public function indexToHora($ini, $dur){
		$hora = ['7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00',
		'20:00','NA'];
		if($dur==0){
			return "-";
		}
		$limit = sizeof($hora)-1;
		$ini = min($limit,$ini);
		$dur = min($limit,$ini+$dur);

		$ini = $hora[$ini];
		$dur = $hora[$dur];
		return "$ini-$dur";
	}
	public function prueba(){
		$this->cursos = $this->modelo->getCursos(1);
		$this->profesores = $this->modelo->getProfesores(1);
		$this->profuea = $this->modelo->getProfesorUEA(1);
		$this->grupos = $this->modelo->getGrupos(1);
		$this->uea    = $this->modelo->getUEA(1);

		/*** REINDEXAR ***/
		$this->mapearIndex();
	
		$restric = new Restrcciones($this->cursos,$this->profesores,$this->profuea,$this->grupos);

		$genetic = new Genetic(39,sizeof($this->cursos),100,0.1,10000,$restric);
		$individuo=$genetic->generarIndividuo();

		$horario = $restric->toMultiArray($individuo);
		$horario = $restric->toMultiArrayDec($horario);

		$individuo2 = $restric->toSimpleArray($horario);
		$individuo2 = $restric->toSimpleArrayBin($individuo2);

		$resultado = array_diff($individuo, $individuo2);

		print_r($resultado);
	}
}
?>