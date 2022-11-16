<?php $page_notlogued = 1; ?>
<?php require '../php/app.php'; ?>
<?php require '../php/header.php'; ?>
    <?php unset($_SESSION['signup-step']); ?>
	<main class="container-notLogued">
        <?php if(!isset($_SESSION['password-reset-username']) && !isset($_SESSION['password-reset-username'])) { ?>
            <form method="POST" action="" id="form-login-signup">
                <span class="title"><?=$app->language['RESETPASSWORD'];?></span>
                <?php 
                    if(isset($_GET['by'])) {
                        $by = $_GET['by'];
                        if($by == "email") {
                ?>
                    <input class="form-inputs" id="form-reset-password-input" type="email" name="email" placeholder="<?=$app->language['EMAIL'];?>" />
                    <span class="information-text"><?=$app->language['ENTERRESETEMAIL'];?> (<?=$app->language['EXAMPLECOMP'];?>: juanperez@email.com)</span>
                <?php
                        } elseif($by == "username") {
                ?>
                    <input class="form-inputs" id="form-reset-password-input" type="text" name="username" placeholder="<?=$app->language['USERNAME'];?>" />
                    <span class="information-text"><?=$app->language['ENTERRESETEUSERNAME'];?> (<?=$app->language['EXAMPLECOMP'];?>: juanperez777)</span>
                <?php
                        } else {
                            header('location: '.$app->url.'accounts/password_reset?by=email');
                        }
                    } else {
                        header('location: '.$app->url.'accounts/password_reset?by=email');
                    }
                ?>
                <input type="submit" name="submit" value="<?=$app->language['SEARCHACCOUNT'];?>" />
                <span id="error-on-form"></span>
                <?php
                    if($by == "email") {
                ?>
                    <span class="alert"><a href="accounts/password_reset?by=username"><?=$app->language['SEARCHBYUSERNAME'];?></a></span>
                <?php
                    } elseif($by == "username") {
                ?>
                    <span class="alert"><a href="accounts/password_reset?by=email"><?=$app->language['SEARCHBYEMAIL'];?></a></span>
                <?php
                    }
                ?>
            </form>
	        <script type="text/javascript" src="js/password_reset.js"></script>
        <?php } else { if(isset($_GET['by'])) {header('location: '.$app->url.'accounts/password_reset');} ?>
            <span class="title"><?=$app->language['RESETPASSWORD'];?></span>
        <?php } ?>
        </main>
<?php require '../php/footer.php'; ?>