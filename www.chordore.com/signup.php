<?php 

	require_once 'php/app.php';
	$app->addToPage('notBg', 1);
	$app->page['scripts'][] = 'login-signup.js';
	$app->userNotLogued();
	require_once 'libs/header.php';

?>
	<form rel="async" method="post" action="ajax/signup.php" id="form-login-signup">
		<span class="title"><?=$app->language['REGISTER'];?> (<?=$_GET['step'];?>/5)</span>
	<?php 
		if(!isset($_SESSION['signup-step'])) {
			$_SESSION['signup-step'] = 1;
		}
		if(isset($_GET['step'])) { 
			$signupStep = $_GET['step'];
			if($signupStep == $_SESSION['signup-step']) {
				if($signupStep > 0 && $signupStep <= 5) {		
					if($signupStep == 1) {
	?>
		<input class="form-input" type="text" name="name" maxlength="<?=$app->fullNameMaxC;?>" minlength="<?=$app->fullNameMinC;?>" placeholder="<?=$app->language['NAME'];?>" />
		<span class="information-text"><?=$app->language['ENTERFULLNAME'];?> (<?=$app->language['EXAMPLECOMP'];?>: Juan P&eacute;rez)</span>
	<?php
					} elseif($signupStep == 2) {
	?>
		<input class="form-input" type="text" name="username" maxlength="<?=$app->usernameMaxC;?>" minlength="<?=$app->usernameMinC;?>" placeholder="<?=$app->language['USERNAME'];?>" />
		<span class="information-text"><?=$app->language['ENTERUSERNAME'];?> (<?=$app->language['EXAMPLECOMP'];?>: juanperez777)</span>
	<?php
					} elseif($signupStep == 3) {
	?>
		<input class="form-input" type="email" name="email" maxlength="<?=$app->emailMaxC;?>" minlength="<?=$app->emailMinC;?>" placeholder="<?=$app->language['EMAIL'];?>" />
		<span class="information-text"><?=$app->language['ENTEREMAIL'];?> (<?=$app->language['EXAMPLECOMP'];?>: juanperez@email.com)</span>
	<?php	
					} elseif($signupStep == 4) {
	?>
		<input class="form-input" type="password" name="password" maxlength="<?=$app->passwordMaxC;?>" minlength="<?=$app->passwordMinC;?>" placeholder="<?=$app->language['PASSWORD'];?>" />
		<span class="information-text"><?=$app->language['ENTERPASSWORD'];?> (<?=$app->language['EXAMPLECOMP'];?>: RjuAnPerEzn1997)</span>
	<?php	
					} elseif($signupStep == 5) {
	?>
		<input class="form-input" type="password" name="re_password" maxlength="<?=$app->passwordMaxC;?>" minlength="<?=$app->passwordMinC;?>" placeholder="<?=$app->language['REPASSWORD'];?>" />
		<span class="information-text"><?=$app->language['ENTERREPASSWORD'];?></span>
	<?php	
					} 
	?>
		<input type="submit" name="submit" value="<?=$signupStep < 5 ? $app->language['NEXT'] : $app->language['REGISTER'];?>" />
	<?php 
				} else {
					header('location: '.$app->url.'signup?step='.$_SESSION['signup-step']);
				}
			} else {
				header('location: '.$app->url.'signup?step='.$_SESSION['signup-step']);
			}
	?>
			<span id="error-warn-text"></span>
			<span class="alert"><?=$app->language['HAVEACCOUNT'];?> <a href="login"><?=$app->language['LOGIN'];?></a></span>
	<?php 
		} else {
			header('location: '.$app->url.'signup?step='.$_SESSION['signup-step']);
		} 
	?>
	</form>
<?php require_once 'libs/footer.php'; ?>