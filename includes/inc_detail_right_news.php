<div class="right_item">
    <p class="right_title">Tin về dự án <?=$pro_name?></p>
    <ul class="right_news">
        <?
        $db_news = new db_query("SELECT * FROM news 
                                        WHERE new_pro_id = " . intval($pro_id) . "
                                        LIMIT 5");
        while ($rnew    = $db_news->fetch()){
            $linkNews   = gen_link_news_detail($rnew);
            ?>
            <li>
                <a href="<?=$linkNews?>" title="<?=$rnew['new_name']?>">
                    <div>
                        <p class="rn_img"><img src="<?=PATH_IMAGE_NEWS . 'small_' . $rnew['new_image']?>" alt=""></p>
                        <p class="rn_text">
                            <b><?=$rnew['new_name']?></b>
                            <span><?=date('d-m-Y', $rnew['new_date'])?></span>
                        </p>
                    </div>
                </a>
            </li>
            <?
        }
        unset($db_news);
        ?>
    </ul>
</div>