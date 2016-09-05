<?php

	
	if( isset($_POST['id']) && isset($_POST['nombre'])  && isset($_POST['cargaAcademica'])  && 
			isset($_POST['tabla']) && isset($_POST['tablaSize']) ){
		$nombre = $_POST['nombre'];
		$id = $_POST['id'];
		$cargaAcademica = $_POST['cargaAcademica'];
		$tabla = $_POST['tabla'];

		$jsondata = array();
		$jsondata['success'] = true;
		$jsondata['message'] = 'res: '.$id." ".$nombre." ".$cargaAcademica." ".sizeof($tabla)." ".var_export($tabla, true);;

	} else {
		$jsondata['success'] = false;
		$jsondata['message'] = 'Error peticion invalida';

	}
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata);
	exit();
?>