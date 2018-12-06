<div class="features">
    <?
    if($row['prd_furniture_living_room'] != ''){
        ?>
        <h3>&#9734; Nội thất phòng khách</h3>
        <div class="row_item">
            <?=$row['prd_furniture_living_room']?>
        </div>
        <?
    }
    ?>
    <?
    if($row['prd_furniture_bed_room'] != ''){
        ?>
        <h3>&#9734; Nội thất phòng ngủ</h3>
        <div class="row_item">
            <?=$row['prd_furniture_bed_room']?>
        </div>
        <?
    }
    ?>
    <?
    if($row['prd_furniture_wc_room'] != ''){
        ?>
        <h3>&#9734; Nội thất phòng vệ sinh</h3>
        <div class="row_item">
            <?=$row['prd_furniture_wc_room']?>
        </div>
        <?
    }
    ?>
    <?
    if($row['prd_furniture_logia_room'] != ''){
        ?>
        <h3>&#9734; Trang trí và thiết kế Logia</h3>
        <div class="row_item">
            <?=$row['prd_furniture_logia_room']?>
        </div>
        <?
    }
    ?>
</div>