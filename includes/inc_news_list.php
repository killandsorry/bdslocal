<div class="wrapper">
    <div class="detail">
        <div id="content">
            <div id="content_left">
                <h1 class="list_title"><?=$title?></h1>
                <?
                    // lấy thông tin tất cả dự án đang có chưa phân theo tỉnh thành, cái này sẽ làm sau
                    $db_news    = new db_query("SELECT * 
                                                    FROM news
                                                    WHERE new_active = 1 AND new_cat_id = " . intval($cat_id) . "
                                                    " . $limit);
                    $i = 0;
                    while($rnew = $db_news->fetch()){

                        // class first
                        $class_first = '';

                        // link chi tiết
                        $linkNewDetail   = gen_link_news_detail($rnew);

                        // ảnh đại diện
                        $productsImage  = PATH_IMAGE_NEWS . 'small_' . $rnew['new_image'];

                        if($page == 1 && $i == 0){
                            $class_first = 'first_item';
                            $productsImage  = PATH_IMAGE_NEWS . $rnew['new_image'];
                        }


                            // $new title
                        $new_title      = $rnew['new_title'];



                        ?>
                        <div class="news_items <?=$class_first?>">
                            <a href="<?=$linkNewDetail?>" title="<?=$new_title?>">
                                <img src="<?=$productsImage?>" alt="<?=$new_title?>">
                                <p>
                                    <b><?=$new_title?></b>
                                    <span class="subdes"><?=$rnew['new_description']?></span>
                                    <span class="time">Ngày đăng: <?=date('d/m/Y', $rnew['new_date'])?></span>
                                </p>
                            </a>
                        </div>
                        <?
                        $i++;
                    }
                    unset($db_news);

                if($page <= $num_of_page && $num_of_page > 1){
                    echo '<div class="pagelist">' . generatePageBar($page_prefix, $page, $page_size, $total_record, $page_url, $normal_class, $selected_class, $previous, $next, $first, $last, $break_type, 1) . '</div>';
                }
                ?>
            </div>
            <div id="content_right">

            </div>
        </div>
    </div>
</div>