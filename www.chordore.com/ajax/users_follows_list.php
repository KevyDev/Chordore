<?php
	
	require_once 'app.php';

	if(isset($app->user)) {
        if(isset($_GET['tab']) && isset($_GET['username'])) {
            $username = $_GET['username'];
            $tab = $_GET['tab'];
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 0;
            }
            if($tab == 'followers') {
                $follows = $app->userGetFollowers($username, $page);
            } elseif($tab == 'following') {
                $follows = $app->userGetFollowing($username, $page);
            }
            if(isset($follows)) {
                if($follows['state'] == 1) {
                    $users = $follows['users'];
                    $follows['users'] = '';
                    foreach($users as $user) {
                        $follows['users'] = $follows['users'].$app->visualUser($user);
                    }
                }
                echo json_encode($follows);
            }
        }
	}

?>