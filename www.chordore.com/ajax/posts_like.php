<?php
	
	require_once 'app.php';

	if(isset($app->user)) {
        if(isset($_GET['token'])) {
            $post_id = $app->postGetIdFromToken($_GET['token']);
            if($post_id) {
                if($app->postLikedBy($post_id, $app->user['id'])) {
                    $app->postInteractDisLike($post_id, $app->user['id']);
                    echo json_encode(array('state'=>1, 'user_liked'=>0, 'likes_let'=>$app->formatNumsAndLetters($app->getPostLikes($post_id))));
                } else {
                    $app->postInteractLike($post_id, $app->user['id']);
                    echo json_encode(array('state'=>1, 'user_liked'=>1, 'likes_let'=>$app->formatNumsAndLetters($app->getPostLikes($post_id))));
                }
            } else {
                echo json_encode(array('state'=>0, 'response'=>$app->language['POSTNOTFOUND']));
            }
        }
	}

?>