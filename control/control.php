<?php
include 'clases.php';
include 'restricciones.php';
include '../model/modelo.php';
include 'algoritmos.php';

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
	function __construct() {
		$this->modelo = new Modelo();
		//$this->view = new View();
	}
	public function regresarIndex($horarios){
		$hora = ['7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00'];
		foreach ($horario as $curso_id => &$horario) {
			for ($i=0; $i < 5; $i++) { 
				$horario[$i]=$hora[$horario[$i][0]];
				$horario[$i]=$hora[$horario[$i][1]];
			}
			$horario[5] = $profesores[$horario[5] ];
		}
		for ($i=0; $i < sizeof($horarios); $i++) { 
			$value = $horarios[$i];
			unset($horarios[$i]);
			$horarios[$cursos[$i] ] = $value;
		}
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
		$this->profesores = $this->modelo->getProfesores(1);
		$this->profuea = $this->modelo->getProfesorUEA(1);
		$this->grupos = $this->modelo->getGrupos(1);
		$this->uea    = $this->modelo->getUEA(1);

		/*** REINDEXAR ***/
		$this->mapearIndex();
	
		$restric = new Restrcciones($this->cursos,$this->profesores,$this->profuea,$this->grupos);

		$genetic = new Genetic(39,sizeof($this->cursos),10,0.0001,100,$restric);
		$result = $genetic->calcula();

		$poblacion = $result[0];
		$ranks = $result[1];
		//var_dump($poblacion);
		$horarios = $restric->toMultiArray($poblacion[0]);
		$horarios = $restric->toMultiArrayDec($horarios);
		var_dump($horarios);
		//$this->regresarIndex($horarios);
	}
}


$control = new Control();

$control->solucionarGenetic();


?>