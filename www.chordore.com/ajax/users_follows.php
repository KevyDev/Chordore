<?php
	
	require_once 'app.php';

	if(isset($app->user)) {
        if(isset($_GET['token'])) {
            $token = $_GET['token'];
            if($token !== $app->user['token']) {
                $user_id = $app->selectIdFromToken($token);
                if($user_id) {
                    if($app->lastFollows($app->user['id']) < $app->followsLimitPerDay) {
                        if($app->userFollowedBy($app->user['id'], $user_id)) {
                            $app->userUnfollow($app->user['id'], $user_id);
                            echo json_encode(array('state'=>1, 'user_followed'=>0));
                        } else {
                            $app->userFollow($app->user['id'], $user_id);
                            echo json_encode(array('state'=>1, 'user_followed'=>1));
                        }
                    } else {
                        echo json_encode(array('state'=>0, 'response'=>$app->language['POSTNOTFOUND']));
                    }
                } else {
                    echo json_encode(array('state'=>0, 'response'=>$app->language['POSTNOTFOUND']));
                }
            }
        }
	}

?>