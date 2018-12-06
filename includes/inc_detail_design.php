<div class="design row">
    <h2>Thiết kế <?=$pro_name?></h2>
    <?
    if($row['prd_design'] != ''){
        echo $row['prd_design'];
    }
    ?>

    <?include 'inc_detail_end.php'?>
    <?/*
       <div class="list_image">
            <a href="https://drive.google.com/open?id=1BRhSjscLZHMVI8JVXum1-MyZGS6SDhmd" target="_blank">
                <span><img alt="" src="/uploads/products/skycentral/1.jpg" style="width: 300px; height: 178px;" /></span>
                <span><img alt="" src="/uploads/products/skycentral/2.jpg" style="width: 300px; height: 169px;" /></span>
                <span><img alt="" src="/uploads/products/skycentral/3.jpg" style="width: 300px; height: 169px;" /></span>
                <span><img alt="" src="/uploads/products/skycentral/4.jpg" style="width: 300px; height: 169px;" /></span>
                <span><img alt="" src="/uploads/products/skycentral/5.jpg" style="width: 300px; height: 169px;" /></span>
                <span><img alt="" src="/uploads/products/skycentral/6.jpg" style="width: 300px; height: 169px;" /></span>
            </a>
        </div>
    */?>

</div>