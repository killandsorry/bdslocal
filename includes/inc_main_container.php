<div class="wrapper">
    <div id="main_list" class="list_product">
        <?
            // lấy thông tin tất cả dự án đang có chưa phân theo tỉnh thành, cái này sẽ làm sau
            $db_products    = new db_query("SELECT * 
                                                    FROM products
                                                    WHERE pro_active = 1");
            while($row_products = $db_products->fetch()){

                // link chi tiết
                $productsLink   = gen_link_detail($row_products);

                // ảnh đại diện
                $productsImage  = PATH_IMAGE_PRODUCTS . $row_products['pro_image'];

                ?>
                <div class="items">
                    <div class="w_item">
                        <a class="w_link" href="<?=$productsLink?>" title="Dự án <?=$row_products['pro_name'] . ' ' . $row_products['pro_address']?>">
                            <div class="item_cover">
                                <img src="<?=$productsImage?>" alt="Dự án <?=$row_products['pro_name'] . ' ' . $row_products['pro_address']?>">
                                <p class="special_start">Khởi công: <?=$row_products['pro_start_time']?></p>
                                <p class="special_end">Bàn giao: <?=$row_products['pro_end_time']?></p>
                            </div>
                            <div class="item_product">
                                <p class="name" href="<?=$productsLink?>" title=""><?=$row_products['pro_name']?></p>
                                <p><?=$row_products['pro_address']?></p>
                                <div class="info">

                                    <p>
                                        <span><?=$row_products['pro_floor']?> tầng</span>
                                        <span><?=$row_products['pro_room']?> căn hộ</span>
                                        <span>Giá: <?=$row_products['pro_price_from']?> - <?=$row_products['pro_price_to']?>t/m2</span>
                                    </p>
                                    <p>
                                        <?=nl2br($row_products['pro_teaser'])?>
                                    </p>
                                </div>

                            </div>
                        </a>
                    </div>

                </div>
                <?
            }
            unset($db_products);
        ?>
    </div>
</div>