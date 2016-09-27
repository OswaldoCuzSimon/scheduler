<?php
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
	public function addUEA($uea,$usuario_id,$solucion_id){
		include ("config.php");

		
		if ($stmt = $conn->prepare("INSERT INTO UEA (uea_id,usuario_id,nombre,grupo,cupo,horas,nivel,trimestre,obligatoria,creditos)
			VALUES(?,?,?,?,?,?,?,?,?);")) {
			$uea_id 	= $uea->getUea_id();
			$nombre 	= $uea->getNombre();
			$grupo 		= $uea->getGrupo();
			$cupo 		= $uea->getCupo();
			$horas 		= $uea->getHoras();
			$nivel 		= $uea->getNivel();
			$trimestre 	= $uea->getTrimestre();
			$obligatoria = $uea->getObligatoria();
			$creditos 	= $uea->getCreditos();

			$stmt->bind_param(1,$uea_id);
			$stmt->bind_param(2,$usuario_id);
			$stmt->bind_param(3,$nombre);
			$stmt->bind_param(4,$grupo);
			$stmt->bind_param(5,$cupo);
			$stmt->bind_param(6,$horas);
			$stmt->bind_param(7,$nivel);
			$stmt->bind_param(8,$trimestre);
			$stmt->bind_param(9,$obligatoria);
			$stmt->bind_param(10,$creditos);

			$result = $stmt->execute();
		}else{
			$stmt->close();
			$conn->close();
			$result = false;
		}
		return $result;

	}
	public function deleteProfesor($profesor_id,$usuario_id,$solucion_id){
		include ("config.php");
		if ($stmt = $conn->prepare("DELETE FROM profesores WHERE usuario_id=? and profesor_id=?;")) {
			$stmt->bind_param(1,$usuario_id);
			$stmt->bind_param(2,$profesor_id);

			$stmt->execute();
		}
		$stmt->close();
		$conn->close();
	}
	public function deleteUEA($uea_id,$usuario_id,$solucion_id){
		include ("config.php");
		if ($stmt = $conn->prepare("DELETE FROM profesores WHERE usuario_id=? and uea_id=? and solucion_id=?;")) {
			$stmt->bind_param(1,$usuario_id);
			$stmt->bind_param(2,$uea_id);
			$stmt->bind_param(1,$solucion_id);

			$stmt->execute();
		}
		$stmt->close();
		$conn->close();
	}
	public function updateProfesor($profesor,$usuario_id,$solucion_id){
		include ("config.php");
		
		if ($stmt = $conn->prepare("UPDATE profesores SET (profesor_id,usuario_id,nombre,carga_academica)
			WHERE profesor_id=? AND usuario_id = ?;")) {

			$profesor_id = $profesor->getProfesor_id();
			$nombre = $profesor->getNombre();
			$carga_academica = $profesor->getCargaAcademica();
			$stmt->bind_param('iisi',$profesor_id,$usuario_id,$nombre,$carga_academica);
			echo "<p>".$profesor->getProfesor_id().$usuario_id.$profesor->getNombre().$profesor->getCargaAcademica()."</p>";
			$result = $stmt->execute();

			if($result){
				return true;
			}else{
				return false;
			}
		}
		$stmt->close();
		$conn->close();
	}
	public function updateUEA($usuario_id,$solucion_id){

	}
	public function getProfesores($usuario_id,$solucion_id){

	}
	public function getUEA($usuario_id,$solucion_id){

	}
	public function getProfesorUEA($usuario_id,$solucion_id){

	}
	public function login($correo, $password){

	}
	public function addUser($correo,$usuario_id,$password){

	}
	public function deleteUser($usuario_id){

	}
}

?>