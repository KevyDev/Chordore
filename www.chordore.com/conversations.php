<?php 
    
    require_once 'php/app.php'; 

	$app->setPage('conversations');
    
?>
<?php require_once 'libs/header.php'; ?>
<div class="conversations-list">
    <?php 
        $conversations = $app->selectConversations(); 
        foreach($conversations as $conversation) {
            ?>
        <div class="conversation">
            <a href="conversations/<?=$conversation['token'];?>">
                <img src="<?=$app->filesLocation;?><?=$conversation['conversation_info']['photo'];?>" />
                <div class="container">
                    <div class="names">
                        <span class="name"><?=$conversation['conversation_info']['name'];?></span>
                        <span class="username">@<?=$conversation['conversation_info']['username'];?></span>
                    </div>  
                    <div class="message_date">
                        <div class="message"><?=$conversation['last_message'];?></div>
                        <div class="date"><?=$conversation['last_message_date'];?></div>
                    </div>  
                </div>
            </a>
            <div class="container">
                <span class="icon-bin"></span>
                <span class="icon-menu"></span>
            </div>
        </div>
        <?php
        } 
    ?>
</div>
<?php require_once 'libs/footer.php'; ?>