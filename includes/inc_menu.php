<ul id="navigator">
    <?
    $db_cat = new db_query("SELECT * FROM categories
                                  WHERE cat_active = 1");
    while ($rcat    = $db_cat->fetch()){
        if($rcat['cat_parent_id'] == 0){
            $arrayCat[$rcat['cat_id']]['current'][$rcat['cat_id']] = $rcat;
        }else{
            $arrayCat[$rcat['cat_parent_id']]['child'][$rcat['cat_id']] = $rcat;
        }
    }
    unset($db_cat);

    foreach($arrayCat as $k => $mcat){
        // parent cat name
        $parent_name = $mcat['current'][$k]['cat_name'];

        // link cat parent name
        $linkCat    = gen_link_category($mcat['current'][$k]);
        ?>
        <li>
            <a href="<?=$linkCat?>" title="<?=$parent_name?>"><?=$parent_name?></a>
            <?
            if(!empty($mcat['child'])){
                ?>
                <ul class="sub_menu">
                    <?
                    foreach($mcat['child'] as $ck => $cvalue){
                        $sub_name   = $cvalue['cat_name'];
                        $linkCatSub = gen_link_category($cvalue);
                        ?>
                        <li>
                            <a href="<?=$linkCatSub?>" title="<?=$sub_name?>"><?=$sub_name?></a>
                        </li>
                        <?
                    }
                    ?>
                </ul>
                <?
            }
            ?>
        </li>
        <?
    }

    ?>
</ul>