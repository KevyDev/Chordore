<?php
	
	$page_notlogued = 1;
	require_once 'app.php';

	if(!isset($app->user)) {
		$data = json_decode(file_get_contents('php://input'), 0);
        if(!isset($_SESSION['password-reset-username']) && !isset($_SESSION['password-reset-username'])) {
            if(isset($data->email)) {
                $email = $data->email;
                if(!$app->verifyEmailExist($email)) {
                    $result = array('state'=>0, 'response'=>$app->language['EMAILNOEXIST']);
				    echo json_encode($result);
                } else {
                    $_SESSION['password-reset-email'] = $email;
                    $result = array('state'=>1, 'response'=>'');
				    echo json_encode($result);
                }
            } elseif(isset($data->username)) {
                $username = $data->username;
                if(!$app->verifyUsernameExist($username)) {
                    $result = array('state'=>0, 'response'=>$app->language['USERNAMENOEXIST']);
				    echo json_encode($result);
                } else {
                    $_SESSION['password-reset-username'] = $username;
                    $result = array('state'=>1, 'response'=>'');
				    echo json_encode($result);
                }
            }
        }
	}

?>