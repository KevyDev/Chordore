<?php if(isset($app)) { ?>
    <div id="langs-list">
        <?php  
            for($i = 0; 3 > $i; $i++) {
                $lang = $app->language['_LIST'][$i];
                if($i > 0) {
                    ?>
                        <span> · </span>
                    <?php
                }
                if($lang == $app->language['_SELECTED']) {
                    ?>
                        <span><?=$app->language['_LIST2'][$lang]?></span>
                    <?php
                } else {
                    ?>
                        <a href="language?lang=<?=$lang;?>"><?=$app->language['_LIST2'][$lang]?></a>
                    <?php
                }
            }
        ?>
    </div>
<?php } ?>