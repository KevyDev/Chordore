<?php 
	
	require_once '../php/app.php'; 
	$app->page['scripts'][] = 'account-edit.js';
	$app->userLogued();
	require_once '../libs/header.php'; 

?>
	<div class="account-edit">
		<div class="banner">
			<div class="img" id="account-edit-banner-container">
				<?php if($app->user['banner']) { ?>
					<img src="<?=$app->filesLocation;?><?=$app->user['banner'];?>" class="banner">
				<?php } ?>
			</div>	
			<div class="options" id="account-edit-banner-options">
				<span class="icon-upload icon" id="account-edit-banner-option-upload"></span>
				<span class="icon-cross icon" id="account-edit-banner-option-cancel"></span>
			</div>
		</div>
		<div class="user-photo">
			<div class="img" id="account-edit-photo-container">
				<?php if($app->user['photo']) { ?>
					<img src="<?=$app->user['photo']['url'];?>" class="photo">
				<?php } ?>
			</div>	
			<div class="options" id="account-edit-photo-options">
				<span class="icon-upload icon" id="account-edit-photo-option-upload"></span>
				<span class="icon-cross icon" id="account-edit-photo-option-cancel"></span>
			</div>
		</div>
		<form method="POST" action="ajax/account_edit.php" enctype=multipart/form-data id="account-edit-form">
			<input id="account-edit-form-input-photo" type="file" name="photo" accept="<?=$app->imgFormats?>" hidden />
			<input id="account-edit-form-input-banner" type="file" name="banner" accept="<?=$app->imgFormats?>" hidden />
			<input id="account-edit-form-input-name" type="text" name="name" maxlength="<?=$app->fullNameMaxC;?>" minlength="<?=$app->fullNameMinC;?>" placeholder="<?=$app->language['NAME'];?>" value="<?=$app->user['name'];?>" required />
			<input id="account-edit-form-input-username" type="text" name="username" maxlength="<?=$app->usernameMaxC;?>" minlength="<?=$app->usernameMinC;?>" placeholder="<?=$app->language['USERNAME'];?>" value="<?=$app->user['username'];?>" required />
			<input id="account-edit-form-input-email" type="email" name="email" maxlength="<?=$app->emailMaxC;?>" minlength="<?=$app->emailMinC;?>" placeholder="<?=$app->language['EMAIL'];?>" value="<?=$app->user['email'];?>" required />
			<textarea id="account-edit-form-input-bio" name="bio" maxlength="<?=$app->bioMaxC;?>" minlength="<?=$app->bioMinC;?>" placeholder="Bio"><?=$app->user['bio'];?></textarea>
			<input id="account-edit-form-input-location" type="text" name="location" maxlength="<?=$app->locationMaxC;?>" minlength="<?=$app->locationMinC;?>" placeholder="<?=$app->language['LOCATION'];?>" value="<?=$app->user['location'];?>" />
			<input id="account-edit-form-input-link" type="text" name="link" maxlength="<?=$app->linkMaxC;?>" minlength="<?=$app->linkMinC;?>" placeholder="<?=$app->language['LINK'];?>" value="<?=$app->user['link'];?>" />
			<input type="submit" name="submit" value="<?=$app->language['SAVECHANGES'];?>" />
			<span id="error-warn-text"></span>			
		</form>
	</div>
	<?php require_once '../libs/footer.php'; ?>