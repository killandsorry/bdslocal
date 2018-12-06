<div class="more row">
    <?
    if($row['prd_more'] != ''){
        ?>
        <h2>Đánh giá dự án <?=$pro_name?></h2>
        <div class="row_item">
            <?=$row['prd_more']?>
        </div>
        <?
    }
    ?>
</div>