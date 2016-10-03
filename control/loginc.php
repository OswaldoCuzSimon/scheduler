<?php
include ("config.php");
include '../model/modelo.php';

session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {

	$username = $conn->real_escape_string($_POST['email']);
	$password = $conn->real_escape_string($_POST['password']);

	$modelo = new Modelo();

	
	$jsondata = $modelo->login($username,$password);

	// $myusername = 'oswaldo_cs_94@hotmail.com';
	// $mypassword = 'password';

}else {
	$jsondata['success'] = false;
	$jsondata['message'] = 'Error peticion invalida';
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata);
?>

