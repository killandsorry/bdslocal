<?
require_once("inc_security.php");
$users = array('reset' => 'taikhoan');
$realm	= "Thong tin tai khoan";
function check_authen($recheck = 0){
	global $realm;
	if (empty($_SERVER['PHP_AUTH_DIGEST']) || $recheck == 1) {
	    header('HTTP/1.1 401 Unauthorized');
	    header('WWW-Authenticate: Digest realm="'.$realm.
	           '",qop="auth",nonce="'.uniqid().'",opaque="'.md5($realm).'"');
	    die('Truy cap bi tu choi');
	}
}
// function to parse the http auth header
function http_digest_parse($txt)
{
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    $keys = implode('|', array_keys($needed_parts));

    preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

    foreach ($matches as $m) {
        $data[$m[1]] = $m[3] ? $m[3] : $m[4];
        unset($needed_parts[$m[1]]);
    }

    return $needed_parts ? false : $data;
}

check_authen();

// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']])){
    	check_authen(1);
		die("Xin loi ban ko co quyen");
    }
// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if ($data['response'] != $valid_response){
		check_authen(1);
		die("Xin loi ban ko co quyen");
}


$user_id = getValue('uid');

$array_branch = array();

if($user_id > 0){
   $db_u = new db_query("SELECT * FROM users WHERE use_id = " . intval($user_id) . " LIMIT 1");
   if($ru   = $db_u->fetch()){
      $db_branch  = new db_query("SELECT * FROM user_branch WHERE usb_use_id = " . $ru['use_id']);
      while($rb = $db_branch->fetch()){
         $array_branch[$rb['usb_id']] = $rb;
      }
      unset($db_branch);
   }else{
      die('Không có thông tin');
   }
}else{
   header('location:manager.php');
   exit();
}


$success = 0;
$action  = getValue('action', 'str', 'POST', '');
$branch_id  = getValue('branch_id', 'int', 'POST', 0);
if($action == 'action'){
   if($user_id > 0 && $branch_id > 0){
      
      $db_us   = new db_query("SELECT * FROM users WHERE use_id = " . intval($user_id) . " LIMIT 1");
      if($row  = $db_us->fetch()){
         if($row['use_payment'] == 1){
            $db_del_pro = new db_execute("DELETE FROM user_products_". $user_id ." WHERE usp_use_parent_id =" . intval($user_id) . " AND usp_branch_id = " . intval($branch_id));
            unset($db_del_pro);
            
            $db_del_stock = new db_execute("DELETE FROM user_stock_". $user_id ." WHERE uss_use_parent_id =" . intval($user_id) . " AND uss_branch_id = " . intval($branch_id));
            unset($db_del_stock);
            
            $db_del_order = new db_execute("DELETE FROM user_orders_". $user_id ." WHERE uso_use_parent_id =" . intval($user_id) . " AND uso_branch_id = " . intval($branch_id));
            unset($db_del_order);
         }else{
            $db_del_pro = new db_execute("DELETE FROM user_products WHERE usp_use_parent_id =" . intval($user_id) . " AND usp_branch_id = " . intval($branch_id));
            unset($db_del_pro);
            
            $db_del_stock = new db_execute("DELETE FROM user_stock WHERE uss_use_parent_id =" . intval($user_id) . " AND uss_branch_id = " . intval($branch_id));
            unset($db_del_stock);
            
            $db_del_order = new db_execute("DELETE FROM user_orders WHERE uso_use_parent_id =" . intval($user_id) . " AND uso_branch_id = " . intval($branch_id));
            unset($db_del_order);
         }
         
         // xóa lịch sử hành động
         $db_del_log  = new db_execute("DELETE FROM logs WHERE log_use_parent_id = " . intval($user_id), __FILE__, DB_NOTIFICATION);
         unset($db_del_log);
         
         // xóa chốt doanh số
         $db_del_closebook  = new db_execute("DELETE FROM user_close_book WHERE ucb_parent_id = " . intval($user_id));
         unset($db_del_closebook);
         
         // xóa chuyển kho, nhận kho hàng
         $db_del_mp  = new db_execute("DELETE FROM temp_stocks_move WHERE tsm_use_parent_id = " . intval($user_id));
         unset($db_del_mp);
         
         // xóa công nợ nhà cung cấp
         $db_del_mp  = new db_execute("DELETE FROM provider_money WHERE prm_use_parent_id = " . intval($user_id) . " AND prm_branch_id = " . intval($branch_id));
         unset($db_del_mp);
      }
      unset($db_us);
      
            
      
      $content = date('d/m/Y - H:i', time()) . "\n" . "Admin reset user id : " . $user_id . ' Fullname: ' . $ru['use_fullname'] . "\n \n \n";
      @file_put_contents('../../../logs/reset_'. date('Ymd') .'.cfn', $content, FILE_APPEND);
      $success = 1;
   }
}

if($action == 'quantity'){
   if($user_id > 0 && $branch_id > 0){
      
      $db_us   = new db_query("SELECT * FROM users WHERE use_id = " . intval($user_id) . " LIMIT 1");
      if($row  = $db_us->fetch()){
         if($row['use_payment'] == 1){
            $db_del_pro = new db_execute("UPDATE user_products_". $user_id ." SET usp_quantity = 0, usp_cogs = usp_price_import WHERE usp_use_parent_id =" . intval($user_id) . " AND usp_branch_id = " . intval($branch_id));
            unset($db_del_pro);
            
            $db_del_stock = new db_execute("DELETE FROM user_stock_". $user_id ." WHERE uss_use_parent_id =" . intval($user_id) . " AND uss_branch_id = " . intval($branch_id));
            unset($db_del_stock);
            
            $db_del_order = new db_execute("DELETE FROM user_orders_". $user_id ." WHERE uso_use_parent_id =" . intval($user_id) . " AND uso_branch_id = " . intval($branch_id));
            unset($db_del_order);
         }else{
            $db_del_pro = new db_execute("UPDATE user_products  SET usp_quantity = 0, usp_cogs = usp_price_import WHERE usp_use_parent_id =" . intval($user_id) . " AND usp_branch_id = " . intval($branch_id));
            unset($db_del_pro);
            
            $db_del_stock = new db_execute("DELETE FROM user_stock WHERE uss_use_parent_id =" . intval($user_id) . " AND uss_branch_id = " . intval($branch_id));
            unset($db_del_stock);
            
            $db_del_order = new db_execute("DELETE FROM user_orders WHERE uso_use_parent_id =" . intval($user_id) . " AND uso_branch_id = " . intval($branch_id));
            unset($db_del_order);
         }
         
         // xóa lịch sử hành động
         $db_del_log  = new db_execute("DELETE FROM logs WHERE log_use_parent_id = " . intval($user_id), __FILE__, DB_NOTIFICATION);
         unset($db_del_log);
         
         // xóa chốt doanh số
         $db_del_closebook  = new db_execute("DELETE FROM user_close_book WHERE ucb_parent_id = " . intval($user_id));
         unset($db_del_closebook);
         
         // xóa chuyển kho, nhận kho hàng
         $db_del_mp  = new db_execute("DELETE FROM temp_stocks_move WHERE tsm_use_parent_id = " . intval($user_id));
         unset($db_del_mp);
         
         // xóa công nợ nhà cung cấp
         $db_del_mp  = new db_execute("DELETE FROM provider_money WHERE prm_use_parent_id = " . intval($user_id) . " AND prm_branch_id = " . intval($branch_id));
         unset($db_del_mp);
      }
      unset($db_us);
      
            
      
      $content = date('d/m/Y - H:i', time()) . "\n" . "Admin reset user id : " . $user_id . ' Fullname: ' . $ru['use_fullname'] . "\n \n \n";
      @file_put_contents('../../../logs/product_reset_'. date('Ymd') .'.cfn', $content, FILE_APPEND);
      $success = 1;
   }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?=$load_header?>
<style>
   
</style>
</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<? /*---------Body------------*/ ?>
<!--<form action="quickedit.php?returnurl=<?=base64_encode(getURL())?>" method="post" name="form_listing" id="form_listing" enctype="multipart/form-data">
<input type="hidden" name="iQuick" value="update" />-->

<div id="listing">
   <div style="width:  500px; margin: 0 auto;padding: 50px 10px; line-height: 20px;">
      <?
      if($success == 1) echo '<p style="color: green">Reset thành công</p>';
      ?>
      <p>Reset user: <b><?=$ru['use_fullname']?></b> Hoặc <a href="/qladminbt/modules/users/manager.php">Về trang quản lý</a> </p>
      <table>
         <?
         foreach($array_branch as $id => $br){
            ?>
            <tr>
               <td><?=$br['usb_name']?></td>
               <td>
                  <form method="post" action="">
                     <input type="submit" value="Reset User" /> 
                     <input type="hidden" value="action" name="action" />
                     <input type="hidden" value="<?=$id?>" name="branch_id" />
                  </form>
               </td>
               <td>
                  <form method="post" action="">
                     <input type="submit" value="Reset số lượng" /> 
                     <input type="hidden" value="quantity" name="action" />
                     <input type="hidden" value="<?=$id?>" name="branch_id" />
                  </form>
               </td>
            </tr>
            <?
         }
         ?>
      </table>
   </div>
</div>
</body>
</html>