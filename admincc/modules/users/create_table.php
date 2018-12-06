<?
include 'inc_security.php';

$user_id = getValue('user_id', 'int', 'POST', 0);

$arrayReturn   = array(
   'status' => 0,
   'error' => ''
);

if($user_id <= 0){
   exit();
}

$table   = 'user_products_' . $user_id;
$db_check   = new db_query("SHOW TABLES LIKE '". $table ."'");
if(mysqli_fetch_assoc($db_check->result)){
   $arrayReturn['error'] = 'Bảng đã tồn tại';
   echo json_encode($arrayReturn);
   exit();  
}else{
   $create_table_product   = "CREATE TABLE IF NOT EXISTS `user_products_". $user_id ."` (
  `usp_id` int(11) NOT NULL AUTO_INCREMENT,
  `usp_dat_id` int(11) DEFAULT '0',
  `usp_pro_name` varchar(100) DEFAULT NULL,
  `usp_alias` varchar(10) DEFAULT NULL,
  `usp_barcode` varchar(30) DEFAULT NULL,
  `usp_unit` int(11) DEFAULT '0',
  `usp_branch_id` int(11) DEFAULT '0',
  `usp_use_parent_id` int(11) DEFAULT '0',
  `usp_use_child_id` int(11) DEFAULT '0',
  `usp_quantity` int(11) DEFAULT '0',
  `usp_price` double DEFAULT '0',
  `usp_active` int(11) DEFAULT '1',
  `usp_lats_update` int(11) DEFAULT '0',
  `usp_date_expires` int(11) DEFAULT '0',
  PRIMARY KEY (`usp_id`),
  UNIQUE KEY `usp_dat_id` (`usp_dat_id`,`usp_use_parent_id`),
  KEY `pud_use_id` (`usp_use_parent_id`),
  KEY `pud_pro_id` (`usp_dat_id`,`usp_use_parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
   $db_pro  = new db_execute($create_table_product);
   
   $create_table_order = "CREATE TABLE IF NOT EXISTS `user_orders_". $user_id ."` (
  `uso_id` int(11) NOT NULL AUTO_INCREMENT,
  `uso_pro_id` int(11) DEFAULT '0',
  `uso_dat_id` int(11) DEFAULT '0',
  `uso_branch_id` int(11) DEFAULT '0',
  `uso_use_parent_id` int(11) DEFAULT '0',
  `uso_use_child_id` int(11) DEFAULT '0',
  `uso_date` int(11) DEFAULT '0',
  `uso_quantity` int(11) DEFAULT '0',
  `uso_price_out` double DEFAULT NULL,
  `uso_price_import` double DEFAULT NULL,
  `uso_total_money` double DEFAULT NULL,
  `uso_status` int(11) DEFAULT '0',
  PRIMARY KEY (`uso_id`),
  KEY `usd_use_id` (`uso_use_parent_id`),
  KEY `usd_use_id_2` (`uso_use_parent_id`,`uso_status`),
  KEY `usd_use_id_3` (`uso_use_parent_id`,`uso_date`,`uso_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
   $db_order   = new db_execute($create_table_order);
   
   $create_table_stock  = "CREATE TABLE IF NOT EXISTS `user_stock_". $user_id ."` (
  `uss_id` int(11) NOT NULL AUTO_INCREMENT,
  `uss_date` int(11) DEFAULT '0',
  `uss_date_expires` int(11) DEFAULT '0',
  `uss_use_parent_id` int(11) DEFAULT '0',
  `uss_use_child_id` int(11) DEFAULT '0',
  `uss_price_import` double DEFAULT NULL,
  `uss_price_out` double DEFAULT NULL,
  `uss_quantity` int(11) DEFAULT '0',
  `uss_unit` int(11) DEFAULT '0',
  `uss_pro_id` int(11) DEFAULT '0',
  `uss_dat_id` int(11) DEFAULT '0',
  `uss_branch_id` int(11) DEFAULT '0',
  `uss_sold` int(11) DEFAULT '0' COMMENT 'còn lại',
  `uss_bill_name` varchar(255) NOT NULL,
  `uss_bill_code` int(11) NOT NULL DEFAULT '0',
  `uss_status` int(11) NOT NULL DEFAULT '0',
  `uss_trash` int(11) NOT NULL DEFAULT '1' COMMENT '0: đã xóa, 1:chưa xóa',
  `uss_quantity_unit_parent` int(11) NOT NULL DEFAULT '0',
  `uss_quantity_unit_child` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uss_id`),
  KEY `wud_use_id` (`uss_use_parent_id`),
  KEY `wud_use_id_2` (`uss_use_parent_id`,`uss_pro_id`,`uss_sold`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
   $db_stock   = new db_execute($create_table_stock);
   
   unset($db_pro);
   unset($db_order);
   unset($db_stock);
   
   $arrayReturn['status'] = 1;
   echo json_encode($arrayReturn);
   exit(); 
}