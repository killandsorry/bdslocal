<div class="utilities row" >
    <h2>Tiện ích <?=$pro_name?></h2>
    <?
    if($row['prd_utilities_in'] != ''){
        ?>
        <div class="sub row_item">
            <h3>&#9734; Tiện ích nội khu</h3>
            <?=$row['prd_utilities_in']?>
        </div>
        <?
    }
    ?>
    <?
    if($row['prd_utilities_out'] != ''){
        ?>
        <div class="sub row_item">
            <h3>&#9734; Tiện ích ngoại khu</h3>
            <?=$row['prd_utilities_out']?>
        </div>
        <?
    }
    ?>

</div>