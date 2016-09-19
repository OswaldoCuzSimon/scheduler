<?php
class Modelo{
	public function addProfesor($profesor,$usuario_id){
		include ("config.php");
		
		if ($stmt = $conn->prepare("INSERT INTO profesores (profesor_id,usuario_id,nombre,carga_academica)
			VALUES(?,?,?,?);")) {

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
	public function addUEA($uea,$usuario_id,$solucion_id){
		include ("config.php");

		
		if ($stmt = $conn->prepare("INSERT INTO UEA (uea_id,usuario_id,nombre,grupo,cupo,horas,nivel,trimestre,obligatoria,creditos)
			VALUES(?,?,?,?,?,?,?,?,?);")) {
			$stmt->bind_param(1,$uea->getUea_id());
			$stmt->bind_param(2,$uea->getNombre());
			$stmt->bind_param(3,$uea->getGrupo());
			$stmt->bind_param(4,$uea->getCupo());
			$stmt->bind_param(5,$uea->getHoras());
			$stmt->bind_param(6,$uea->getNivel());
			$stmt->bind_param(7,$uea->getTrimestre());
			$stmt->bind_param(8,$uea->getObligatoria());
			$stmt->bind_param(9,$uea->getCreditos());

			$stmt->execute();
		}
		$stmt->close();
		$conn->close();

	}
	public function deleteProfesor($profesor_id,$usuario_id,$solucion_id){
		include ("config.php");
		if ($stmt = $conn->prepare("DELETE FROM profesores WHERE usuario_id=? and profesor_id=? and solucion_id=?;")) {
			$stmt->bind_param(1,$usuario_id);
			$stmt->bind_param(2,$profesor_id);
			$stmt->bind_param(1,$solucion_id);

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
	public function updateProfesor($uea,$usuario_id,$solucion_id){

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