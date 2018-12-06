<div class="right_item">
    <p class="right_title">Dự án bạn quan tâm</p>
    <ul class="right_product">
        <?
        $db_example = new db_query("SELECT * FROM products
                                          WHERE pro_id = " . $row['new_pro_id'] . "
                                          LIMIT 1");
        while ($rex = $db_example->fetch()){
            $linkProducts = gen_link_detail($rex);
            ?>
            <li>
                <a href="<?=$linkProducts?>" title="Dự án <?=$rex['pro_name'] . ' ' . $rex['pro_address']?>">
                    <img src="<?=PATH_IMAGE_PRODUCTS . $rex['pro_image']?>" alt="<?=$rex['pro_name'] . ' ' . $rex['pro_address']?>">
                    <div class="right_product_item">
                        <p class="pro_more_name"><b><?=$rex['pro_name']?></b></p>
                        <p class="pro_more_item"><?=$rex['pro_address']?></p>
                        <p class="pro_more_item">Giá từ: <b><?=$rex['pro_price_from'] . ' - ' . $rex['pro_price_to']?> Triệu</b></p>
                    </div>
                </a>
            </li>
            <?
        }
        unset($db_example);
        ?>
    </ul>
</div>