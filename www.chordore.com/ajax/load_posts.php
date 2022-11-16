<?php
	
	require_once '../php/app.php';
	
	if(isset($app->user)) {
		$page = isset($_GET['page']) ? $_GET['page'] : 0;
		if(isset($_GET['username'])) {
			$username = $_GET['username'];
		}
		$result = isset($_GET['username']) ? $app->selectPostsByUserAccount($username, $page) : $posts = $app->selectPostsByUserHome($page);
		if($result) {
			if($result['state'] == 1) {
				$result2 = array('state'=>1, 'html'=>'', 'actual_page'=>$result['actual_page'], 'next_page'=>$result['next_page'], 'posts_num'=>count($result['posts']));
				foreach($result['posts'] as $post_info) {
					$result2['html'] = $result2['html'].$app->visualPost($post_info);
				}
				echo json_encode($result2);
			} else {
				if(isset($result['posts'])) {
					$result2 = array('state'=>3, 'html'=>'', 'actual_page'=>$result['actual_page'], 'posts_num'=>count($result['posts']));
					foreach($result['posts'] as $post_info) {
						$result2['html'] = $result2['html'].$app->visualPost($post_info);
					}
					$result2['html'] = $result2['html'].'<span class="text-information">'.$result['response'].'</span>';
					echo json_encode($result2);
				} else {
					$result2 = array('state'=>3, 'html'=>'<span class="text-information">'.$result['response'].'</span>', 'actual_page'=>$result['actual_page'], 'posts_num'=>0);
					echo json_encode($result2);
				}
			}
		}
	}

?>