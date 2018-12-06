<?
ob_start();
include 'inc_security.php';

$b_id = getValue('bid', 'int', 'POST', 0);

$arrayReturn   = array(
   'status' => 0,
   'data' => ''
);
if($b_id > 0){
   $db_user = new db_query("SELECT * FROM user_branch WHERE usb_use_id = ". intval($b_id));
   while($row  = mysqli_fetch_assoc($db_user->result)){
      echo '<li>'. $row['usb_id'] . ': <a target="_blank" href="//quanlybanthuoc.com/service/test.php?uid='. $b_id .'&brid='. $row['usb_id'] .'">' . $row['usb_name'] . '</a></li>';
   }
}

$html = ob_get_contents();
ob_end_clean();

if($html != ''){
   $arrayReturn   = array(
      'status' => 1,
      'data' => '<ul class="show_list">'. $html .'</ul>'
   );
}

echo json_encode($arrayReturn);
exit();