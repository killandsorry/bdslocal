<div class="wrapper">
    <div class="detail">
        <div id="content">
            <div id="content_left">
                <h1 class="title_detail"><?=$new_name?></h1>
                <div class="row_item articles">
                    <p class="time">Đăng ngày: <?=date('d/m/Y', $row['new_date'])?></p>
                    <?=$row['nec_content']?>
                </div>
            </div>
            <div id="content_right">
                <?include 'inc_news_detail_right.php'?>
            </div>
        </div>
    </div>
</div>