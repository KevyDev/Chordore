<?php 

	require_once 'php/app.php'; 
	if(isset($app->user)) {
		$app->setPage('home');
		$app->addToPage('Lm', 1);
		$app->addToPage('Rm', 1);
		$app->page['scripts'][] = 'post-compose.js';
	} else {
		$app->addToPage('notBg', 1);
	}
	require_once 'libs/header.php';
	
	if(isset($app->user)) { 
		
?>
		<!-- <div class="storys-container" id="home-storys-container">
			<a href="story/username/token" class="story">
				<img src="files/default.png" />
				<span class="username">Username</span>
			</a>
			<a href="story/username/token" class="story">
				<img src="files/default.png" />
				<span class="username">Username</span>
			</a>
			<a href="story/username/token" class="story">
				<img src="files/default.png" />
				<span class="username">Username</span>
			</a>
			<a href="story/username/token" class="story">
				<img src="files/default.png" />
				<span class="username">Username</span>
			</a>	
			<a href="story/username/token" class="story">
				<img src="files/default.png" />
				<span class="username">Username</span>
			</a>	
			<a href="story/username/token" class="story">
				<img src="files/default.png" />
				<span class="username">Username</span>
			</a>	
		</div> -->
		<div id="home-container">
			<div class="container">
				<?php require_once 'libs/form-posts-compose.php'; ?>
				<div class="posts-container" id="home-posts-container"></div>
				<div id="posts-container-load-more" page="1"></div>	
			</div>
		</div>
	<?php } else { ?>
		<?php unset($_SESSION['signup-step']); ?>
		<div id="home-notLogued">
			<img type="image/png" src="https://files.chordore.com/img/main-logo2.png" />
			<span class="home-text"><?=$app->language['HOMETEXT'];?></span>
			<a href="signup" class="button"><button><?=$app->language['REGISTER'];?></button></a>
			<div class="user-select-log">
				<span class="line"></span>
				<span class="text"><?=$app->language['OR'];?></span>
				<span class="line"></span>
			</div>
			<a href="login" class="button"><button><?=$app->language['LOGIN'];?></button></a>
			<?php require 'libs/languages.php'; ?>
		</div>
<?php 

	} 
	
	require_once 'libs/footer.php';

?>