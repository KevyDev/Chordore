<?php
	
	require_once '../php/app.php';

	if(isset($app->user)) {
		if(isset($_POST['text']) && isset($_POST['privacy'])) {
			$text = $_POST['text'];
			$privacy = $_POST['privacy'];
			$images = isset($_FILES['images']) ? $_FILES['images'] : false;
			echo json_encode($app->postCompose($text, $images, $privacy));
		}
	}

?>