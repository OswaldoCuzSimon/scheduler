<?php
	class Profesor {
		private $availability;
		private $profesor_id;
		private $nombre;
		private $cargaAcademica;
		private $usuario_id;

		/*public function __construct1($profesor_id, $nombre, $cargaAcademica,$availability){
			$this->getProfesor_id	= $profesor_id;
			$this->getNombre		= $nombre;
			$this->cargaAcademica	= $cargaAcademica;
			$this->availability 	= $availability;
		}*/
		public function __construct($profesor_id, $usuario_id,$nombre, $cargaAcademica){
			$this->profesor_id	= $profesor_id;
			$this->nombre		= $nombre;
			$this->cargaAcademica	= $cargaAcademica;
			$this->usuario_id 	= $usuario_id; 
		}

		public function getAvailability(){
			return $this->availability;
		}

		public function setAvailability($availability){
			$this->availability = $availability;
		}

		public function getProfesor_id(){
			return $this->profesor_id;
		}

		public function setProfesor_id($profesor_id){
			$this->profesor_id = $profesor_id;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

		public function getCargaAcademica(){
			return $this->cargaAcademica;
		}

		public function setCargaAcademica($cargaAcademica){
			$this->cargaAcademica = $cargaAcademica;
		}
		public function getUsuario_id(){
			return $this->usuario_id;
		}

		public function setUsuario_id($creditos){
			$this->usuario_id = $usuario_id;
		}
	}

	class UEA {
		private $clave;
		private $nombre;
		private $horasSemana;
		private $carrera;
		private $grupo;
		private $cupo;
		private $nivel;
		private $trimestre;
		private $seriacion;
		private $dias;
		private $esObligatoria;
		private $creditos;
		private $usuario_id;

		public function __construct($clave,$usuario_id,$nombre,$cupo,$horasSemana,$nivel,
			$trimestre,$esObligatoria,$creditos,$grupo){
			$this->clave 		= $clave;
			$this->usuario_id	= $usuario_id;
			$this->nombre 		= $nombre;
			$this->cupo 		= $cupo;
			$this->horasSemana 	= $horasSemana;
			$this->nivel 		= $nivel;
			$this->trimestre 	= $trimestre;
			$this->esObligatoria= $esObligatoria;
			$this->creditos		= $creditos;
			$this->grupo 		= $grupo;
		}
		public function __construct1($clave,$usuario_id,$nombre,$cupo,$horasSemana,$nivel,
			$trimestre,$esObligatoria,$creditos,$carrera,$grupo,$seriacion,$dias){
			$this->clave 		= $clave;
			$this->usuario_id	= $usuario_id;
			$this->nombre 		= $nombre;
			$this->cupo 		= $cupo;
			$this->horasSemana 	= $horasSemana;
			$this->nivel 		= $nivel;
			$this->trimestre 	= $trimestre;
			$this->esObligatoria= $esObligatoria;
			$this->creditos		= $creditos;

			$this->carrera 		= $carrera;
			
			$this->grupo 		= $grupo;
			$this->seriacion 	= $seriacion;
			$this->dias 		= $seriacion;
		}
		public function getClave(){
			return $this->clave;
		}

		public function setClave($clave){
			$this->clave = $clave;
		}

		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

		public function getHorasSemana(){
			return $this->horasSemana;
		}

		public function setHorasSemana($horasSemana){
			$this->horasSemana = $horasSemana;
		}

		public function getCarrera(){
			return $this->carrera;
		}

		public function setCarrera($carrera){
			$this->carrera = $carrera;
		}

		public function getGrupo(){
			return $this->grupo;
		}

		public function setGrupo($grupo){
			$this->grupo = $grupo;
		}

		public function getCupo(){
			return $this->cupo;
		}

		public function setCupo($cupo){
			$this->cupo = $cupo;
		}

		public function getNivel(){
			return $this->nivel;
		}

		public function setNivel($nivel){
			$this->nivel = $nivel;
		}

		public function getTrimestre(){
			return $this->trimestre;
		}

		public function setTrimestre($trimestre){
			$this->trimestre = $trimestre;
		}

		public function getSeriacion(){
			return $this->seriacion;
		}

		public function setSeriacion($seriacion){
			$this->seriacion = $seriacion;
		}

		public function getDias(){
			return $this->dias;
		}

		public function setDias($dias){
			$this->dias = $dias;
		}

		public function getEsObligatoria(){
			return $this->esObligatoria;
		}

		public function setEsObligatoria($esObligatoria){
			$this->esObligatoria = $esObligatoria;
		}
		public function getCreditos(){
			return $this->creditos;
		}

		public function setCreditos($creditos){
			$this->creditos = $creditos;
		}
		public function getUsuario_id(){
			return $this->usuario_id;
		}

		public function setUsuario_id($creditos){
			$this->usuario_id = $usuario_id;
		}
	}
?>