<?php

class Restrcciones{
	private $numcursos;
	private $numprof;
	private $numdias;
	private $prefProfHoras;
	private $prefProfCursos;
	private $profUEA;

	/**
	 *@param UEA[] $uea Arreglo de ueas
	 *@param Profesor[] $profesor Arreglo de profesores
	 *@param int -[][][] $profUEA Matrices de preferencia de los profesores
	 *
	 */
	public function __construct($uea,$profesor,$profUEA){
		$numcursos	= sizeof($uea);
		$numprof	= sizeof($profesor);
		$numdias	= sizeof($profUEA);
		$prefProfHoras = array();

		for ($i=0; $i < $numprof; $i++) { 
			$prefProfHoras[$i] = $profesor[$i]->getAvailability;
		}
		$prefProfCursos = $profUEA;
	}
	/**
	 * cacula el peso de la violacion si hay varios cursos asignados al mismo tiempo a un profesor
	 * @param int[][][] $horario_profesor El horario de un profesor
	 * @return int El peso de la violacion
	 */
	public function unCursoAlaVez($horario_profesor){
		$count_violat = 0;

		for ($h=0; $h < $horas; $h++) { 
			for ($d=0; $d < $dias; $d++) {
				$count_aux = 0;
				for ($c=0; $c < $cursos; $c++) { 
					$count_aux += $horario_profesor[$c][$h][$d]; 
				}
				$count_violat += max(0,$count_aux-1); //se resta un menos uno porque cuando solo hay un curso asignado decimos que no hay una violacion

			}
		}
		return $count_violat;
	}

	public function traslapeGrupo($horario_profesor){
		$count_trasl=0;

		foreach ($grupos as $g) {
			for ($c1=0; $c1 < sizeof($g); $c1++) { 
				for ($c2=$c1+1; $c2 < sizeof($g)-1; $c2++) { 
					foreach ($horario_profesor as $ti => $t) {
						$count_aux = 0;
						for ($h=0; $h < $horas; $h++) { 
							for ($d=0; $d < $dias; $d++) { 
								if ($t[$c1][$h][$d] == $t[$c2][$h][$d] && $t[$c1][$h][$d]==1){
									$count_aux += 1;
								}
							}
						}
						$count_trasl += $count_aux;
					}
				}
			}
		}
		return $count_trasl;
	}
	public function cargaAcademica($horario_profesor){
		$count_violat=0;

		for ($t=0; $t < sizeof($horario_profesor); $t++) { 
			$horas = calcularCargaHoras($t);
			$ueas = calcularCargaUeas($t);
			$count_violat +=abs($horas-$horas_profesor[$t])+abs($ueas-$ueas_profesor[$t]);
		}
		return $count_violat;
	}
	public function calcularCargaUeas($horario_profesor){
		$count_violat = 0;
		for ($h=0; $h < $horas; $h++) { 
			for ($d=0; $d < $dias; $d++) {
				$count_aux = 0;
				for ($c=0; $c < $cursos; $c++) { 
					if($horario_profesor[$c][$h][$d]!=0){
						$count_aux=1;
						break;
					}
				}
				if($count_aux!=0){
					$count_violat += 1;
				}
			}
		}
		return $count_violat;
	}
	public function calcularCargaHoras($horario_profesor){
		$count_violat = 0;
		for ($c=0; $c < $cursos; $c++) { 
			for ($d=0; $d < $dias; $d++) {
				$count_aux = 0;
				for ($h=0; $h < $horas; $h++) { 
					if($horario_profesor[$c][$h][$d]!=0){
						$count_aux=1;
						break;
					}
				}
				if($count_aux!=0){
					$count_violat += 1;
				}
			}
		}
		return $count_violat;
	}
	public function preferenciaProfesores($horario_profesor){
		$count_violat = 0;
		for ($t=0; $t < sizeof($horario_profesor); $t++) { 
			for ($h=0; $h < $horas; $h++) { 
				for ($d=0; $d < $dias; $d++) {
					$esLibre = 1;
					for ($c=0; $c < $cursos; $c++) { 
						if($horario_profesor[$c][$h][$d]!=0){
							$esLibre=0;
							break;
						}
					}
					if($esLibre == 1 $$ $esLibre == $profesor[$t][$h][$d]){
						$count_violat += 1;
					}
				}
			}
		}
		return $count_violat;
	}
}
?>