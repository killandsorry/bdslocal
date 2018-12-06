<div class="price_policy row">
    <?
    if($row['prd_price'] != ''){
        ?>
        <h2>Giá bán và Tiến độ thanh toán</h2>
        <div class="row_item">
            <?=$row['prd_price']?>
        </div>
        <?
    }
    ?>

    <?
    if($row['prd_policy'] != ''){
        ?>
        <div class="row_item">
            <h2>Chính sách bán hàng, Vay ngân hàng</h2>
            <?=$row['prd_policy']?>
        </div>
        <?
    }
    ?>
</div>

