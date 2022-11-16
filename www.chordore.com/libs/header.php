<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="Chordore LLC Oficial Platform." />
		<meta name="keywords" content="Chordore, music, beats, djs, singers, musica, cantantes." />
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" /> 
		<base href="<?=$app->url;?>" />
		<?php foreach($app->page['stylesh'] as $file) { ?>
			<link rel="stylesheet" type="text/css" href="https://files.chordore.com/css/v<?=$app->page['stylesh_v'];?>/<?=$file;?>" />
		<?php } ?>
		<link rel="icon" href="https://files.chordore.com/img/main-logo.png" type="image/png" />
		<link rel="shortcut icon" href="https://files.chordore.com/img/main-logo.png" type="image/png" />
		<title> <?=$app->page['title'];?> </title>
		<?php foreach($app->page['scripts'] as $file) { ?>
			<script type="text/javascript" src="https://files.chordore.com/js/v<?=$app->page['scripts_v'];?>/<?=$file;?>"></script>
		<?php } ?>
	</head>
	<body class="<?php echo isset($app->page['notBg']) ? '' : 'bg-gray'; ?>">
		<?php if(isset($app->user) && !isset($app->page['notHd'])) { ?>
		<header>			
			<nav>
				<div class="logo-container">
					<a href="" class="logo"><img type="image/png" src="https://files.chordore.com/img/main-logo2.png" /></a>
				</div>
				<ul class="inline-menu">
					<a href="" id="header-icon-home">
						<li>
							<span class="icon-home <?php echo $app->detectPage('home') ? 'selected' : ''; ?>"></span>
						</li>
					</a>

					<a href="explore/" id="header-icon-search">
						<li>
							<span class="icon-search <?php echo $app->detectPage('explore') ? 'selected' : ''; ?>"></span>
						</li>
					</a>

					<a href="friends/" id="header-icon-friends">
						<li>
							<span class="icon-users <?php echo $app->detectPage('friends') ? 'selected' : ''; ?>"></span>
						</li>
					</a>

					<a href="conversations/" id="header-icon-chats">
						<li>
							<span class="icon-bubbles2 <?php echo $app->detectPage('conversations') ? 'selected' : ''; ?>"></span>
						</li>
					</a>
					
					<a href="notifications/" id="header-icon-notifications">
						<li>
							<span class="icon-bell <?php echo $app->detectPage('notifications') ? 'selected' : ''; ?>"></span>
						</li>
					</a>
					
					<a href="users/<?=$app->user['username'];?>" id="header-user-photo">
						<li>
							<?php if($app->user['photo']) { ?>
								<img type="image/png" src="<?=$app->user['photo']['url'];?>" />
							<?php } ?>
						</li>
					</a>
				</ul>
			</nav>
		</header>
		<?php } ?>
		<div id="errors-container">
			<span class="error">Hubo un error :(</span>
		</div>
		<main id="container" class="<?=isset($app->page['Lm']) && !isset($app->page['Rm']) ? 'menu-left' : '';?> <?=isset($app->page['Rm']) && !isset($app->page['Lm']) ? 'menu-right' : '';?> <?=isset($app->page['Rm']) && isset($app->page['Lm']) ? 'menu-both' : '';?>">
			<?php if(isset($app->page['Lm'])) { ?>
			<div id="menu-left">
				<ul>
					<a href="home">
						<li>
							<div class="container">
								<span class="icon icon-home"></span>
								<span class="text"><?=$app->language['HOME'];?></span>
							</div>
						</li>
					</a>
					<a href="explore/">
						<li>
							<div class="container">
								<span class="icon icon-search"></span>
								<span class="text"><?=$app->language['EXPLORE'];?></span>
							</div>
						</li>
					</a>
					<div class="line"></div>
					<a href="friends/">
						<li>
							<div class="container">
								<span class="icon icon-users"></span>
								<span class="text"><?=$app->language['FRIENDS'];?></span>
							</div>
						</li>
					</a>	
					<a href="notifications/">
						<li>
							<div class="container">
								<span class="icon icon-bell"></span>
								<span class="text"><?=$app->language['NOTIFICATIONS'];?></span>
							</div>
							<div id="user-notifications-num">
								<span class="num">3</span>
							</div>
						</li>
					</a>
					<a href="conversations/">
						<li>
							<div class="container">
								<span class="icon icon-bubbles2"></span>
								<span class="text"><?=$app->language['CONVERSATIONS'];?></span>
							</div>
							<div id="user-notifications-num">
								<span class="num">6</span>
							</div>
						</li>
					</a>
					<div class="line"></div>
					<a href="users/<?=$app->user['username'];?>">
						<li>
							<div class="container">
								<span class="icon icon-user"></span>
								<span class="text"><?=$app->language['PROFILE'];?></span>
							</div>
						</li>
					</a>
					<a href="account/configuration">
						<li>
							<div class="container">
								<span class="icon icon-cog"></span>
								<span class="text"><?=$app->language['CONFIGURATION'];?></span>
							</div>
						</li>
					</a>
					<div class="line"></div>
					<a href="logout">
						<li>
							<div class="container">
								<span class="icon icon-switch"></span>
								<span class="text"><?=$app->language['LOGOUT'];?></span>
							</div>
						</li>
					</a>	
				</ul>
			</div>
			<?php } ?>
			<?php if(isset($app->page['Rm'])) { ?>
			<div id="menu-right">
				<ul id="games-container">
					<li class="coins-num">
						<span class="num">100</span>
						<span class="text">ordors</span>
					</li>	
					<ul>
						<a href="games">
							<li>
								<span class="icon icon-cart"></span>
								<span class="text">Jugar</span>
							</li>
						</a>
						<a href="">
							<li>
								<span class="icon icon-cart"></span>
								<span class="text">Comprar</span>
							</li>
						</a>
					</ul>
				</ul>
				<?php require 'libs/languages.php'; ?>
			</div>
			<?php } ?>
			<div id="sub-container">