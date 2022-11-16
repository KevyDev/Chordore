<?php
	
	require_once '../php/app.php';

	if(isset($app->user)) {
		if(isset($_POST['name']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['bio']) && isset($_POST['location']) && isset($_POST['link'])) {
			$name = $_POST['name'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$bio = $_POST['bio'];
			$location = $_POST['location'];
			$link = $_POST['link'];
			if(isset($_FILES['banner'])) {
				$banner = $_FILES['banner'];
			} else {
				$banner = false;
			}
			if(isset($_FILES['photo'])) {
				$photo = $_FILES['photo'];
			} else {
				$photo = false;
			}
			// print_r($app->user);
			$result = $app->userEdit($name, $username, $email, $bio, $location, $link, $banner, $photo);
			$result['redirect'] = 'users/'.$app->user['username'];
			echo json_encode($result);
		}
	}

?>