<?php 

	require_once 'php/app.php';

	if(isset($_GET['username'])) {
		if(empty($_GET['username'])) {
			header('location: '.$app->url);
			die();
		} else {
			$username = $_GET['username'];
			$app->userLogued('login?redirect=users/'.$username);
			$account = $app->userAccountLoad($username);	
			$notFound = false;
			if(!$account) {
				unset($account);
				$notFound = true;
				$account = $app->userDefault($username);
			}
			$tab = isset($_GET['tab']) ? $_GET['tab'] : 'posts';
			$tabs = array('posts', 'followers', 'following');
			if(!in_array($tab, $tabs)) {
				header('location: '.$app->url.'users/'.$username);
			}
		}
	} else {
		header('location: '.$app->url);
		die();
	}
	
	$app->addToPage('Lm', 1);
	$app->page['scripts'][] = 'post-compose.js';

	require_once 'libs/header.php'; 

?>
	<div class="account-user">
		<div class="header">
			<?php if($tab == 'posts') { ?>
			<div class="user-banner">
				<?php if($account['banner']) { ?>
					<img src="<?=$account['banner']['url'];?>">
				<?php } ?>
			</div>
			<?php } ?>
			<div class="container">
				<div class="info">	
					<div class="user-photo">
						<?php if($account['photo']) { ?>
							<img src="<?=$account['photo']['url'];?>" />
						<?php } ?>
					</div>
					<div class="names">
						<span class="name"><?=$account['name'];?> </span>
						<span class="username">@<?=$account['username'];?></span>
					</div>
				</div>
				<?php if($account['id'] == $app->user['id']) { ?>
					<a href="accounts/edit" class="button">
						<button>
							<span class="icon-pencil icon"></span>
							<span class="text"><?=$app->language['EDITPROFILE'];?></span>
						</button>
					</a>
				<?php } else { ?>
					<div class="user-interactions-follow <?=$account['user_following'];?>" id="<?=$account['token'];?>">
						<button class="user-interactions-follow-btn inactive" id='<?=$account['username'];?>'>
							<span class="icon-user-plus icon"></span>
							<span class="text"><?=$app->language['FOLLOW'];?></span>
						</button>

						<button class="user-interactions-follow-btn active" id='<?=$account['username'];?>'>
							<span class="icon-user-minus icon"></span>
							<span class="text"><?=$app->language['UNFOLLOW'];?></span>
						</button>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php if($notFound == false) { if($tab == 'posts') { ?>
		<div class="other-info">	
			<?php if($account['bio'] !== '') { ?>
			<div class="info-element info-bio">
				<span class="icon icon-pencil"></span>
				<span class="text"><?=$account['bio'];?></span>
			</div>
			<?php } ?>
			<div class="info-element info-joined-date">
				<span class="icon icon-calendar"></span>
				<span class="text"><?=$app->language['JOINED'];?> <?=$app->transcTimeLang($account['joined_date']);?></span>
			</div>
			<?php if($account['location'] !== '') { ?>
			<div class="info-element info-location">
				<span class="icon icon-location"></span>
				<span class="text"><?=$account['location'];?></span>
			</div>
			<?php } ?>
			<?php if($account['link'] !== '') { ?>
			<div class="info-element info-link">
				<span class="icon icon-link"></span>
				<a href="redirect?url=<?=$account['link'];?>">
					<span class="text"><?=$account['link'];?></span>
				</a>
			</div>
			<?php } ?>
		</div>
		<div class="stadistics">
			<div class="stadistics-item">
				<span class="num"><?=$account['posts_let'];?></span>
				<span class="text"><?=$app->language['POSTS'];?></span>
			</div>
			<a href="users/<?=$account['username'];?>/followers" class="stadistics-item">
				<span class="num"><?=$account['followers_let'];?></span>
				<span class="text"><?=$app->language['FOLLOWERS'];?></span>
			</a>
			<a href="users/<?=$account['username'];?>/following" class="stadistics-item">
				<span class="num"><?=$account['following_let'];?></span>
				<span class="text"><?=$app->language['FOLLOWING'];?></span>
			</a>
		</div>
		<?php }} ?>
	</div>
	<?php 
		if($notFound == false) { 
			if($tab == 'posts') { 
				if($account['id'] != $app->user['id']) { 
					$postComposeTag = '@'.$account['username']; 
				} 
				require_once 'libs/form-posts-compose.php'; 
	?>
	<div class="posts-container" id="account-posts-container" accountUsername="<?=$account['username'];?>" myContainer="<?=$account['id'] == $app->user['id'] ? '1' : '0';?>"></div>
	<div id="posts-container-load-more" page="1"></div>
	<?php
			} else { 
	?>
	<div class="menu-followers-follows">
		<a href="users/<?=$username;?>/followers" class="<?=$tab == 'followers' ? 'selected' : '';?>"><?=$app->language['FOLLOWERS']?> · <?=$account['followers_let'];?></a>
		<a href="users/<?=$username;?>/following" class="<?=$tab == 'following' ? 'selected' : '';?>"><?=$app->language['FOLLOWING']?> · <?=$account['following_let'];?></a>
	</div>
	<?php if($tab == 'followers') { ?>
		<div class="account-follows-container" id="account-followers-container" accountUsername="<?=$account['username'];?>"></div>
		<div id="followers-container-load-more" page="1"></div>	
	<?php } elseif($tab == 'following') { ?>
		<div class="account-follows-container" id="account-following-container" accountUsername="<?=$account['username'];?>"></div>
		<div id="following-container-load-more" page="1"></div>	
	<?php			 
				} 
			} 
		} else {
	?>
	<span class="text-information"><?=$app->language['USERNOEXIST'];?></span>
	<?php
		}

	?>
	
<?php 

	require_once 'libs/footer.php'; 

?>