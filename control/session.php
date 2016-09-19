<?php
	include('config.php');
	session_start();

	$user_check = $_SESSION['login_user'];
	
	$result = $conn->query("select usuario_id from usuarios where usuario_id = '$user_check';");

	$row = $result->fetch_assoc();
	$login_session = $row['usuario_id'];

	if(!isset($login_session)){
		$conn->close();
		header('Location: login.php');
	}
?>