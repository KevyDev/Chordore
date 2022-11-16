<?php 

	require_once 'php/app.php';
	$app->addToPage('notBg', 1);
	$app->page['scripts'][] = 'login-signup.js';
	$app->userNotLogued();
	unset($_SESSION['signup-step']); 
	if(isset($_GET['redirect'])) {
		$_SESSION['login-redirect'] = $_GET['redirect'];
	} else {
		$_SESSION['login-redirect'] = '';
	}

	require_once 'libs/header.php'; 
	
?>
	<form rel="async" method="post" action="ajax/login.php" id="form-login-signup">
		<span class="title"><?=$app->language['LOGIN'];?></span>
		<input class="form-input" type="text" name="username" placeholder="<?=$app->language['USERNAME'];?>" />
		<input class="form-input" type="password" name="password" placeholder="<?=$app->language['PASSWORD'];?>" />
		<input type="submit" name="submit" value="<?=$app->language['LOGIN'];?>" />
		<span id="error-warn-text"></span>
		<span class="alert"><?=$app->language['DONTHAVEACCOUNT'];?> <a href="signup"><?=$app->language['REGISTER'];?></a></span>
		<span class="alert"><a href="accounts/password_reset"><?=$app->language['FORGOTPASSWORD'];?></a></span>
	</form>
<?php require_once 'libs/footer.php'; ?>