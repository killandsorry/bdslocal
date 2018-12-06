<div id="find">
    <from method="GET" action="">
        Tôi muốn tìm dự án:
        <input type="text" value="" placeholder="ví dụ: Eco lake view" name="product_name">
        Tại:
        <select name="product_city" id="">
            <?
                for($i =1; $i< 10; $i++){
                    ?>
                    <option value="<?=$i?>">Hà nội 1</option>
                    <?
                }
            ?>
        </select>
        <input type="submit" value="Tìm">
        <input type="hidden" value="find" name="action">
    </from>
</div>