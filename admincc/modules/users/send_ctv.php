<?
include 'inc_security.php';
include '../../../classes/messages.php';

$notification  = new messages();

// gửi thông báo đến cộng tác viên
$id   = getValue('id', 'int', 'POST', 0);

$arrayReturn   = array(
   'status' => 0,
   'error' => ''
);

if($id <= 0){
   $arrayReturn['error'] = 'Không có thông tin user';
   echo json_encode($arrayReturn);
   exit();
}

$db_ex   = new db_query("SELECT * FROM users WHERE use_id = " . intval($id) . " LIMIT 1");
if($row  = $db_ex->fetch()){
   
   $title   = 'Khách ' . $row['use_fullname'] . ', Số ĐT: ' . $row['use_phone'] . ' sử dụng thường xuyên'; 
   $des = 'Khách ' . $row['use_fullname'] . ', Số ĐT: ' . $row['use_phone'] . ' là một người sử dụng thường xuyên, bạn cần liên hệ để hỏi thăm nhà thốc này';
   
   $db_user = new db_query("SELECT * FROM users WHERE use_supplier = 1");
   while($row  = $db_user->fetch()){
      $ctv_id  = $row['use_id'];
      $data_msg   = array(
         'title' => $title
         ,'description' => $des
         ,'url' => ''
         ,'action' => NOTI_ACTION_ADD_PRODUCT
         ,'date' => time()
         ,'use_id' => 0
      );
      $data_user   = array($ctv_id); 
      $s = $notification->send($data_msg, $data_user);
      
      // lấy thông tin register của user
      $db_gcm  = new db_query("SELECT * FROM user_gcm WHERE usg_use_id = " . intval($ctv_id), __FILE__, DB_NOTIFICATION);
      while($rgcm  = mysqli_fetch_assoc($db_gcm->result)){
         if($rgcm['usg_register_id'] != ''){
            $message_data  = array(
               'id' => $rgcm['usg_register_id'],
               'body' => $des,
               'title' => 'BQT website quanlybanthuoc.com',
               'url' => 'http://quanlybanthuoc.com/banhang/notification.php'                     
            );
            $send = $notification->gcm($message_data);
            $send = json_decode($send);
            if($send->success == 0){
               $db_ex   = new db_execute("DELETE FROM user_gcm WHERE usg_id = " . $rgcm['usg_id'], __FILE__, DB_NOTIFICATION);
               unset($db_ex);
            }
         }
      }
      unset($db_gcm);
   }
   unset($db_user);
   
   $arrayReturn['status'] = 1;
   echo json_encode($arrayReturn);
   exit();
   
}else{
   $arrayReturn['error'] = 'Không có thông tin user';
   echo json_encode($arrayReturn);
   exit();
}