<?php
/**
 * revisa si las variables de sesion son validas
 *
 */
function login_check() {
	
	if (isset($_SESSION['login_user'], $_SESSION['login_string'])) {
		include ("config.php");
		$user_id = $_SESSION['login_user'];
		
		if ($stmt = $conn->prepare("SELECT password 
                                      FROM usuarios 
                                      WHERE usuario_id = ? LIMIT 1")) {
			$stmt->bind_param('s', $user_id);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 1) {
				$stmt->bind_result($password);
				$stmt->fetch();

				$login_string = $_SESSION['login_string'];
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				$login_check = hash('sha512', $user_id.$password.$user_browser);
				if ($login_check == $login_string) {
					return true;
				}
			}

		}

	}
	return false;
}