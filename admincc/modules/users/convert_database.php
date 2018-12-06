<?

include 'inc_security.php';

$user_id = getValue('user_id', 'int', 'POST', 0);

$arrayReturn   = array(
   'status' => 0,
   'error' => ''
);

if($user_id <= 0){
   $arrayReturn['error'] = 'Thông tin không đúng';
   echo json_encode($arrayReturn);
   exit();
}

// chuyển từ bảng product sang bảng mới
$table_pro  = 'user_products_' . $user_id;
$db_insert  = new db_execute("INSERT INTO ". $table_pro . " 
                              SELECT * FROM user_products 
                              WHERE usp_use_parent_id = " . intval($user_id));
unset($db_insert);

// chuyển từ bảng order sang bảng mới
$table_order  = 'user_orders_' . $user_id;
$db_insert  = new db_execute("INSERT INTO ". $table_order . " 
                              SELECT * FROM user_orders 
                              WHERE uso_use_parent_id = " . intval($user_id));
unset($db_insert);

// chuyển từ bảng stock sang bảng mới
$table_stock  = 'user_stock_' . $user_id;
$db_insert  = new db_execute("INSERT INTO ". $table_stock . " 
                              SELECT * FROM user_stock 
                              WHERE uss_use_parent_id = " . intval($user_id));
unset($db_insert);

$arrayReturn['status'] = 1;
echo json_encode($arrayReturn);
exit();