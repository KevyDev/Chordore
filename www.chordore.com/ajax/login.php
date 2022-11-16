<?php
	
	require_once '../php/app.php';

	if(isset($_SESSION['login-redirect'])) {
		$redirect = $_SESSION['login-redirect'];
	} else {
		$redirect = 'home';
	}

	if(isset($app->user)) {
		echo json_encode(array('state'=>1, 'response'=>'', 'redirect'=>$redirect));
	} else {
		if(isset($_POST['username']) && isset($_POST['password'])) {
			$username = preg_replace("/[[:space:]]/", "_", trim($_POST['username']));
			$password = $_POST['password'];
			$result = $app->userLogin($username, $password);
			$result['redirect'] = $redirect;
			echo json_encode($result);
		}
	}

?>