<?php
include ("config.php");

session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {

	$username = $conn->real_escape_string($_POST['email']);
	$password = $conn->real_escape_string($_POST['password']);

	// $myusername = 'oswaldo_cs_94@hotmail.com';
	// $mypassword = 'password';

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
}else {
	$jsondata['success'] = false;
	$jsondata['message'] = 'Error peticion invalida';
}

$conn->close();
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata);
?>

