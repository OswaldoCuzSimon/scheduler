<?php
include '../control/clases.php'; 
class Modelo{
	public function addProfesor($profesor,$usuario_id){
		include ("config.php");
		$result = false;
		$stmt = null;
		if ($stmt = $conn->prepare("INSERT INTO profesores (profesor_id,usuario_id,nombre,carga_academica)
			VALUES(?,?,?,?);")) {

			$profesor_id = $profesor->getProfesor_id();
			$nombre = $profesor->getNombre();
			$carga_academica = $profesor->getCargaAcademica();
			$stmt->bind_param('iisi',$profesor_id,$usuario_id,$nombre,$carga_academica);
			echo "<p>".$profesor->getProfesor_id().$usuario_id.$profesor->getNombre().$profesor->getCargaAcademica()."</p>";
			$result = $stmt->execute();

			if(!$result){
				error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
			}	
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$stmt->close();
		$conn->close();	

		return $result;
		
	}
	public function addUEA($uea){
		include ("config.php");
		$result = false;
		$stmt = null;
		/*if ($stmt = $conn->prepare("INSERT INTO UEA (uea_id,usuario_id,nombre,grupo,cupo,horas,nivel,trimestre,obligatoria,creditos)
			VALUES(?,?,?,?,?,?,?,?,?);")) {*/
		if ($stmt = $conn->prepare("INSERT INTO UEA (uea_id,id_usuario,nombre,cupo,horas,nivel,trimestre,obligatoria,creditos)
			VALUES(?,?,?,?,?,?,?,?,?);")) {
			$uea_id 	= $uea->getClave();
			$nombre 	= $uea->getNombre();
			$grupo 		= $uea->getGrupo();
			$cupo 		= $uea->getCupo();
			$horas 		= $uea->getHorasSemana();
			$nivel 		= $uea->getNivel();
			$trimestre 	= $uea->getTrimestre();
			$obligatoria = $uea->getEsObligatoria();
			$creditos 	= $uea->getCreditos();
			$usuario_id = $uea->getUsuario_id();

			$stmt->bind_param("iisiiisii",$uea_id,$usuario_id,$nombre,$cupo,$horas,$nivel,$trimestre,$obligatoria,$creditos);

			$result = $stmt->execute();
			//int 1062 Duplicate entry errno
			if(!$result){
					error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
			}	
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$stmt->close();
		$conn->close();	

		return $result;

	}
	public function deleteProfesor($profesor_id,$usuario_id){
		include ("config.php");
		if ($stmt = $conn->prepare("DELETE FROM profesores WHERE usuario_id=? and profesor_id=?;")) {
			$stmt->bind_param('ii',$usuario_id,$profesor_id);

			$stmt->execute();
		}
		$stmt->close();
		$conn->close();
	}
	public function deleteUEA($uea_id,$usuario_id){
		include ("config.php");
		$stmt = null;
		if ($stmt = $conn->prepare("DELETE FROM UEA WHERE id_usuario=? and uea_id=?;")) {
			$stmt->bind_param('ii',$usuario_id,$uea_id);

			$stmt->execute();
		}
		$stmt->close();
		$conn->close();
	}
	public function updateProfesor($profesor,$usuario_id){
		include ("config.php");
		$result = false;
		if ($stmt = $conn->prepare("UPDATE profesores SET nombre=?,carga_academica=?
			WHERE profesor_id=? AND usuario_id = ?;")) {

			$profesor_id = $profesor->getProfesor_id();
			$nombre = $profesor->getNombre();
			$carga_academica = $profesor->getCargaAcademica();
			$stmt->bind_param('siii',$nombre,$carga_academica,$profesor_id,$usuario_id);
			echo "<p>".$profesor->getProfesor_id().$usuario_id.$profesor->getNombre().$profesor->getCargaAcademica()."</p>";
			$result = $stmt->execute();
		}
		$stmt->close();
		$conn->close();

		return $result;
	}
	public function updateUEA($uea){
		include ("config.php");
		$result = false;
		if ($stmt = $conn->prepare("UPDATE UEA SET nombre=?,cupo=?,horas=?,nivel=?,trimestre=?,obligatoria=?,creditos=?
			WHERE uea_id=? AND id_usuario = ?;")) {

			$uea_id 	= $uea->getClave();
			$nombre 	= $uea->getNombre();
			$grupo 		= $uea->getGrupo();
			$cupo 		= $uea->getCupo();
			$horas 		= $uea->getHorasSemana();
			$nivel 		= $uea->getNivel();
			$trimestre 	= $uea->getTrimestre();
			$obligatoria = $uea->getEsObligatoria();
			$creditos 	= $uea->getCreditos();
			$usuario_id = $uea->getUsuario_id();

			$stmt->bind_param("siiisiiii",$nombre,$cupo,$horas,$nivel,$trimestre,$obligatoria,$creditos,$uea_id,$usuario_id);
			$result = $stmt->execute();
		}
		$stmt->close();
		$conn->close();

		return $result;
	}
	public function getProfesores($usuario_id){
		include ("config.php");
		$result = false;
		$stmt = null;
		$profesores = [];
		if ($stmt = $conn->prepare("SELECT profesor_id,nombre,carga_academica 
			FROM profesores WHERE usuario_id=? ORDER BY profesor_id;")) {

		
			$stmt->bind_param('i',$usuario_id);
			$stmt->execute();
			$result = $stmt->get_result();

			
			while ($myrow = $result->fetch_assoc()) {
				$prof = new Profesor($myrow['profesor_id'], $usuario_id,$myrow['nombre'],$myrow['carga_academica']);
				$prof->setAvailability($this->getDisponibilidad($usuario_id,$myrow['profesor_id']) );
				$profesores[] = $prof;
			}
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$stmt->close();
		$conn->close();	

		return $profesores;
	}
	private function getDisponibilidad($usuario_id,$profesor_id){
		
		include ("config.php");
		$result = false;
		$stmt = null;
		$disp = [];
		if ($stmt = $conn->prepare("SELECT hora,lunes,martes,miercoles,jueves,viernes from disponibilidad_profesor WHERE usuario_id=? AND profesor_id=? ORDER BY hora ;") ){

		
			$stmt->bind_param('ii',$usuario_id,$profesor_id);
			$stmt->execute();
			$result = $stmt->get_result();

			$disp =[];
			for ($hora=0; $hora < 13; $hora++) {
				for ($dia=0; $dia < 5; $dia++) {
					$disp[$hora][$dia]=0;
				}
			}
			while ($myrow = $result->fetch_assoc()) {
				$h = $myrow['hora'];
				unset($myrow['hora']);
				$aux = array_values( $myrow );
				$disp[$h]=$aux;
			}
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$stmt->close();
		$conn->close();
		return $disp;
	}
	public function getUEA($usuario_id){
		include ("config.php");
		$result = false;
		$stmt = null;
		$uea = [];
		if ($stmt = $conn->prepare("SELECT uea_id,nombre,cupo,horas,nivel,trimestre,obligatoria,creditos
			FROM UEA WHERE id_usuario=? ORDER BY uea_id;")) {

		
			$stmt->bind_param('i',$usuario_id);
			$stmt->execute();
			$result = $stmt->get_result();
			
			while ($myrow = $result->fetch_assoc()) {
				$uea[]= new UEA($myrow['uea_id'], $usuario_id,$myrow['nombre'],$myrow['cupo'],
					$myrow['horas'],$myrow['nivel'],$myrow['trimestre'],$myrow['obligatoria'],$myrow['creditos']);
			}
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$stmt->close();
		$conn->close();	

		return $uea;
	}
	public function getCursos($usuario_id){
		include ("config.php");
		$result = null;
		$uea = [];
		if ($result = $conn->query("SELECT uea_id,nombre,cupo,horas,nivel,trimestre,obligatoria,creditos
			FROM UEA WHERE id_usuario=$usuario_id ORDER BY uea_id;") ){
			$numcursos = $this->getNumCursos($usuario_id);

			while ($myrow = $result->fetch_assoc()) {
				$uea_id = $myrow['uea_id'];
				if(isset($numcursos[$uea_id]) ){
					$n = $numcursos[$uea_id];
					$grupos = $this->getGruposDeUEA($usuario_id,$uea_id);
					for ($i=0; $i < $n; $i++) { 
						$uea[]= new UEA($uea_id, $usuario_id,$myrow['nombre'],$myrow['cupo'],
						$myrow['horas'],$myrow['nivel'],$myrow['trimestre'],$myrow['obligatoria'],$myrow['creditos'],$grupos[$i]);
					}
				}else{
					$uea[]= new UEA($uea_id, $usuario_id,$myrow['nombre'],$myrow['cupo'],
						$myrow['horas'],$myrow['nivel'],$myrow['trimestre'],$myrow['obligatoria'],$myrow['creditos'],null);
				}
			}
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$conn->close();	

		return $uea;
	}
	private function getNumCursos($usuario_id){
		include ("config.php");
		$result = $conn->query("SELECT UEA_id,count(*) as numcursos	FROM UEA_has_grupo WHERE usuario_id=$usuario_id GROUP BY uea_id;");
		$grupos = [];
		
		while ($myrow = $result->fetch_assoc()){
			$grupos[$myrow['UEA_id'] ]=$myrow['numcursos'];
		}
		$conn->close();	

		return $grupos;
	}
	private function getGruposDeUEA($usuario_id,$uea_id){
		include ("config.php");
		$result = $conn->query("SELECT grupo_id FROM uea_has_grupo WHERE uea_id = $uea_id AND usuario_id=$usuario_id ORDER BY grupo_id;");
		$grupos = [];
		
		while ($myrow = $result->fetch_assoc()){
			$grupos[]=$myrow['grupo_id'];
		}
		$conn->close();	

		return $grupos;
	}
	public function getGrupos($usuario_id){
		include ("config.php");
		$result = false;
		$stmt = null;
		$grupos = [];
		if ($stmt = $conn->prepare("SELECT distinct grupo_id	
			FROM UEA_has_grupo WHERE usuario_id=? ORDER BY grupo_id;")) {
			$stmt->bind_param('i',$usuario_id);
			$stmt->execute();
			$result = $stmt->get_result();
			
			while ($myrow = $result->fetch_assoc()) {
				$grupo_id = $myrow['grupo_id'];
				$result2 = $conn->query("SELECT uea_id FROM UEA_has_grupo 
					WHERE usuario_id=$usuario_id AND grupo_id=$grupo_id ORDER BY uea_id;");
				while ($myrow = $result2->fetch_assoc())
					$grupos[$grupo_id][]=$myrow['uea_id'];
			}
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$stmt->close();
		$conn->close();	

		return $grupos;
	}
	public function getProfesorUEA($usuario_id){
		include ("config.php");
		$result = false;
		$stmt = null;
		$preferencia = [];
		if ($stmt = $conn->prepare("SELECT DISTINCT profesor_id FROM profesor_prefiere_uea WHERE usuario_id = ? ORDER BY profesor_id;")) {

		
			$stmt->bind_param('i',$usuario_id);
			$stmt->execute();
			$result = $stmt->get_result();
			
			while ($myrow = $result->fetch_assoc()) {
				$sql = "SELECT profesor_id,UEA_id FROM profesor_prefiere_uea WHERE usuario_id = $usuario_id 
				AND profesor_id = ".$myrow['profesor_id']." ORDER BY profesor_id,UEA_id;";
				$result2 = $conn->query($sql);
				$aux=[];
				while ($row = $result2->fetch_assoc()) {
					$aux[] = $row['UEA_id'];
				}
				$preferencia[$myrow['profesor_id'] ]=$aux;
			}
		}else{
			error_log(sprintf("[%d] %s",$stmt->sqlstate,$stmt->error));
		}		
		$stmt->close();
		$conn->close();	

		return $preferencia;
	}
	public function login($username, $password){
		$sql = "SELECT usuario_id FROM usuarios WHERE correo = '$username' and password = '$password'";
		$result = $conn->query($sql);
		$jsondata = array();
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();

			$_SESSION['login_user'] = $row['usuario_id'];
			$_SESSION['login_string'] = hash('sha512', $_SESSION['login_user'].$password.$_SERVER['HTTP_USER_AGENT']);

			$jsondata['success'] = true;
			$jsondata['message'] = $_SESSION['login_user'];
		}else {
			$jsondata['success'] = false;
			$jsondata['message'] = 'Usuario o contraseña invalidos';
		}

		$conn->close();
	}
	public function addUser($correo,$usuario_id,$password){

	}
	public function deleteUser($usuario_id){

	}
}


/*$modelo = new Modelo();
/*
$profesor = new Profesor(100,1,'Alarcon',3);
if(!$modelo->addProfesor($profesor,1)){
	echo "profesor no agregado<br>";
}
$modelo->deleteProfesor(100,1);
$profesor->setCargaAcademica(6);
$modelo->updateProfesor($profesor,5);

*/
/*
$uea = new UEA(101,'BASES DE DATOS AVANZADAS',5,'Computación',1,30,7,'O',1,[2,0,1,0,2],true,8,1);
if(!$modelo->addUEA($uea)){
	echo "UEA no agregada<br>";
}
$uea->setNombre('bases de datos');
$modelo->updateUEA($uea);
*/



?>