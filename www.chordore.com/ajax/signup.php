<?php
	
	require_once '../php/app.php';

	if(isset($app->user)) {
		echo json_encode(array('state'=>1, 'redirect'=>'home'));
	} else {
		if(!isset($_SESSION['signup-step'])) {
			$_SESSION['signup-step'] == 1;
		}
		if($_SESSION['signup-step'] == 1 && isset($_POST['name'])) {
			$name = $_POST['name'];
			$result = $app->signupComprobeName($name);
			if($result['state'] == 1) {
				$_SESSION['signup-name'] = $name;
				$_SESSION['signup-step'] = 2;
			}
			$result['redirect'] = 'signup?step=2';
			echo json_encode($result);
		} elseif($_SESSION['signup-step'] == 2 && isset($_POST['username'])) {
			$username = preg_replace("/[[:space:]]/", "_", trim($_POST['username']));
			$result = $app->signupComprobeUsername($username);
			if($result['state'] == 1) {
				$_SESSION['signup-username'] = $username;
				$_SESSION['signup-step'] = 3;
			}
			$result['redirect'] = 'signup?step=3';
			echo json_encode($result);
		} elseif($_SESSION['signup-step'] == 3 && isset($_POST['email'])) {
			$email = preg_replace("/[[:space:]]/", "_", trim($_POST['email']));
			$result = $app->signupComprobeEmail($email);
			if($result['state'] == 1) {
				$_SESSION['signup-email'] = $email;
				$_SESSION['signup-step'] = 4;
			}
			$result['redirect'] = 'signup?step=4';
			echo json_encode($result);
		} elseif($_SESSION['signup-step'] == 4 && isset($_POST['password'])) {
			$password = $_POST['password'];
			$result = $app->signupComprobePassword($password);
			if($result['state'] == 1) {
				$_SESSION['signup-step'] = 5;
				$_SESSION['signup-password'] = $password;
			}		
			$result['redirect'] = 'signup?step=5';		
			echo json_encode($result);
		} elseif($_SESSION['signup-step'] == 5 && isset($_POST['re_password'])) {
			$re_password = $_POST['re_password'];
			$result = $app->signupComprobeRePassword($_SESSION['signup-password'], $re_password);
			if($result['state'] == 1) {
				$_SESSION['signup-step'] = 5;
				$_SESSION['signup-re_password'] = $re_password;
				$result2 = $app->userSignup($_SESSION['signup-name'], $_SESSION['signup-username'], $_SESSION['signup-email'], $_SESSION['signup-password'], $_SESSION['signup-re_password']);		
				if($result2['state'] == 1) {
					unset($_SESSION['signup-step']);
					unset($_SESSION['signup-name']);
					unset($_SESSION['signup-username']);
					unset($_SESSION['signup-email']);
					unset($_SESSION['signup-password']);
					unset($_SESSION['signup-re_password']);
				}
				$result2['redirect'] = 'home';
				echo json_encode($result2);
			} else {
				$result['redirect'] = 'home';
				echo json_encode($result);
			}
		}
	}

?>