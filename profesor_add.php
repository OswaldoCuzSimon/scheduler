<?php

	
	if( isset($_POST['id']) && isset($_POST['nombre'])  && isset($_POST['cargaAcademica'])  && 
		isset($_POST['tabla']) && isset($_POST['tablaSize']) ){

		//if( $_POST['param'] == 'valor' && ){
		$nombre = $_POST['nombre'];
		$id = $_POST['id'];
		$cargaAcademica = $_POST['cargaAcademica'];
		$tabla = $_POST['tabla'];

		//var_dump($tabla);
		
		 //echo 


		$jsondata = array();

	        $jsondata['success'] = true;
	        //$jsondata['message'] = 'Profesor agregado con exito!';
	        $jsondata['message'] = 'res: '.$id." ".$nombre." ".$cargaAcademica." ".sizeof($tabla)." ".var_export($tabla, true);;

	    } else {

	        $jsondata['success'] = false;
	        $jsondata['message'] = 'Profesor no se pudo agregar';

	    }

	    //Aunque el content-type no sea un problema en la mayoría de casos, es recomendable especificarlo
	    header('Content-type: application/json; charset=utf-8');
	    echo json_encode($jsondata);
	    exit();

//	}

?>