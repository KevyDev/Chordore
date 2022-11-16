<?php if(isset($app->user)) { ?>
    <form method="POST" action="ajax/post_compose.php" enctype="multipart/form-data" id="form-post-compose">
        <span class="icon-cross" id="post-compose-cancel-button"></span>
        <a href="users/<?=$app->user['username'];?>" class="user-photo">    
            <?php if($app->user['photo']) { ?>
                <img src="<?=$app->user['photo']['url'];?>" />
            <?php } ?>
        </a>
        <textarea id="post-compose-input-text" name="text" placeholder="<?=$app->language['POSTCOMPOSE'];?>" maxlength="<?=$app->postComposeMaxC;?>"><?php if(isset($postComposeTag)) {echo $postComposeTag.' ';} ?></textarea>                
        <input id="post-compose-input-submit" type="submit" name="submit" value="<?=$app->language['POSTENV'];?>" />
        <input id="post-compose-input-image" type="file" name="images[]" accept="<?=$app->imgFormats?>" maxImgs="<?=$app->postComposeMaxImgs;?>" multiple hidden />
        <input id="post-compose-input-privacy" type="number" name="privacy" value="1" hidden />                
        <div id="post-compose-img-visor"></div>
        <div class="options">
            <div class="container" id="post-compose-img">
                <span class="icon icon-images"></span>
                <span class="text">Foto</span>
            </div>
            <div class="privacy-public" id="post-compose-privacy">
                <div class="container privacy-public">
                    <span class="icon icon-earth"></span>
                    <span class="text"><?=$app->language['PUBLIC'];?></span>
                </div>
                <div class="container privacy-friends">
                    <span class="icon icon-users"></span>
                    <span class="text"><?=$app->language['FRIENDS'];?></span>
                </div>
                <div class="container privacy-private">
                    <span class="icon icon-lock"></span>
                    <span class="text"><?=$app->language['PRIVATE'];?></span>
                </div>
            </div>
            <span id="post-compose-characters"><?=$app->postComposeMaxC;?></span>
        </div>
    </form>
    <span class="icon-pencil" id="post-compose-button"></span>
<?php } ?>